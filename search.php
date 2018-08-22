<?php
/**
 * Created by PhpStorm.
 * User: ivanj
 * Date: 28-Feb-17
 * Time: 16:34
 */
require("dbconnect.php");
$arr = array();

if(isset($_POST['keywords'])&&!empty($_POST['keywords']))
{
    $searchType = $_POST['searchType'];
    $keywords = $con->real_escape_string($_POST['keywords']);

    if($searchType == "searchUser")
    {
        $sqlUsername = 'SELECT id,username FROM users WHERE username LIKE "%'.$keywords.'%"';

        $resultUsername = $con->query($sqlUsername);
        if($resultUsername->num_rows > 0)
        {
            while($row = mysqli_fetch_assoc($resultUsername))
            {
                $arr[] = array('id' => $row['id'],'title' => $row['username'],'searchType' => $searchType);
            }
        }
        if(empty($arr))
        {
            echo "No suggestions";
        }
        else
        {
            echo json_encode($arr);
        }

    }
    elseif($searchType == "searchCharacter")
    {
        $sqlCharacter = 'SELECT name,nickname,id FROM characters WHERE name LIKE "%'.$keywords.'%" OR nickname LIKE "%'.$keywords.'%"';
        $resultCharacter = $con->query($sqlCharacter);
        if($resultCharacter->num_rows > 0)
        {
            while($rowChar = mysqli_fetch_assoc($resultCharacter))
            {
                $arr[] = array('id' => $rowChar['id'],'title' => $rowChar['name'],'searchType' => $searchType);
            }
        }
        if(empty($arr))
        {
            echo "No suggestions";
        }
        else
        {
            echo json_encode($arr);
        }
    }
    else
    {
        echo "No suggestions";
    }
}
?>