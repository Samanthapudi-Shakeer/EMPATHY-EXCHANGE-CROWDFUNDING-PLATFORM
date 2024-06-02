<!-- donate.php -->
<?php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donate</title>
    <style>
        .container
        {
            margin-top: 10%;
        }
        html
        {
            text-align: center;
            background: radial-gradient(circle at 50.3% 44.5%, rgb(116, 147, 179) 0%, rgb(62, 83, 104) 100.2%);
        }
        form {

            width: 300px;
            margin: 0 auto;
            font-family: Arial, sans-serif;
        }

        label {
            display: block;
            margin-top: 20px;
        }

        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid black;
            border-radius: 5px;
            transition: border-color 0.3s ease;
            background-color: gainsboro;
            box-shadow: 0 0 6px 0 blue;
        }

        input[type="number"]:focus {
            border-color: black;
            box-shadow: 0 0 3px 0 blue;
            background-color: gray;
            outline: none;
        }

        button[type="submit"] {
            background: linear-gradient(109.6deg, rgb(5, 85, 84) 11.2%, rgb(64, 224, 208) 91.1%);
            color: white;
            border: none;
            padding: 15px;
            margin-top: 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button[type="submit"]:hover {
            background: radial-gradient(circle at 10% 20%, rgb(50, 172, 109) 0%, rgb(209, 251, 155) 100.2%);
        }

        button[type="submit"]:focus {
            box-shadow: 0 0 3px 0 #3e8e41;
            outline: none;
        }

        button[type="submit"]:active {
            transform: translateY(2px);
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.2);
        }

        /* Add some animation to the form when it is submitted */
        form:submit {
            animation: submit-animation 0.3s ease;
        }
        button[type="cancel"] {
            background: radial-gradient(circle at 50.4% 50.5%, rgb(251, 32, 86) 0%, rgb(135, 2, 35) 90%);
            color: white;
            border: none;
            padding: 15px;
            margin-top: 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        a
        {
            text-decoration: none;
            color: white;
        }
        button[type="cancel"]:hover {
            background: linear-gradient(107.2deg, rgb(150, 15, 15) 10.6%, rgb(247, 0, 0) 91.1%);
        }

        button[type="cancel"]:focus {
            box-shadow: 0 0 3px 0 #3e8e41;
            outline: none;
        }

        button[type="cancel"]:active {
            transform: translateY(2px);
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.2);
        }

    

        @keyframes submit-animation {
            0% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-5px);
            }

            100% {
                transform: translateY(0);
            }
        }

        /* Add some error styles for the donation amount input field */
        input[type="number"].error {
            border: 1px solid red;
        }

        input[type="number"].error+span {
            color: red;
            font-size: 12px;
            margin-top: 5px;
        }

        p {
            font-family: Arial, sans-serif;
            font-size: 16px;
            line-height: 1.5;
            margin-top: 15px;
            margin-bottom: 15px;
        }

        /* Add some hover styles for <p> elements */
        p:hover {
            color: #4CAF50;
            transition: color 0.3s ease;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Donate</h1>
        <?php
        session_start();
        // Retrieve data from the form submission
        $help_seeker_name = $_POST["name"]; // Name of the help seeker
        $amount_required = $_POST["amount"]; // Amount required by the help seeker
        $donating_username = $_SESSION['username']; // Username of the user donating
        
        // Display the retrieved data
        echo "<p>Help Seeker: $help_seeker_name</p>";
        echo "<p>Amount Required: $amount_required</p>";
        echo "<p>Donating Username: $donating_username</p>";

        // Form for donating
        ?>
        <form action="donate.php" method="POST">
            <!-- Hidden input fields to pass data to the processing script -->
            <input type="hidden" name="help_seeker_name" value="<?php echo $help_seeker_name; ?>" readonly>
            <input type="hidden" name="amount_required" id="amt" value="<?php echo $amount_required; ?>" readonly>
            <input type="hidden" name="donating_username" value="<?php echo $donating_username; ?>" readonly>

            <!-- Input field for the donating amount -->
            <label for="donation_amount">Donating Amount:</label>
            <input type="number" id="donation_amount" name="donation_amount" min="0"
                value="<?php echo $amount_required; ?>" oninput="checkamt()">
            <div>
            <button type="submit">Donate</button>
            <br>
            <button type="cancel" onclick="ram()"><a href="mainsite.php">Cancel</a></button>
            </div>
        </form>
        <script>
            function checkamt() {
                var amt = parseInt(document.getElementById("donation_amount").value);
                var req = parseInt(document.getElementById("amt").value);
                if (amt > req) {
                    alert('Donating amount should be strictly less than the Required Amount');
                    return false; // Prevent form submission
                }
                if (amt == 0) {
                    alert("Please Donate more than amount 0 , I hope it was by mistake");
                    return false;
                }
                return true;
            }
        </script>
        <?php
        // Database connection details
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "sampledb";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Retrieve data from the form submission
        $help_seeker_name = $_POST["help_seeker_name"];
        $amount_required = $_POST["amount_required"];
        $donating_username = $_POST["donating_username"];
        $donation_amount = $_POST["donation_amount"];
        if ($donation_amount > $amount_required) {
            echo "<p>You cannot donate more than the amount required.</p>";
            header("Location: mainsite.php");
        } else {
            // Update the amount in the database
            // Update the amount in the database
            $my = "SELECT * FROM `record` WHERE `amount` = 0 and `fname` = '$help_seeker_name';";
            $res = $conn->query($my);
            if($res->num_rows > 0)
            {
                header("Location: mainsite1.php");
                exit();
            }
            else{
            $sql = "UPDATE `record` SET `amount` = GREATEST(`amount` - $donation_amount, 0), `donor`='$donating_username' WHERE `fname` = '$help_seeker_name';";
            $balance = $amount_required - $donation_amount;

            // Add a new record to another table to track the donation
            $timestamp = date("Y-m-d H:i:s"); // Current timestamp
            $add_record_sql = "INSERT INTO `donations` (`name`, `donor`, `donated`, `balance`, `timestamp`) VALUES ('$help_seeker_name', '$donating_username', $donation_amount, '$balance', '$timestamp');";

            // Update no_of_donations_made in contact table
            $update_contact_sql = "UPDATE `contact` SET `no_of_donations_made` = `no_of_donations_made` + 1 WHERE `uname` = '$donating_username'";
            $update_rcontact_sql = "UPDATE `recoverycontact` SET `no_of_donations_made` = `no_of_donations_made` + 1 WHERE `uname` = '$donating_username'";
            // Execute all queries
            if ($conn->query($sql) === TRUE && $conn->query($add_record_sql) === TRUE && $conn->query($update_contact_sql) === TRUE && $conn->query($update_rcontact_sql)=== TRUE) {
                echo "<p>$donating_username Your donation of $donation_amount has been successfully processed for $help_seeker_name. Thank you for your contribution!</p>";
                echo "<script>
        // Redirect to another HTML page
        window.location.href = 'success1.html';
    </script>";
            } else {
                echo "Error updating record: " . $conn->error;
            }
        }
        }
        // Close connection
        $conn->close();
        ?>
    </div>
</body>
<script>
    function ram()
    {
        window.location("mainsite.php");
    }
</script>
</html>
