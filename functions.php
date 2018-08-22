<?php
/**
 * Created by PhpStorm.
 * User: ivanj
 * Date: 17-Feb-17
 * Time: 20:20
 */
require("dbconnect.php");

if(isset($_POST['data'])&&!empty($_POST['data']))
{
    $data = $_POST['data'];

    switch ($data){
        case "logout":
            function logout(){
                setcookie("username","",time()-3600);
                setcookie("id","",time()-3600);
                echo "OK";
            }
            logout();
            break;
        case "editUserDesc":

            $uid = $_COOKIE['id'];

            $picUrl = "none";

            $desc = $_POST['desc'];

            $sqlIfExsists = 'SELECT * FROM userInfo WHERE uid = "'.$uid.'"';

            $result = mysqli_query($con,$sqlIfExsists);

            $numrows = mysqli_num_rows($result);

            if($numrows == 0)
            {
                $sql = "INSERT INTO userInfo (uid,picUrl,description) VALUES ('$uid', '$picUrl' , '$desc')";

                if(mysqli_query($con,$sql))
                {
                    echo "OK";
                }
            }
            else
            {
                $sql = 'UPDATE userInfo SET description="'.$desc.'" WHERE uid="'.$uid.'"';
                if(mysqli_query($con,$sql))
                {
                    echo "OK";
                }
            }

            break;

        case "pictureUrl":

            $uid = $_COOKIE['id'];
            $url = mysqli_real_escape_string($con,$_POST['url']);
            list($width, $height, $type, $attr) = @getimagesize($url);

            if($width == NULL && $height == NULL)
            {
                echo "The link is broken. Please enter an image link.";
            }
            else
            {
                $insertSql = 'UPDATE userInfo SET picUrl="'.$url.'" WHERE uid="'.$uid.'"';
                if(mysqli_query($con,$insertSql))
                {
                    echo "OK";
                }
                else
                {
                    echo "Problem adding in the database.Please try again later.";
                }
            }

            break;

        case "deleteChar":

            $uid = $_COOKIE['id'];
            $charId = mysqli_real_escape_string($con,$_POST['charId']);

            $deleteSql = 'DELETE FROM characters WHERE id="'.$charId.'"';

            if(mysqli_query($con,$deleteSql))
            {
                echo "OK";
            }
            else
            {
                echo mysqli_error($con);
            }

            break;

        case "editCharDesc":

            $charId = mysqli_real_escape_string($con,$_POST['charId']);
            $charDesc = mysqli_real_escape_string($con,$_POST['charDesc']);

            $insertSqlDesc = 'UPDATE characters SET description="'.$charDesc.'" WHERE id="'.$charId.'"';

            if(mysqli_query($con,$insertSqlDesc))
            {
                echo "OK";
            }
            else
            {
                echo mysqli_error($con);
            }

            break;

        case "editCharAttr":

            $charId = mysqli_real_escape_string($con,$_POST['charId']);
            $attributeValue = mysqli_real_escape_string($con,$_POST['attrValue']);
            $attrIndex = $_POST['attribute'];
            $flag = true;

            $sqlAttr = '';

            switch ($attrIndex){
                case "1":
                    $sqlAttr = 'UPDATE characters SET maidenName="'.$attributeValue.'" WHERE id="'.$charId.'"';
                    break;
                case "2":
                    $sqlAttr = 'UPDATE characters SET age="'.$attributeValue.'" WHERE id="'.$charId.'"';
                    break;
                case "3":
                    $sqlAttr = 'UPDATE characters SET gender="'.$attributeValue.'" WHERE id="'.$charId.'"';
                    break;
                case "4":
                    $sqlAttr = 'UPDATE characters SET timePeriod="'.$attributeValue.'" WHERE id="'.$charId.'"';
                    break;
                case "5":
                    $sqlAttr = 'UPDATE characters SET location="'.$attributeValue.'" WHERE id="'.$charId.'"';
                    break;
                case "6":
                    $sqlAttr = 'UPDATE characters SET race="'.$attributeValue.'" WHERE id="'.$charId.'"';
                    break;
                case "7":
                    $sqlAttr = 'UPDATE characters SET height="'.$attributeValue.'" WHERE id="'.$charId.'"';
                    break;
                case "8":
                    $sqlAttr = 'UPDATE characters SET weight="'.$attributeValue.'" WHERE id="'.$charId.'"';
                    break;
                case "9":
                    $sqlAttr = 'UPDATE characters SET hairColor="'.$attributeValue.'" WHERE id="'.$charId.'"';
                    break;
                case "10":
                    $sqlAttr = 'UPDATE characters SET eyeColor="'.$attributeValue.'" WHERE id="'.$charId.'"';
                    break;
                case "11":
                    $sqlAttr = 'UPDATE characters SET skinColor="'.$attributeValue.'" WHERE id="'.$charId.'"';
                    break;
                case "12":
                    $sqlAttr = 'UPDATE characters SET scars="'.$attributeValue.'" WHERE id="'.$charId.'"';
                    break;
                case "13":
                    $sqlAttr = 'UPDATE characters SET features="'.$attributeValue.'" WHERE id="'.$charId.'"';
                    break;
                case "14":
                    $sqlAttr = 'UPDATE characters SET birthday="'.$attributeValue.'" WHERE id="'.$charId.'"';
                    break;
                case "15":
                    $sqlAttr = 'UPDATE characters SET sexuality="'.$attributeValue.'" WHERE id="'.$charId.'"';
                    break;
                case "16":
                    $sqlAttr = 'UPDATE characters SET partnerStatus="'.$attributeValue.'" WHERE id="'.$charId.'"';
                    break;
                case "17":
                    $sqlAttr = 'UPDATE characters SET siblings="'.$attributeValue.'" WHERE id="'.$charId.'"';
                    break;
                case "18":
                    $sqlAttr = 'UPDATE characters SET parents="'.$attributeValue.'" WHERE id="'.$charId.'"';
                    break;
                case "19":
                    $sqlAttr = 'UPDATE characters SET children="'.$attributeValue.'" WHERE id="'.$charId.'"';
                    break;
                case "20":
                    $sqlAttr = 'UPDATE characters SET otherFamily="'.$attributeValue.'" WHERE id="'.$charId.'"';
                    break;
                case "21":
                    $sqlAttr = 'UPDATE characters SET education="'.$attributeValue.'" WHERE id="'.$charId.'"';
                    break;
                case "22":
                    $sqlAttr = 'UPDATE characters SET job="'.$attributeValue.'" WHERE id="'.$charId.'"';
                    break;
                case "23":
                    $sqlAttr = 'UPDATE characters SET knownLanguages="'.$attributeValue.'" WHERE id="'.$charId.'"';
                    break;
                case "24":
                    $sqlAttr = 'UPDATE characters SET powers="'.$attributeValue.'" WHERE id="'.$charId.'"';
                    break;
                case "25":
                    $sqlAttr = 'UPDATE characters SET talents="'.$attributeValue.'" WHERE id="'.$charId.'"';
                    break;
                case "26":
                    $sqlAttr = 'UPDATE characters SET personalities="'.$attributeValue.'" WHERE id="'.$charId.'"';
                    break;
                case "27":
                    $sqlAttr = 'UPDATE characters SET allergies="'.$attributeValue.'" WHERE id="'.$charId.'"';
                    break;
                case "28":
                    $sqlAttr = 'UPDATE characters SET fears="'.$attributeValue.'" WHERE id="'.$charId.'"';
                    break;
                case "29":
                    $sqlAttr = 'UPDATE characters SET background="'.$attributeValue.'" WHERE id="'.$charId.'"';
                    break;
                case "30":
                    $sqlAttr = 'UPDATE characters SET friends="'.$attributeValue.'" WHERE id="'.$charId.'"';
                    break;
                case "31":
                    $sqlAttr = 'UPDATE characters SET enemies="'.$attributeValue.'" WHERE id="'.$charId.'"';
                    break;
                case "32":
                    $sqlAttr = 'UPDATE characters SET religion="'.$attributeValue.'" WHERE id="'.$charId.'"';
                    break;
                case "33":
                    $sqlAttr = 'UPDATE characters SET outfit="'.$attributeValue.'" WHERE id="'.$charId.'"';
                    break;
                case "34":
                    $sqlAttr = 'UPDATE characters SET peopleMet="'.$attributeValue.'" WHERE id="'.$charId.'"';
                    break;
                case "35":
                    if(strlen($attributeValue)>30)
                    {
                        echo "The nickname must be 30 characters long.";
                        $flag = false;
                    }
                    else
                    {
                        $sqlAttr = 'UPDATE characters SET nickname="'.$attributeValue.'" WHERE id="'.$charId.'"';
                    }

            }

            if($flag)
            {
                if(mysqli_query($con,$sqlAttr))
                {
                    echo "OK";
                }
                else
                {
                    echo "Problem with database try again later";
                }
            }


            break;

        case "charPicture":

            $charId = $_POST['charId'];
            $url = mysqli_real_escape_string($con,$_POST['url']);
            list($width, $height, $type, $attr) = @getimagesize($url);

            if($width == NULL && $height == NULL)
            {
                echo "The link is broken. Please enter an image link.";
            }
            else
            {
                $insertSql = 'UPDATE characters SET picUrl="'.$url.'" WHERE id="'.$charId.'"';
                if(mysqli_query($con,$insertSql))
                {
                    echo "OK";
                }
                else
                {
                    echo "Problem adding in the database.Please try again later.";
                }
            }

            break;

        case "picLink":

            $charId = $_POST['charId'];
            $url = mysqli_real_escape_string($con,$_POST['url']);
            list($width, $height, $type, $attr) = @getimagesize($url);

            if($width == NULL && $height == NULL)
            {
                echo "The link is broken. Please enter an image link.";
            }
            else
            {
                $insertLink = "INSERT INTO charactersPictures (cid,link) VALUES ('$charId','$url')";
                if(mysqli_query($con,$insertLink))
                {
                    echo "OK";
                }
                else
                {
                    echo "Problem adding in the database.Please try again later.";
                }
            }

            break;

        case "removeLink":

            $id = $_POST['id'];

            $removeSql = 'DELETE FROM charactersPictures WHERE id="'.$id.'"';

            if(mysqli_query($con,$removeSql))
            {
                echo "OK";
            }
            else
            {
                echo "Problem removing from the database.Please try again later.";
            }

            break;

        case "deleteAccount":
            $id = $_POST['id'];

            $deleteAccSql = 'DELETE FROM users WHERE id="'.$id.'"';

            if(mysqli_query($con,$deleteAccSql))
            {
                echo "OK";
                setcookie("username","",time()-3600);
                setcookie("id","",time()-3600);
            }
            else
            {
                echo "Problem removing from the database.Please try again later.";
            }

            break;
    }
}

?>
