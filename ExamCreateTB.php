<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    New Name<input type="text" name="fname">
    Existing Name<input type="text" name="ename">
    <input type="submit" name="" id="" value="Submit">
</form>
<?php
$username = "root";
$password = "";
$hostname="localhost";
$db = "university";

$con = new mysqli($hostname, $username, $password, $db);
if ($con->connect_error) {
    die("Connection failed");
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_POST['fname'];
   $ename =$_POST['ename'];

    $sql = "update student set name='$name' where name='$ename';";
    $res = $con->query($sql);
    if ($res) {
        echo "Data inserted Successfully";
    } else {
        echo "Error inserting data: " . $con->error;
    }
}

session_start();
?>
