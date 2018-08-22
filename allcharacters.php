<?php
/**
 * Created by PhpStorm.
 * User: ivanj
 * Date: 28-Feb-17
 * Time: 10:30
 */
require("dbconnect.php");
$cookieid = "";
if(isset($_COOKIE['username']))
{
    /*header("Location: login.php");*/
    $cookieid = $_COOKIE['id'];
}

$getCharsSql = 'SELECT * FROM characters ORDER BY id DESC';
$resultChar = mysqli_query($con,$getCharsSql);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>All Characters</title>
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
                <h1 id="mainH1">All Characters</h1>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php
            while($rowChar=mysqli_fetch_assoc($resultChar)) {

                $charName1 = $rowChar['name'];
                $charNickname = $rowChar['nickname'];
                if($charNickname == "")
                {
                    $charNickname = "Character Nickname";
                }
                $charStory = wordwrap($rowChar['description'],25,"<br/>\n",TRUE);
                if($charStory == "")
                {
                    $charStory = "This is the description text.Say a few words about your character. Max char limit is 160.";
                }
                $charId = $rowChar['id'];

                $imgUrl = $rowChar['picUrl'];
                $char = <<<ch
                    <div class="col-md-3 userCharacterSlots">
                        <div class="row">
                            <div class="col-md-12 userCharacterSlotsPicture" style="background-image: url($imgUrl);background-size: cover;background-repeat-x: no-repeat;background-position: center">
                    </div>
                    <p><a href="characterProfile.php?cid=$charId">$charName1</a>
                    <p style="color: darkslategray"> $charNickname </p>
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
</div>
</body>
</html>
