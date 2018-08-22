<?php
/**
 * Created by PhpStorm.
 * User: ivanj
 * Date: 28-Feb-17
 * Time: 10:12
 */
require("dbconnect.php");
$cookieid = "";
if(isset($_COOKIE['username']))
{
    /*header("Location: login.php");*/
    $cookieid = $_COOKIE['id'];

}

$selectUsersSql='SELECT * FROM userInfo ORDER BY id DESC';

$result = mysqli_query($con,$selectUsersSql);


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>All Users</title>

    <!-- Jquery -->
    <script src="js/jquery-3.1.1.js"></script>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.min.js"></script>

    <!-- Custom css -->
    <link rel="stylesheet" href="css/main.css">

    <!-- Custom script file -->
    <script src="js/scripts.js"></script>

    <!-- Jquery Modal js & css -->
    <script src="js/jquery.modal.min.js"></script>
    <link rel="stylesheet" href="css/jquery.modal.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-1">
                <a href="index.php">
                    <input type="button" value="Home" class="btn btn-primary linkToHome">
                </a>
            </div>
        </div>
        <div class="row">
            <br/><br/>
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1 id="mainH1">All Users</h1>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php
                while($rowUser=mysqli_fetch_assoc($result)) {
                    $id = $rowUser['uid'];

                    $usernameSql = 'SELECT username FROM users WHERE id="'.$id.'"';
                    $resultName = mysqli_query($con,$usernameSql);
                    $rowName = mysqli_fetch_assoc($resultName);
                    $username = $rowName['username'];

                    $charStory = wordwrap($rowUser['description'],25,"<br/>\n",TRUE);
                    if($charStory == "")
                    {
                        $charStory = "This is the description text.Say a few words about your character. Max char limit is 160.";
                    }

                    $imgUrl = $rowUser['picUrl'];
                    $char = <<<ch
                    <div class="col-md-3 userCharacterSlots">
                        <div class="row">
                            <div class="col-md-12 userCharacterSlotsPicture" style="background-image: url($imgUrl);background-size: cover;background-repeat-x: no-repeat;background-position: center">
                    </div>
                    <p><a href="userProfile.php?uid=$id">$username</a>
                    <p style="color: #1b6d85"> $charStory </p>
                    </p>
                    </div>
                    </div>
ch;
                    echo $char;
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
