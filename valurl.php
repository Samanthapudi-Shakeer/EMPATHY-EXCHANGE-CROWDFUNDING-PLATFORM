<?php
$url = "xyz$@gmail.com";
//same for email and ple
// if $ placed before variables it is wrong , but can use \$ to include
if(filter_var($url,FILTER_VALIDATE_EMAIL))
{
    echo "cORRECT";
}
else
{
    echo "WROG";
}
?>