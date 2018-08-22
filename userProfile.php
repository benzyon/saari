<?php
/**
 * Created by PhpStorm.
 * User: ivanj
 * Date: 17-Feb-17
 * Time: 17:38
 */
require("dbconnect.php");

ini_set("display_errors","On");
$onOwnProfile = false;
$picUrl = "";
$resultChar="";
$alert = "";
$cookieid= "";


$username="";
$desc = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";

if(isset($_COOKIE['username']))
{
    /*header("Location: login.php");*/
    $cookieid = $_COOKIE['id'];
}

if(isset($_POST)&&!empty($_POST))
{
    if(isset($_POST['charName'])&&!empty($_POST['charName']))
    {
        $uid = $_COOKIE['id'];
        $charName = mysqli_real_escape_string($con, $_POST['charName']);
        $nickname = mysqli_real_escape_string($con, $_POST['nickname']);
        $maidenName = mysqli_real_escape_string($con, $_POST['maidenName']);
        $age = mysqli_real_escape_string($con, $_POST['age']);
        $timePeriod = mysqli_real_escape_string($con, $_POST['timePeriod']);
        $location = mysqli_real_escape_string($con, $_POST['location']);
        $race = mysqli_real_escape_string($con, $_POST['race']);
        $height = mysqli_real_escape_string($con, $_POST['height']);
        $weight = mysqli_real_escape_string($con, $_POST['weight']);
        $hairColor = mysqli_real_escape_string($con, $_POST['hairColor']);
        $eyeColor = mysqli_real_escape_string($con, $_POST['eyeColor']);
        $skinColor = mysqli_real_escape_string($con, $_POST['skinColor']);
        $scars = mysqli_real_escape_string($con, $_POST['scars']);
        $birthday = mysqli_real_escape_string($con, $_POST['birthday']);
        $features = mysqli_real_escape_string($con, $_POST['features']);
        $sexuality = mysqli_real_escape_string($con, $_POST['sexuality']);
        $partnerStatus = mysqli_real_escape_string($con, $_POST['partnerStatus']);
        $siblings = mysqli_real_escape_string($con, $_POST['siblings']);
        $parents = mysqli_real_escape_string($con, $_POST['parents']);
        $children = mysqli_real_escape_string($con, $_POST['children']);
        $family = mysqli_real_escape_string($con, $_POST['family']);
        $job = mysqli_real_escape_string($con, $_POST['job']);
        $education = mysqli_real_escape_string($con, $_POST['education']);
        $languages = mysqli_real_escape_string($con, $_POST['languages']);
        $powers = mysqli_real_escape_string($con, $_POST['powers']);
        $talents = mysqli_real_escape_string($con, $_POST['talents']);
        $personality = mysqli_real_escape_string($con, $_POST['personality']);
        $allergies = mysqli_real_escape_string($con, $_POST['allergies']);
        $fears = mysqli_real_escape_string($con, $_POST['fears']);
        $background = mysqli_real_escape_string($con, $_POST['background']);
        $friends = mysqli_real_escape_string($con, $_POST['friends']);
        $enemies = mysqli_real_escape_string($con, $_POST['enemies']);
        $religion = mysqli_real_escape_string($con, $_POST['religion']);
        $outfit = mysqli_real_escape_string($con, $_POST['outfit']);
        $people = mysqli_real_escape_string($con, $_POST['people']);
        $gender = mysqli_real_escape_string($con, $_POST['gender']);
        $descript = mysqli_real_escape_string($con, $_POST['descript']);

        $sql = "INSERT INTO characters (userid,nickname,maidenName,age,gender,timePeriod,location,race,height,weight,hairColor,eyeColor,skinColor,scars,features,birthday,sexuality,partnerStatus,siblings,parents,children,otherFamily,education,job,knownLanguages,powers,talents,personalities,allergies,fears,background,friends,enemies,religion,outfit,peopleMet,name,description) 
            VALUES ('$uid','$nickname','$maidenName','$age','$gender','$timePeriod','$location','$race','$height','$weight','$hairColor','$eyeColor','$skinColor','$scars','$features','$birthday','$sexuality','$partnerStatus','$siblings','$parents','$children','$family','$education','$job','$languages','$powers','$talents','$personality','$allergies','$fears','$background','$friends','$enemies','$religion','$outfit','$people','$charName','$descript')";

        if(!mysqli_query($con,$sql))
        {
            echo mysqli_error($con);
        }
    }

}

