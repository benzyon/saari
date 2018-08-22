<?php
/**
 * Created by PhpStorm.
 * User: ivanj
 * Date: 19-Feb-17
 * Time: 19:05
 */
function checkifempty($attribute)
{
    if($attribute == "")
    {
        return "[blank]";
    }
    return wordwrap($attribute,25,"<br>\n",TRUE);
}
?>