<?php
$username = "root";
$password = "";
$hostname="localhost";

$con =new mysqli($hostname,$username,$password);
if($con->connect_error)
{
    die("Connection failed");
}
session_start();
$sql = "create database university";
$res = $con->query($sql);
if($res)
{
    echo "DB created Successfully";
}
?>