<?php
session_start();

// Database connection details
$host = "localhost";
$username = "root";
$password = "";
$dbname = "sampledb";
// Create connection
$con = mysqli_connect($host, $username, $password, $dbname);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {
    $username = $_POST['fname'];
    $password = $_POST['lname'];
    $timestamp = date("Y-m-d H:i:s");
    
    // SQL query to retrieve user data from the database
    $sql = "SELECT * FROM contact WHERE uname='$username'";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $stored_password = $row['pwd'];

        if ($password === $stored_password) {
            $_SESSION['username'] = $username;

            // Update last visit timestamp
            $sql_contact = "UPDATE contact SET lv='$timestamp' WHERE uname='$username'";
            $sql_rcontact = "UPDATE recoverycontact SET lv='$timestamp' WHERE uname='$username'";

            if (mysqli_query($con, $sql_contact) && mysqli_query($con, $sql_rcontact)) {
                header("Location: logo.php");
                exit();
            } else {
                header("Location: main.html");
                exit();
            }
        } else {
            $error = "<script>alert('Invalid password')</script>";
            header("Location: main1.html");
            exit();
        }
    } else {
        $error = "<script>alert('User not found')</script>";
        header("Location: form.html");
        exit();
    }
}

// Close connection
mysqli_close($con);
?>
