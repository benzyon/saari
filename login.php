<?php
/**
 * Created by PhpStorm.
 * User: ivanj
 * Date: 16-Feb-17
 * Time: 16:43
 */
/*ini_set('display_errors','On');*/
ini_set('session.save_path','/storage/h6/679/813679/tmp/');
require("dbconnect.php");

$alert="";

if(isset($_POST)&&!empty($_POST))
{
    $username = mysqli_real_escape_string($con,$_POST['username']);
    $password = $_POST['password'];
    $crypt = crypt($password,'island');

    $query = 'SELECT * FROM users WHERE username="'.$username.'" AND password="'.$crypt.'"';
    $result = mysqli_query($con,$query);
    $rowcount = mysqli_num_rows($result);
    $row = mysqli_fetch_array($result);

    if($rowcount == 0)
    {
        $alert= <<<al
        <div class="alert alert-block alert-error fade in" style="text-align:center">
		    <button type="button" class="close" data-dismiss="alert">×</button>
		    The profile doesn't exist or the username password combination is wrong!
        </div>
al;
    }
    else
    {
        $cookie_username=$row['username'];
        $cookie_id=$row['id'];
        setcookie("username",$cookie_username,time()+86400);
        setcookie("id",$cookie_id,time()+86400);
        $url='index.php';
        $alert= <<<al
        <div class="alert alert-block alert-success fade in" style="text-align:center">
		    <button type="button" class="close" data-dismiss="alert">×</button>
			Successfully logged in!       
		</div>
al;
        echo '<META HTTP-EQUIV=REFRESH CONTENT="1; '.$url.'">';
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
    <title>Login</title>

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
            <h1 id="mainH1">Login</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-md-offset-4 text-center">
            <br/>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" required autofocus>
                </div>
                <div class="form-group">
                    <label for="pwd">Password:</label>
                    <input type="password" class="form-control" id="pwd" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
            <?php echo $alert ?>
        </div>
    </div>
</div>
</body>
</html>
