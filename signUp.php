<?php
/**
 * Created by PhpStorm.
 * User: ivanj
 * Date: 16-Feb-17
 * Time: 00:09
 */
require("dbconnect.php");

$alert="";

if(isset($_POST) && !empty($_POST))
{
    $username = mysqli_real_escape_string($con,$_POST['username']);
    $password = $_POST['password'];
    $crypt = crypt($password,'island');

    $query = 'SELECT * FROM users WHERE username="'.$username.'"';
    $result = mysqli_query($con,$query);
    $rowcount = mysqli_num_rows($result);

    if($rowcount != 0)
    {
        $alert= <<<al
        <div class="alert alert-block alert-error fade in">
		    <button type="button" class="close" data-dismiss="alert">×</button>
		    Username is already taken!
        </div>
al;
    }
    else
    {
        $sql = "INSERT INTO users(username,password) VALUES ('$username','$crypt')";
        if(mysqli_query($con,$sql))
        {
            $lastId = mysqli_insert_id($con);
            $sqlLast = "INSERT INTO userInfo (uid) VALUES ('$lastId')";
            if(mysqli_query($con,$sqlLast))
            {
                $alert= <<<al
        <div class="alert alert-block alert-success fade in">
		    <button type="button" class="close" data-dismiss="alert">×</button>
		    Successfully registered! <br/>
		    In 5 seconds you will be redirected to the login page!
        </div>
al;

                $url='login.php';
                echo '<META HTTP-EQUIV=REFRESH CONTENT="5; '.$url.'">';
            }

        }
        else
        {
            $alert= <<<al
        <div class="alert alert-block alert-error fade in">
		    <button type="button" class="close" data-dismiss="alert">×</button>
		    Error connecting with the database! Please try again later!
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
    <title>Sign Up</title>

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
                <h1 id="mainH1">Sign Up</h1>
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
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
                <?php echo $alert ?>
            </div>
        </div>
    </div>
</body>
</html>
