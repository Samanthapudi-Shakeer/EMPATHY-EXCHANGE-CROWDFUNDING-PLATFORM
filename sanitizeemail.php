<?php
$email = "xy\$z@gmail.com";
$saemail = filter_var($email,FILTER_SANITIZE_EMAIL);
echo $saemail;
?>