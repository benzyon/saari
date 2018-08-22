<?php
/**
 * Created by PhpStorm.
 * User: ivanj
 * Date: 19-Feb-17
 * Time: 15:22
 */
require("dbconnect.php");
require ("helpers.php");

$picUrl = "";
$heOwnsChar = false;
$cookieid= "";
if(isset($_COOKIE['username']))
{
    /*header("Location: login.php");*/
    $cookieid = $_COOKIE['id'];
}

if(isset($_GET['cid'])&&!empty($_GET['cid']))
{
    $charId = mysqli_real_escape_string($con,$_GET['cid']);
    $userId = $cookieid;
    $sql = 'SELECT * FROM characters WHERE id="'.$charId.'"';

    $result = mysqli_query($con,$sql);
    if(mysqli_num_rows($result) == 0)
    {
        header("Location: index.php");
    }

    $row = mysqli_fetch_array($result);

    if($row['userid'] == $userId)
    {
        $heOwnsChar = true;
    }

    $currentOwner = checkifempty($row['userid']);
    $charName = checkifempty($row['name']);
    $nickname = checkifempty($row['nickname']);
    $maidenName = checkifempty($row['maidenName']);
    $age = checkifempty($row['age']);
    $timePeriod = checkifempty($row['timePeriod']);
    $location = checkifempty($row['location']);
    $race = checkifempty($row['race']);
    $height = checkifempty($row['height']);
    $weight = checkifempty($row['weight']);
    $hairColor = checkifempty($row['hairColor']);
    $eyeColor = checkifempty($row['eyeColor']);
    $skinColor = checkifempty($row['skinColor']);
    $scars = checkifempty($row['scars']);
    $birthday = checkifempty($row['birthday']);
    $features = checkifempty($row['features']);
    $sexuality = checkifempty($row['sexuality']);
    $partnerStatus = checkifempty($row['partnerStatus']);
    $siblings = checkifempty($row['siblings']);
    $parents = checkifempty($row['parents']);
    $children = checkifempty($row['children']);
    $family = checkifempty($row['otherFamily']);
    $job = checkifempty($row['job']);
    $education = checkifempty($row['education']);
    $languages = checkifempty($row['knownLanguages']);
    $powers = checkifempty($row['powers']);
    $talents = checkifempty($row['talents']);
    $personality = checkifempty($row['personalities']);
    $allergies = checkifempty($row['allergies']);
    $fears = checkifempty($row['fears']);
    $background = checkifempty($row['background']);
    $friends = checkifempty($row['friends']);
    $enemies = checkifempty($row['enemies']);
    $religion = checkifempty($row['religion']);
    $outfit = checkifempty($row['outfit']);
    $people = checkifempty($row['peopleMet']);
    $gender = checkifempty($row['gender']);
    $description = wordwrap($row['description'],80,"<br/>\n",TRUE);

    $picUrl = $row['picUrl'];

    if($description == "")
    {
        $description = "This is the description text.Say a few words about your character. Max char limit is 160.";
    }

    $getOwnerSQL = 'SELECT username FROM users WHERE id="'.$currentOwner.'"';
    $res = mysqli_query($con,$getOwnerSQL);
    $nameRow = mysqli_fetch_array($res);
    $ownerName = $nameRow['username'];


    $sqlPicLinks = 'SELECT * FROM charactersPictures WHERE cid="'.$charId.'"';
    $resLinks = mysqli_query($con,$sqlPicLinks);
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
    <title>Character Profile</title>

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
            <h3><a href="userProfile.php?uid=<?php echo $currentOwner ?>"><?php echo $ownerName ?>'s Character</a></h3>
            <div class="row userProfilePic">
                <div class="col-md-6 text-center">
                    <p><?php echo $charName ?></p>
                    <img src="<?php echo $picUrl ?>" width="200px" style="margin: 0px"/ >
                </div>
                <div class="col-md-6 text-justify">
                    <div class="row">
                        <div class="col-md-12">
                            <p><?php echo $description ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="pictureLinks">Other picture links:</label>
                            <div id="pictureLinks">
                                <?php
                                    $counter = 1;
                                    while($row = mysqli_fetch_array($resLinks))
                                    {
                                        $link = $row['link'];
                                        $cid = $row['id'];
                                        if($heOwnsChar)
                                        {
                                            echo '<a href="'.$link.'" target="_blank">Picture '.$counter.'</a>
                                            <img src="img/discardLink.png" id="'.$cid.'" width="20px" height="20px" class="removeLink"></img><br/>';
                                        }
                                        else
                                        {
                                            echo '<a href="'.$link.'" target="_blank">Picture '.$counter.'</a></br>';
                                        }

                                        $counter++;
                                    }
                                ?>
                            </div>
                            <?php
                                if($heOwnsChar)
                                {
                                    echo '<input type="button" class="btn btn-primary btnAddPicLink" value="Add picture link">';
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br/>
    <div class="row">
        <!--button row-->
        <div class="col-md-12">
            <?php
                if($heOwnsChar)
                {
                    echo '<input type="button" class="btn btn-primary btnDeleteChar btnMargs" value="Delete this character">
                          <input type="button" class="btn btn-primary btnEditCharDesc btnMargs" value="Edit description">
                          <input type="button" class="btn btn-primary btnEditCharAttr btnMargs" value="Edit Attributes">
                          <input type="button" class="btn btn-primary btnChangeCharPic btnMargs" value="Change Picture">';
                }
            ?>
        </div>
    </div>
    <br/>
    <div class="row">
        <!--Attributes row-->
        <div class="col-md-3 charAttr text-justify">
            <p id="charAttrName">Nickname/alias</p>
            <label id="charAttrVal"><?php echo $nickname ?></label>
            <div class="row">
                <div class="col-md-12 charAttrBorder"></div>
            </div>
        </div>
        <div class="col-md-3 charAttr text-justify">
            <p id="charAttrName">Maiden name</p>
            <label id="charAttrVal"><?php echo $maidenName ?></label>
            <div class="row">
                <div class="col-md-12 charAttrBorder"></div>
            </div>
        </div>
        <div class="col-md-3 charAttr text-justify">
            <p id="charAttrName">Age</p>
            <label id="charAttrVal"><?php echo $age ?></label>
            <div class="row">
                <div class="col-md-12 charAttrBorder"></div>
            </div>
        </div>
        <div class="col-md-3 charAttr text-justify">
            <p id="charAttrName">Gender</p>
            <label id="charAttrVal"><?php echo $gender ?></label>
            <div class="row">
                <div class="col-md-12 charAttrBorder"></div>
            </div>
        </div>
        <div class="col-md-3 charAttr text-justify">
            <p id="charAttrName">Time period</p>
            <label id="charAttrVal"><?php echo $timePeriod ?></label>
            <div class="row">
                <div class="col-md-12 charAttrBorder"></div>
            </div>
        </div>
        <div class="col-md-3 charAttr text-justify">
            <p id="charAttrName">Location</p>
            <label id="charAttrVal"><?php echo $location ?></label>
            <div class="row">
                <div class="col-md-12 charAttrBorder"></div>
            </div>
        </div>
        <div class="col-md-3 charAttr text-justify">
            <p id="charAttrName">Race/Species/Nationality</p>
            <label id="charAttrVal"><?php echo $race ?></label>
            <div class="row">
                <div class="col-md-12 charAttrBorder"></div>
            </div>
        </div>
        <div class="col-md-3 charAttr text-justify">
            <p id="charAttrName">Height</p>
            <label id="charAttrVal"><?php echo $height ?></label>
            <div class="row">
                <div class="col-md-12 charAttrBorder"></div>
            </div>
        </div>
        <div class="col-md-3 charAttr text-justify">
            <p id="charAttrName">Weight</p>
            <label id="charAttrVal"><?php echo $weight ?></label>
            <div class="row">
                <div class="col-md-12 charAttrBorder"></div>
            </div>
        </div>
        <div class="col-md-3 charAttr text-justify">
            <p id="charAttrName">Hair color</p>
            <label id="charAttrVal"><?php echo $hairColor ?></label>
            <div class="row">
                <div class="col-md-12 charAttrBorder"></div>
            </div>
        </div>
        <div class="col-md-3 charAttr text-justify">
            <p id="charAttrName">Eye color</p>
            <label id="charAttrVal"><?php echo $eyeColor ?></label>
            <div class="row">
                <div class="col-md-12 charAttrBorder"></div>
            </div>
        </div>
        <div class="col-md-3 charAttr text-justify">
            <p id="charAttrName">Skin color</p>
            <label id="charAttrVal"><?php echo $skinColor ?></label>
            <div class="row">
                <div class="col-md-12 charAttrBorder"></div>
            </div>
        </div>
        <div class="col-md-3 charAttr text-justify">
            <p id="charAttrName">Scars/Tattoos</p>
            <label id="charAttrVal"><?php echo $scars ?></label>
            <div class="row">
                <div class="col-md-12 charAttrBorder"></div>
            </div>
        </div>
        <div class="col-md-3 charAttr text-justify">
            <p id="charAttrName">Other Defining features</p>
            <label id="charAttrVal"><?php echo $features ?></label>
            <div class="row">
                <div class="col-md-12 charAttrBorder"></div>
            </div>
        </div>
        <div class="col-md-3 charAttr text-justify">
            <p id="charAttrName">Birthday</p>
            <label id="charAttrVal"><?php echo $birthday ?></label>
            <div class="row">
                <div class="col-md-12 charAttrBorder"></div>
            </div>
        </div>
        <div class="col-md-3 charAttr text-justify">
            <p id="charAttrName">Sexuality</p>
            <label id="charAttrVal"><?php echo $sexuality ?></label>
            <div class="row">
                <div class="col-md-12 charAttrBorder"></div>
            </div>
        </div>
        <div class="col-md-3 charAttr text-justify">
            <p id="charAttrName">Marital/Partner status</p>
            <label id="charAttrVal"><?php echo $partnerStatus ?></label>
            <div class="row">
                <div class="col-md-12 charAttrBorder"></div>
            </div>
        </div><div class="col-md-3 charAttr text-justify">
            <p id="charAttrName">Siblings</p>
            <label id="charAttrVal"><?php echo $siblings ?></label>
            <div class="row">
                <div class="col-md-12 charAttrBorder"></div>
            </div>
        </div>
        <div class="col-md-3 charAttr text-justify">
            <p id="charAttrName">Parents</p>
            <label id="charAttrVal"><?php echo $parents ?></label>
            <div class="row">
                <div class="col-md-12 charAttrBorder"></div>
            </div>
        </div>
        <div class="col-md-3 charAttr text-justify">
            <p id="charAttrName">Children</p>
            <label id="charAttrVal"><?php echo $children ?></label>
            <div class="row">
                <div class="col-md-12 charAttrBorder"></div>
            </div>
        </div>
        <div class="col-md-3 charAttr text-justify">
            <p id="charAttrName">Other Family</p>
            <label id="charAttrVal"><?php echo $family ?></label>
            <div class="row">
                <div class="col-md-12 charAttrBorder"></div>
            </div>
        </div>
        <div class="col-md-3 charAttr text-justify">
            <p id="charAttrName">Job</p>
            <label id="charAttrVal"><?php echo $job ?></label>
            <div class="row">
                <div class="col-md-12 charAttrBorder"></div>
            </div>
        </div>
        <div class="col-md-3 charAttr text-justify">
            <p id="charAttrName">Education/Training</p>
            <label id="charAttrVal"><?php echo $education ?></label>
            <div class="row">
                <div class="col-md-12 charAttrBorder"></div>
            </div>
        </div>
        <div class="col-md-3 charAttr text-justify">
            <p id="charAttrName">Known Languages</p>
            <label id="charAttrVal"><?php echo $languages ?></label>
            <div class="row">
                <div class="col-md-12 charAttrBorder"></div>
            </div>
        </div>
        <div class="col-md-3 charAttr text-justify">
            <p id="charAttrName">Special abilities/Powers</p>
            <label id="charAttrVal"><?php echo $powers ?></label>
            <div class="row">
                <div class="col-md-12 charAttrBorder"></div>
            </div>
        </div>
        <div class="col-md-3 charAttr text-justify">
            <p id="charAttrName">Talents/Hobbies</p>
            <label id="charAttrVal"><?php echo $talents ?></label>
            <div class="row">
                <div class="col-md-12 charAttrBorder"></div>
            </div>
        </div>
        <div class="col-md-3 charAttr text-justify">
            <p id="charAttrName">Personality</p>
            <label id="charAttrVal"><?php echo $personality ?></label>
            <div class="row">
                <div class="col-md-12 charAttrBorder"></div>
            </div>
        </div>
        <div class="col-md-3 charAttr text-justify">
            <p id="charAttrName">Allergies</p>
            <label id="charAttrVal"><?php echo $allergies ?></label>
            <div class="row">
                <div class="col-md-12 charAttrBorder"></div>
            </div>
        </div>
        <div class="col-md-3 charAttr text-justify">
            <p id="charAttrName">Fears</p>
            <label id="charAttrVal"><?php echo $fears ?></label>
            <div class="row">
                <div class="col-md-12 charAttrBorder"></div>
            </div>
        </div>
        <div class="col-md-3 charAttr text-justify">
            <p id="charAttrName">Background/Backstory</p>
            <label id="charAttrVal"><?php echo $background ?></label>
            <div class="row">
                <div class="col-md-12 charAttrBorder"></div>
            </div>
        </div>
        <div class="col-md-3 charAttr text-justify">
            <p id="charAttrName">Friends from their story</p>
            <label id="charAttrVal"><?php echo $friends ?></label>
            <div class="row">
                <div class="col-md-12 charAttrBorder"></div>
            </div>
        </div>
        <div class="col-md-3 charAttr text-justify">
            <p id="charAttrName">Enemies from their story</p>
            <label id="charAttrVal"><?php echo $enemies ?></label>
            <div class="row">
                <div class="col-md-12 charAttrBorder"></div>
            </div>
        </div>
        <div class="col-md-3 charAttr text-justify">
            <p id="charAttrName">Religion</p>
            <label id="charAttrVal"><?php echo $religion ?></label>
            <div class="row">
                <div class="col-md-12 charAttrBorder"></div>
            </div>
        </div>
        <div class="col-md-3 charAttr text-justify">
            <p id="charAttrName">Typical outfit</p>
            <label id="charAttrVal"><?php echo $outfit ?></label>
            <div class="row">
                <div class="col-md-12 charAttrBorder"></div>
            </div>
        </div>
        <div class="col-md-3 charAttr text-justify">
            <p id="charAttrName">People met in Rp</p>
            <label id="charAttrVal"><?php echo $people ?></label>
            <div class="row">
                <div class="col-md-12 charAttrBorder"></div>
            </div>
        </div>
    </div>

    <!--modal and input -->
    <input type="text" name="charId" id="charId" value="<?php echo $charId ?>" hidden>
    <input type="text" name="userId" id="userId" value="<?php echo $userId ?>" hidden>

    <!--modal for char description-->
    <form action="userProfile.php" method="post" id="editCharDesc" class="modal" style="display: none">
        <div class="form-group">
            <label for="charDesc">Description:</label>
            <textarea class="form-control" rows="5" id="charDesc" name="charDesc" maxlength="160" required autofocus></textarea>
        </div>
        <button type="submit" class="btn btn-primary" id="btnEditCharDescForm">Edit</button>
    </form>

    <!--modal for changing attributes-->
    <form action="userProfile.php" method="post" id="editCharAttributeForm" class="modal" style="display: none">
        <div class="form-group">
            <label for="charSelectAttr">Select the attribute to change:</label>
            <select id="charSelectAttr" name="charSelectAttr" required class="form-control">
                <option value="1">Maiden name</option>
                <option value="2">Age</option>
                <option value="3">Gender</option>
                <option value="4">Time period</option>
                <option value="5">Location</option>
                <option value="6">Race/Species/Nationality</option>
                <option value="7">Height</option>
                <option value="8">Weight</option>
                <option value="9">Hair color</option>
                <option value="10">Eye color</option>
                <option value="11">Skin color</option>
                <option value="12">Scars/Tattoos</option>
                <option value="13">Other Defining features</option>
                <option value="14">Birthday</option>
                <option value="15">Sexuality</option>
                <option value="16">Marital/Partner status</option>
                <option value="17">Siblings</option>
                <option value="18">Parents</option>
                <option value="19">Children</option>
                <option value="20">Other Family</option>
                <option value="21">Job</option>
                <option value="22">Education/Training</option>
                <option value="23">Known Languages</option>
                <option value="24">Special abilities/Powers</option>
                <option value="25">Talents/Hobbies</option>
                <option value="26">Personality</option>
                <option value="27">Allergies</option>
                <option value="28">Fears</option>
                <option value="29">Background/Backstory</option>
                <option value="30">Friends from their story</option>
                <option value="31">Enemies from their story</option>
                <option value="32">Religion</option>
                <option value="33">Typical outfit</option>
                <option value="34">People met in Rp</option>
                <option value="35">Nickname</option>
            </select>
        </div>
        <div class="form-group">
            <label for="newAttr">New Value</label>
            <input type="text" class="form-control" id="newAttr" name="newAttr" required>
        </div>

        <button type="submit" class="btn btn-primary" id="btnChangeCharAttr">Edit</button>
    </form>

    <!--This is the modal form for the uploadProfilePicture-->
    <div class="uploadProfilePicDiv">
        <form action="userProfile.php?uid=<?php echo $userid?>" method="post" id="changeCharPicture" class="modal" style="display: none" >
            <div class="form-group text-center">
                <label for="charPicUrl">
                    Picture Url:
                </label>
                <input type="text" name="charPicUrl" id="charPicUrl" class="form-control" required autofocus>
            </div>
            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary" id="btnUploadCharPicture">Upload</button>
            </div>
        </form>
    </div>

    <!--This is the modal form for the add picture link-->
    <div class="uploadProfilePicDiv">
        <form action="userProfile.php?uid=<?php echo $userid?>" method="post" id="addPicLink" class="modal" style="display: none" >
            <div class="form-group text-center">
                <label for="picLink">
                    Picture Url:
                </label>
                <input type="text" name="picLink" id="picLink" class="form-control" required autofocus>
            </div>
            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary" id="btnAddLink">Add Link</button>
            </div>
        </form>
    </div>

</div>
</body>
</html>
