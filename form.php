<?php
// getting all values from the HTML form
if(isset($_POST['submit'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $e = $_POST['e'];
    $h = "";

    // database details
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sampledb";

    // creating a connection
    $con = mysqli_connect($host, $username, $password, $dbname);

    // to ensure that the connection is made
    if (!$con) {
        die("Connection failed!" . mysqli_connect_error());
    }
    $timestamp = date("Y-m-d H:i:s");
    // Check if username or email already exists
    $check_query = "SELECT * FROM contact WHERE uname = '$fname' OR email = '$e'";
    $check_result = mysqli_query($con, $check_query);
    
    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('User already exists!')</script>";
        header("Location: main2.html");
        exit(); // Exit script to prevent further execution
    }

    // using sql to create a data entry query for contact table
    $sql_contact = "INSERT INTO contact (uname, pwd , email ,help_statement, no_of_donations_made,lv) VALUES ('$fname', '$lname','$e','none',0,'$timestamp')";
    
    // using sql to create a data entry query for recoverycontact table
    $sql_recoverycontact = "INSERT INTO recoverycontact (uname, pwd , email ,help_statement, no_of_donations_made,lv) VALUES ('$fname', '$lname','$e','none',0,'$timestamp')";

    // Execute both queries
    if (mysqli_query($con, $sql_contact) && mysqli_query($con, $sql_recoverycontact)) {
        echo "Entry added!";
    } else {
        echo "Error: " . mysqli_error($con);
    }

    // close connection
    mysqli_close($con);
}

echo "<script>
    // Function to redirect after 10 seconds
    function redirect() {
        setTimeout(function() {
            window.location.href = 'logo1.php'; // Replace 'your-next-page.html' with the URL of the page you want to redirect to
        }, 0); // 10000 milliseconds = 10 seconds
    }

    // Call the redirect function when the page loads
    window.onload = redirect;
</script>";
?>
<link rel="icon" type="image/x-icon" href="./logo.ico">