if(isset($_GET['uid'])&&!empty($_GET['uid']))
{
    $userid = $_GET['uid'];

    //dont show buttons if not on own profile
    if($userid == $cookieid)
    {
        $onOwnProfile = true;
    }

    //set username
    $userid = mysqli_real_escape_string($con,$userid);
    $sql = 'SELECT * FROM users where id="'.$userid.'"';
    $result = mysqli_query($con,$sql);

    if(mysqli_num_rows($result) == 0)
    {
        header("Location: index.php");
    }

    $row = mysqli_fetch_array($result);
    $username = $row['username'];

    //set description
    $sqlDesc = 'SELECT description FROM userInfo WHERE uid="'.$userid.'"';
    $resultDesc = mysqli_query($con,$sqlDesc);
    if(mysqli_num_rows($resultDesc) != 0)
    {
        $rowDesc = mysqli_fetch_array($resultDesc);
        $desc = wordwrap($rowDesc['description'],80,"<br/>\n",TRUE);
    }

    //set picture url
    $sqlPic = 'SELECT picUrl FROM userInfo WHERE uid="'.$userid.'"';
    $resultPic = mysqli_query($con,$sqlPic);
    $rowPic = mysqli_fetch_assoc($resultPic);
    $picUrl = $rowPic['picUrl'];


    //set characters
    $sqlChar = 'SELECT * FROM characters WHERE userid="'.$userid.'"';

    $resultChar = mysqli_query($con,$sqlChar);

}
else
{
    header("Location: index.php");
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Profile</title>

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
        <br/><br/>
        <div class="row">
            <div class="col-md-12 text-center userName">
                <h3><?php echo $username ?></h3>
                <div class="row userProfilePic">
                    <div class="col-md-6 text-center">
                        <img src="<?php echo $picUrl ?>" width="200px"/ >
                    </div>
                    <div class="col-md-6 text-justify">
                        <p><?php echo $desc ?></p>
                    </div>
                </div>
            </div>
        </div>
        <br/>
        <div class="row">
            <?php
                if($onOwnProfile)
                {
                    echo '<input type="button" class="btn btn-primary btnAddCharacter btnMargs" value="Add New Character">
                          <input type="button" class="btn btn-primary btnEditInfo btnMargs" value="Edit Description">
                          <input type="button" class="btn btn-primary btnAddProfilePic btnMargs" value="Change Profile Picture">
                          <input type="button" class="btn btn-primary btnPassReset btnMargs" value="Change Your Password">
                          <input type="button" class="btn btn-primary btnDeleteUser btnMargs" value="Delete this account">
                          <input type="button" class="btn btn-primary btnLogOut btnMargs" value="Log Out">';
                }
            ?>

            <!--This is the modal for deleting account-->
            <div class="modal" id="deleteAccount" style="display: none; text-align: center">
                <p>Are you sure you want to delete your account?</p>
                <p style="font-weight: bold">*Careful this step is irreversible!</p>
                <input type="button" class="btn btn-primary btnConfirmDelete" value="Confirm">
                <input type="button" class="btn btn-primary btnCancelDelete" value="Cancel">
                <input type="text" value="<?php echo $cookieid ?>" id="cookieId" hidden style="display: none">
            </div>

            <!--This is the modal form for the edit user info-->
            <form action="userProfile.php" method="post" id="editInfo" class="modal" style="display: none">
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea class="form-control" rows="5" id="description" name="description" maxlength="160" required autofocus></textarea>
                </div>
                <button type="submit" class="btn btn-primary" id="btnEditInfoForm">Edit</button>
            </form>

            <!--This is the modal form for the uploadProfilePicture-->
            <div class="uploadProfilePicDiv">
                <form action="userProfile.php?uid=<?php echo $userid?>" method="post" id="changeProfilePic" class="modal" style="display: none" >
                    <div class="form-group inputImage text-center">
                        <label for="picUrl">
                            Picture Url:
                        </label>
                        <input type="text" name="picUrl" id="picUrl" class="form-control" required autofocus>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary" id="btnUploadProfilePic">Upload</button>
                    </div>
                </form>
            </div>

            <!--This is the modal form for adding new character-->
            <form action="userProfile.php?uid=<?php echo $userid?>" method="POST" id="addNewCharacter" class="modal" style="display: none">
                <label>All fields marked with * are required</label>
                <div class="form-group">
                    <label for="charName">Character Name:*</label>
                    <input type="text" class="form-control" id="charName" name="charName" required autofocus>
                </div>
                <div class="form-group">
                    <label for="descript">Description:</label>
                    <input type="text" class="form-control" id="descript" name="descript" >
                </div>
                <div class="form-group">
                    <label for="nickname">Nickname/Alias:</label>
                    <input type="text" class="form-control" id="nickname" name="nickname" >
                </div>
                <div class="form-group">
                    <label for="maidenName">Maiden Name:</label>
                    <input type="text" class="form-control" id="maidenName" name="maidenName">
                </div>
                <div class="form-group">
                    <label for="gender">Gender:*</label>
                    <input type="text" class="form-control" id="gender" name="gender" required>
                </div>
                <div class="form-group">
                    <label for="age">Age:*</label>
                    <input type="text" class="form-control" id="age" name="age" required>
                </div>
                <div class="form-group">
                    <label for="timePeriod">Time Period:*</label>
                    <input type="text" class="form-control" id="timePeriod" name="timePeriod" required>
                </div>
                <div class="form-group">
                    <label for="location">Location:</label>
                    <input type="text" class="form-control" id="location" name="location" >
                </div>
                <div class="form-group">
                    <label for="race">Race/Species/Nationlity:*</label>
                    <input type="text" class="form-control" id="race" name="race" required>
                </div>
                <div class="form-group">
                    <label for="height">Height:</label>
                    <input type="text" class="form-control" id="height" name="height" >
                </div>
                <div class="form-group">
                    <label for="weight">Weight:</label>
                    <input type="text" class="form-control" id="weight" name="weight" >
                </div>
                <div class="form-group">
                    <label for="hairColor">Hair Color:</label>
                    <input type="text" class="form-control" id="hairColor" name="hairColor" >
                </div>
                <div class="form-group">
                    <label for="eyeColor">Eye Color:</label>
                    <input type="text" class="form-control" id="eyeColor" name="eyeColor" >
                </div>
                <div class="form-group">
                    <label for="skinColor">Skin Color:</label>
                    <input type="text" class="form-control" id="skinColor" name="skinColor" >
                </div>
                <div class="form-group">
                    <label for="scars">Scars/Tattoes:</label>
                    <input type="text" class="form-control" id="scars" name="scars" >
                </div>
                <div class="form-group">
                    <label for="features">Other Defining features:</label>
                    <input type="text" class="form-control" id="features" name="features" >
                </div>
                <div class="form-group">
                    <label for="birthday">Birthday:</label>
                    <input type="text" class="form-control" id="birthday" name="birthday" >
                </div>
                <div class="form-group">
                    <label for="sexuality">Sexuality:</label>
                    <input type="text" class="form-control" id="sexuality" name="sexuality" >
                </div>
                <div class="form-group">
                    <label for="partnerStatus">Marital/Partner status:</label>
                    <input type="text" class="form-control" id="partnerStatus" name="partnerStatus" >
                </div>
                <div class="form-group">
                    <label for="siblings">Siblings:</label>
                    <input type="text" class="form-control" id="siblings" name="siblings" >
                </div>
                <div class="form-group">
                    <label for="parents">Parents:</label>
                    <input type="text" class="form-control" id="parents" name="parents" >
                </div>
                <div class="form-group">
                    <label for="children">Children:</label>
                    <input type="text" class="form-control" id="children" name="children" >
                </div>
                <div class="form-group">
                    <label for="family">Other family:</label>
                    <input type="text" class="form-control" id="family" name="family" >
                </div>
                <div class="form-group">
                    <label for="job">Job:</label>
                    <input type="text" class="form-control" id="job" name="job" >
                </div>
                <div class="form-group">
                    <label for="education">Education/Training:</label>
                    <input type="text" class="form-control" id="education" name="education" >
                </div>
                <div class="form-group">
                    <label for="languages">Known Languages:</label>
                    <input type="text" class="form-control" id="languages" name="languages" >
                </div>
                <div class="form-group">
                    <label for="powers">Special abilities/powers:</label>
                    <input type="text" class="form-control" id="powers" name="powers" >
                </div>
                <div class="form-group">
                    <label for="talents">Talents/Hobbies:</label>
                    <input type="text" class="form-control" id="talents" name="talents" >
                </div>
                <div class="form-group">
                    <label for="personality">Personality:</label>
                    <input type="text" class="form-control" id="personality" name="personality" >
                </div>
                <div class="form-group">
                    <label for="allergies">Allergies:</label>
                    <input type="text" class="form-control" id="allergies" name="allergies" >
                </div>
                <div class="form-group">
                    <label for="fears">Fears:</label>
                    <input type="text" class="form-control" id="fears" name="fears" >
                </div>
                <div class="form-group">
                    <label for="background">Background/Backstory:</label>
                    <input type="text" class="form-control" id="background" name="background" >
                </div>
                <div class="form-group">
                    <label for="friends">Friends from their story:</label>
                    <input type="text" class="form-control" id="friends" name="friends" >
                </div>
                <div class="form-group">
                    <label for="enemies">Enemies from their story:</label>
                    <input type="text" class="form-control" id="enemies" name="enemies" >
                </div>
                <div class="form-group">
                    <label for="religion">Religion:</label>
                    <input type="text" class="form-control" id="religion" name="religion" >
                </div>
                <div class="form-group">
                    <label for="outfit">Typical outfit:</label>
                    <input type="text" class="form-control" id="outfit" name="outfit" >
                </div>
                <div class="form-group">
                    <label for="people">People met in Rp:</label>
                    <input type="text" class="form-control" id="people" name="people" >
                </div>
                <button type="submit" class="btn btn-primary">Create</button>
            </form>
        </div>
        <br/>
        <div class="row addCharacterInUser">
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
</body>
</html>
