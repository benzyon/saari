<?php
/**
 * Created by PhpStorm.
 * User: ivanj
 * Date: 16-Feb-17
 * Time: 16:07
 */

$con = mysqli_connect("localhost","id813679_islanduser","IslandPhP240@","id813679_islandofsaari");
/*$con = mysqli_connect("localhost","root","","islandproject");*/
if (mysqli_connect_errno())
{
    echo "Could not connect with the data base: " . mysqli_connect_error();
}

?>