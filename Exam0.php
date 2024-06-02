<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    Name<input type="text" name="fname">
    ID<input type="number" name="sid">
    Department <input type="text" name="dept">
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
    $id = $_POST['sid'];
    $dept = $_POST['dept'];

    $sql = "insert into student values('$id','$name','$dept')";
    $res = $con->query($sql);
    if ($res) {
        echo "Data inserted Successfully";
    } else {
        echo "Error inserting data: " . $con->error;
    }
}

session_start();
?>

