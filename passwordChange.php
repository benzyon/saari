<?php
/**
 * Created by PhpStorm.
 * User: ivanj
 * Date: 20-Feb-17
 * Time: 23:34
 */
require("dbconnect.php");
$alert = "";
if(!isset($_COOKIE))
{
    header("Location: login.php");
}
if(isset($_POST['currentPass'])&&!empty($_POST['currentPass']))
{
    $userId = $_COOKIE['id'];
    $currentPass = mysqli_real_escape_string($con,$_POST['currentPass']);
    $newPass = mysqli_real_escape_string($con,$_POST['newPass']);
    $cryptCurrent = crypt($currentPass,'island');

    $sql = 'SELECT * FROM users WHERE id="'.$userId.'" AND password="'.$cryptCurrent.'"';
    $result = mysqli_query($con,$sql);
    if(mysqli_num_rows($result) == 0)
    {
        $alert= <<<al
        <div class="alert alert-block alert-error fade in">
		    <button type="button" class="close" data-dismiss="alert">×</button>
		    Current password is incorrect. Please try again!
        </div>
al;
    }
    elseif ($currentPass == $newPass)
    {
        $alert= <<<al
        <div class="alert alert-block alert-error fade in">
		    <button type="button" class="close" data-dismiss="alert">×</button>
		    Current password and new password must not be the same!
        </div>
al;
    }
    else
    {
        $cryptNew = crypt($newPass,'island');
        $insertSql = 'UPDATE users SET password="'.$cryptNew.'" WHERE id="'.$userId.'"';

        if(mysqli_query($con,$insertSql))
        {
            $alert= <<<al
        <div class="alert alert-block alert-success fade in">
		    <button type="button" class="close" data-dismiss="alert">×</button>
		    Password changed you will be redirected to login page in 3 seconds!
        </div>
al;
            setcookie("username","",time()-3600);
            setcookie("id","",time()-3600);

            $url='login.php';
            echo '<META HTTP-EQUIV=REFRESH CONTENT="3; '.$url.'">';
        }
        else
        {
            $alert= <<<al
        <div class="alert alert-block alert-error fade in">
		    <button type="button" class="close" data-dismiss="alert">×</button>
		    Something wrong with the database. Try again later!
        </div>
al;
        }
    }


}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Password Reset</title>

    <!-- Jquery -->
    <script src="js/jquery-3.1.1.js"></script>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.min.js"></script>

    <!-- Custom css -->
    <link rel="stylesheet" href="css/main.css">

</head>
<body style="background: #f2f2f2">
<div class="container">
    <br/><br/>
    <div class="row">
        <div class="col-md-12 text-center">
            <h1 id="mainH1">Password Reset</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-md-offset-4 text-center">
            <br/>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="currentPass">Current Password:</label>
                    <input type="password" class="form-control" id="currentPass" name="currentPass" required autofocus>
                </div>
                <div class="form-group">
                    <label for="newPass">New Password:</label>
                    <input type="password" class="form-control" id="newPass" name="newPass" required>
                </div>
                <button type="submit" class="btn btn-primary">Change Password</button>
            </form>
            <?php echo $alert ?>
        </div>
    </div>
</div>
</body>
</html>
