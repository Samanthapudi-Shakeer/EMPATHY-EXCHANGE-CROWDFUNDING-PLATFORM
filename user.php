<?php
session_start(); // Start sessionif
if (!isset($_SESSION['username'])) {
    // If 'username' is not set, redirect to 'set.php'
    header("Location: set.php");
    exit(); // Ensure no further code is executed after redirect
}
// Database connection details
$host = 'localhost';
$dbname = 'sampledb';
$user = 'root';
$pass = '';

// Connect to the database using PDO with error handling
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

// Ensure the user is logged in
if (!isset($_SESSION['username'])) {
    die("Session variable 'username' is not set.");
}

$username = $_SESSION['username']; // Get the username from the session

// Handle form submissions for profile photo update and account deletion
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // If changing the profile photo
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
        $photo_data = file_get_contents($_FILES['photo']['tmp_name']); // Read the uploaded image data

        // Validate the uploaded image
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['photo']['type'], $allowed_types)) {
            echo "<script>alert('Invalid file type. Please upload a valid image (JPEG, PNG, GIF).');</script>";
        } else {
            // Insert or update the profile photo in the 'img' table
            $sql_insert = "INSERT INTO `img`(`username`, `photo`) VALUES (:username, :photo) 
                           ON DUPLICATE KEY UPDATE photo = :photo"; // Update if record exists
            $stmt_insert = $pdo->prepare($sql_insert);
            $stmt_insert->bindParam(':username', $username, PDO::PARAM_STR); // Bind the username
            $stmt_insert->bindParam(':photo', $photo_data, PDO::PARAM_LOB); // Handle large objects

            if ($stmt_insert->execute()) {
                echo "<script>alert('Profile photo updated successfully.'); window.location.reload();</script>"; // Refresh to reflect changes
                exit(); // Prevent further script execution
            } else {
                echo "<script>alert('Error updating profile photo. Please try again.');</script>";
            }
        }
    }

    // If deleting the account with password verification
    if (isset($_POST['delete_account']) && isset($_POST['password'])) {
        $password = $_POST['password']; // Get the password from the form

        // Verify the password against the stored one
        $sql_verify = "SELECT pwd FROM contact WHERE uname = :username";
        $stmt_verify = $pdo->prepare($sql_verify);
        $stmt_verify->bindParam(':username', $username, PDO::PARAM_STR); // Bind the username
        $stmt_verify->execute();

        $stored_password = $stmt_verify->fetchColumn(); // Get the stored password

        if ($password === $stored_password) { // Ensure the passwords match
            // Delete user data from the database
            $sql_delete = "DELETE FROM contact WHERE uname = :username; DELETE FROM img WHERE username = :username"; // Ensure cascading deletion
            $stmt_delete = $pdo->prepare($sql_delete);
            $stmt_delete->bindParam(':username', $username, PDO::PARAM_STR); // Bind the username

            if ($stmt_delete->execute()) {
                session_destroy(); // End the session
                echo "<script>alert('Account deleted successfully.'); window.location.href = 'dsite.php';</script>"; // Redirect to the homepage
                exit(); // Prevent further script execution
            } else {
                echo "<script>alert('Error deleting account. Please try again.');</script>";
            }
        } else {
            echo "<script>alert('Incorrect password. Please try again.');</script>"; // If the password is incorrect
        }
    }
}

// Fetch user details and profile photo
$sql = "
    SELECT 
        c.uname AS username,
        c.email,
        c.help_statement,
        c.no_of_donations_made,
        c.lv,
        i.photo AS profile_photo
    FROM
        contact c
    LEFT JOIN
        img i
    ON
        c.uname = i.username
    WHERE
        c.uname = :uname
";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':uname', $username, PDO::PARAM_STR); // Bind the username
$stmt->execute();

$user_data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user_data) {
    die("No data found for the username: " . htmlspecialchars($username));
}

// Check if a profile photo exists
$profile_photo_data = $user_data['profile_photo']; // Check if profile photo exists
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Information</title>
    <style>
        /* Gradient background */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: radial-gradient(circle at 10% 20%, rgb(151, 10, 130) 0%, rgb(33, 33, 33) 100.2%);            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Styling for the user data container */
        .user-data {
            padding: 30px;
            max-width: 600px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.2);
            /* Semi-transparent background */
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            /* Soft shadow */
        }

        .profile-photo {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 5px solid #E0115F;
            box-shadow: 0 0 10px rgba(255, 0, 0, 1);
            /* Red glow */
            padding: 1px;
            margin-bottom: 20px;
        }

        .upload-form {
            margin-top: 20px;
        }

        /* Styling for the button to change profile picture */
        .upload-form button {
            padding: 12px 25px;
            background-color: rebeccapurple;
            /* Reddish button */
            color: white;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }

        .upload-form button:hover {
            background-color: fuchsia;
            /* Darker red on hover */
        }

        /* Styling for the delete form */
        .delete-form {
            margin-top: 20px;
        }

        .delete-form button {
            padding: 12px 25px;
            background-color: blueviolet;
            /* Bright red for delete button */
            color: white;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }

        .delete-form button:hover {
            background-color: rebeccapurple;
            /* Dark red on hover */
        }
        input {
                width: 30%;
                border: none;
                padding: 1rem 2.7rem 1rem 1rem;
                border-radius: 10px;
                color: #fff;
                background-color: rgba(255, 255, 255, 0.2);
                border: 1px solid rgba(255, 255, 255, 0.4);
                transition: all 0.2s ease;
            }

button {
  appearance: none;
  background: transparent;
  border: none;
  cursor: pointer;
  isolation: isolate;
}

.button {
  font-size: 16px;
  line-height: 1.5;
  font-weight: 500;
  margin-top: 15px;
  margin-left: 42%;
  width: 240px;
  border-radius: 9999rem;
  background: linear-gradient(60.2deg, rgb(120, 85, 137) -3.9%, rgb(35, 19, 21) 6.7%);  position: relative;
  display: flex;
  justify-content: center;
  align-items: center;
  position: relative;
  isolation: isolate;
  overflow: hidden;

  & > span.text {
    color: #121212;
    width: 100%;
    text-align: left;
    padding-block: 12px;
    padding-left: 24px;
    z-index: 2;
    transition: all 200ms ease;
  }

  & > div.overlay {
    color: #ededed;
    width: 48px;
    height: calc(100% - 2px);
    display: flex;
    justify-content: flex-end;
    align-items: center;
    padding: 12px;
    border-radius: inherit;
    background: linear-gradient(200.2deg, rgb(120, 85, 137) -10.9%, rgb(45, 19, 31) 96.7%);    position: absolute;
    right: 1px;
    z-index: 1;
    transition: all 400ms ease;
  }

  &:is(:hover, :focus) {
    & > span.text {
      color: #ededed;
    }
    & > div.overlay {
      width: calc(100% - 2px);
      transition: width 200ms ease;
    }
  }
}

    </style>
</head>

<body>
    <div class="user-data">
    <button  class="button" style="margin-left : 26%">
  <span class="text"><a href="site.php" style="text-decoration:none; color:white;font-weight:bold;">Go Back</a></span>
  <div class="overlay">
    <svg xmlns="http://www.w3.org/1999/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right">
      <path d="M5 12h14" />
      <path d="m12 5 7 7-7 7" />
    </svg>
  </div>
</button>
<br>
        <!-- Display profile photo if it exists, else default -->
        <?php if ($profile_photo_data): ?>
            <img src="data:image/jpeg;base64,<?= base64_encode($profile_photo_data) ?>" alt="Profile Photo"
                class="profile-photo">
        <?php else: ?>
            <img src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAoGCBUVExcVFRMXFxcZFxoaGhkaGhggIRsZGRofGhoaIRwaHysjHBwoHRkXJDUlKSwuMzIyGSE3PDcwOysxMjEBCwsLDw4PHRERHTEpISg8MS4xNjM7MTE5MTk5MTEzMTQzOTkzMTExMjExMTExMzExMTM5MTExMzEzMTExMTExMf/AABEIAOEA4QMBIgACEQEDEQH/xAAbAAEAAQUBAAAAAAAAAAAAAAAABwECAwQGBf/EAD8QAAEDAgMFBAgFAgYCAwAAAAEAAhEDIQQxQQYSUWFxBSKBoRMyQpGxweHwBxRSctFi8RUWI4KiskNTM2OS/8QAGgEBAAMBAQEAAAAAAAAAAAAAAAECAwQFBv/EADMRAAIBAgQEAwYGAwEAAAAAAAABAgMRBCExUQUSFEEiYbETFSMycZEzUoGhweFC0fA0/9oADAMBAAIRAxEAPwCZkREAREQBERAEREAREQBEVEBQBVWtisZTp3fUa2xPecBYXOfJaNXaDDNG8a7IkCZm5EwIztnw1UOSWrLKEnomz11ReTR7fwzgCKzYMxMj1RJNwLDjlNs16FDEseJa9rhfIg5WOSKSegcJLVNGwioqqSoREQBERAEREAREQBERAEREAREQBERAEREAREQFpVVRcXtdtO4OFDDODnu7pc25DiY3Qcp53jkqykoq7NKNGVWVonp7Q7VUcOSwHfqDNoyb+46dBdeU3FY/FhoZTFGm7N5MTzid6OEe9bGy2yYpn0uIipVJmDJDTzJ9Z3NdaqJSlm8vI6JzpUsqau93/COYwuyFPf36z31iGgQ42tyGnALco7K4VpB9CCRxJPllzXoY3tClSgVHtaTlJ8+nNeadqcPMNc52cw0wI4l0Rx8LwptBbFVPETzV7eRdW2VwromkLczz99zPgF5NbYoNO9SrPa5vqyeEmJGQkjQ62vK9SntbhSY9IReAS10O5i2XPJethsUx4lrg4cjyn4EJaD0sT7XEU9b/AKnD1e28dgyBXYHsgX0PEhw1vryXUbP9v0sS2WEtcPWY7MdNCOi9SvSa9pa5ocDYg5FcVtLsy6mfT4WZaQSxpiAMyIz0Ef2VXzRzWaLxlRr+GS5ZbrR/U7pAuR2P2o9NFKtDaswNN7XLQrrgtIyUldHLVpSpy5ZFURFYzCIiAIiIAiIgCIiAIiIAiIgCIiAIixV6ga0uOQBJ6C6A5rbvtz0FPcY4Co7gRLRxiDn4LFsF2H6On6aoAajwC2QJa0i1+JXPdg4V2PxrqtQdwHecNIFmNuZi3PJSYSAJNgB5BYQ8UuZ6dj0K7VCmqMdXm/8ARhx2MZSYXvcGtGZPy4nko22h2uq1XFtM7lObAZuHFx+Su207XdXeW727Sae6IEkixdnkeJ0XMHksqtVt2Wh24HBRUeeau/T+zNVxLnkue9zic73Pirm1XP7oy4DLrGp6rWV2+YgWHxXPc9PlXY9Cg9jD+t/kOp+Q9+i2sPjKhcC0mRlFoHKMvvovHY0C7j4DM/wszXOeIEMZrnHic3FWUjKVNM7PsrbEMc2nWO+CYL2+zpc+1fhlxOQ7em8OAIuDcKH8Pu04iQf1EAvP7W5UxzMn4LqdjO1nsduPEMcbCSS1x1cTof7ACw6adV6SPKxmDilz01/ZTbfsMUz+bpCCHBzwNDPrRpzXu7G9tfmaMmz2Hddz4HxGfNe1VphzS0iQRBB1BUc0XuwGP3J/03O97XZG1rdBlorSXJLmWj1Mab6ik4S+aOa+mxJiKgVVueeEREAREQBERAEREAREQBERAEREBRc9t9jDTwroiXQ0SAc88+S6FcP+KtUBlJt7uJ5WAHHnwVKjtFs6MJDnrRTNz8NMHu4c1DnUcTrk2w14yt3bfHmlQhpcHvMDdF4zdfS2q2NkmbuDoWAmm02EesJ+a8P8QcTDmNAE7pMmDEn9MXNjnI5aij8NM2j8XFNvd/scPVoH1qh3QchmT/Pw6LVe8aCB5lbVZhcSfe4n5n4f3WsYybJPH+AuJn0ETGgVXBUUGheyNb9cvqsrahOR5Sc+jRp4LA0StqhAyEnichyn5D36IikjbwdAAbxMDUmJ95mNLDxlelh3HJvdHGLmcobMjqTPAgWXmU3gQ5zujj8GtGXX4K9tV7p3T6NuRcfWPj7I5C51LlonY55xciTuwsR6Si0ky4d10kEyOMACSIJsM8lzn4oYY+jp1RYtdBNtcueaz/hzUb6N7WA7ocDJm5IuZOeX0C9Lbahv4OqIkgAjqCPOJXW/HTPGj8LEpefqZdk8WauFpvOe7B6tt8l665T8NHk4Ug6PMX+4XVK0HeKZz4iPLVkluXIiK5iEREAREQBERAEREAREQBERAUXC/iqzu0XWsXDneDbTRd0uV/ErD72Fm3dcDeOn3Czqq8GdODly14s9rZ904aiTJJpMJJzndGc5lcj+I9drKrCQXEssMhY6nPhYeS6PYysH4OkRkG7uR9kx49VofiBQHo21TALDu70SQHZbs2BkZnJVnnTNaDUMTZ7tEfOpvfBqGJ9VgFyM+60ZDmet81jqECQB4Az/APp3yFvitx1JzibFoMkiZe7Ul7j775ZniqPwzWgTrENE34WzdPHLguOx7ymjztwn78laQt6o0m2X9I4DicgOQtxWpUI69MvqqtGkZXMYWQPjmfIeCxohaxmDwDJ7zuf8/wALJTeXEC7jo0ZDw81rsA1KzNrQIAsdBN+pzPTJSUa2O+/DmmQKpLgbtEDJuduE/eS97al0YSsf/rdx1EaLQ2AoObhWudMvJcBwbkIGkxPirtva+7g38XQ3TU6T0XbHKmfOz8eKy3SNH8LmEYd5giahjnAAXXrwNg8N6PCM4ulx8SveCvTVooxxUuatJrcuREVzAIiIAiIgCIiAIiIAiIgCIiAotbtDDCpTcx2TmkfVbKtLozQlNp3RxX4e4h1OpWwzwQWuJE52MHygzquvxuHFRpaciMxmDoQdCFxe1j6dPGU67KrQ9nrtHLIGLCQYi5ytqO0wdffY14BG80GCIIniFlT7x2OrEp3jVWV/Uj7HYY03OZuhm6bkgXjItBtHBzrXtey8zFOawlpneObbl7p/UTcTwNzqFIe0nZHp2dx25UGThnGonQ8xcKPsfg3UHGn6MtcM3OyPQ+1OfyWFWDiejha0aizeex52JJI70Nbo0a/z1yHktNxGgW16MuJI7x1e7IeJsAsbmhvPmfkDcjmVgz0otIwIrg0nmqObCg0DWyug2W7L9JVa0CdSYJAA6Zcjx1leR2ZgKld4ZTbvOPgANSToFLGzfZDcNSDZlxgvdfvO6HILalT5nfsefj8SqceVPNno0mAAAZAQM/jquJ20qHE4ujhGOtMvjdME562IaCY5rre2MWaVJ7w0uIBgAE30mMhxK4fYDtGix9V9ZwFV5nedYEOu6+QJMZxouio02o7nlYWDUZVUrtafV9/0JBw9IMa1rRAaAAOQEBZVRplVWxxMqiIgCIiAIiIAiIgCIiAIiICiKi8raPtZuGplzi3eM7rTNyOECbT9QobSV2TGLlJRjqy3aHtylhmEvdLyO6wXJOltBzK4/BU8bj377nejpzZ1wB+xurufmtnZ/sJ2LqHE4gdxx3mtm7jOZGjM4E/XvGsAEAQAsrOebyR3SlDDrlhnLu9vJHh9jbLUKB3oNR2jnwY6DIL3iuY2o2sZhyabBv1Iy9kTxOp5DyXDY7aLEVN7eqkB2YBgRwgZBRKpGnkiaeEr4jxSf3JHxu0mHp70vkt0aJk8AfVnje2sLyMftLh6jYqUS5hj1oknUNaLk5cuJCj4VY/qPPIdBqtiixz+890N1JPuGXkAeixdds7o8Opwzbf/AGx1OB7No4sO9C91J7YO4YcGjKRECc9TCxDYitvS5zXCfZJHiSRlYZTnpmtXsXtEUXtLGwAe9ObmnMQDYW4k9clJlN4cARcEAjoVpCEZrPU58RWq0JWi8npc4MbJ1ohrWtsDdwzNotNxmTppvLxO1+z6eHq7lZxed2YbYNmN25zPrGI4XvaVMXXDGOe7JoJPgoZ7XxL6lV73+s4zHLTyVasYwWRrgqtWvJuTyWx2HYm02EogMp4dzRqWwSToJN3Hy65rqMD27QqWbUAIiQbQTpPqk9CVENB31vHvPBetgqhjugEDU2Y33/xJ4BVhWksi2I4fB5pu/wBSXAV4G0Wy1HEiY3H6PaPiNVznZfaVancVCQcy8WP7GEz4kiddzJdT2b29TqOFNxDKhyaTMjO3hxA1iRddCnGSszznSq0HzRf2OWo47FdnP3KjDUol1nSTY57p06GLruOzcfTrM36bg4eYPA8Cr8dhGVWFj2hzXCCCuBx2Drdm1hVpS+i4nu3iD7LuY0dy6qM4ea9Cy5MStp/s/wCyRkWn2Xjm1mNewyCMuB1B5rcWydziacXZlUREICIiAIiIAiIgCIiAsJUf06R7QxxcZNClYQbEA2EgQSTfpquj257Q9DhXQQHO7rZjXO0jSVdsX2aKGGaI7zu+60XdkMzkICyn4pKPbVnXS+FSdTu8l/LPaptAAAEAZLidstpyD6LDuvcOcB5B09Zt4r2dsO1RRpboJ3n2ETMamZG7nmfcclGNeoXyGi2sT5k3cfLgqVqlvCjowGFU/iTWXY16mdzJ1PPrqrVc5sZ58BorVxnvoyMcBzPl9Vlpvc88fgPkAtdsarMxpcNGt8fIZuKIqzZ/NBlmjfd/xB+Lz5dVI2w2Me+huVPXYYIkTum7SQMtR4KOqJaywkE8I3zym4pjPKT106HZPtA0XlzyG0y07zWgmNQ4mZn3m55LelLlkedjaXtKbSWep0O3eMLaQY0kF5vA9kZ3Nm6XvrZRnVZLoaJPAX89SvZ2j7YOIqFwkMyaIAcWjK2mtyfdkvOpN0yGrQf+zteg8lFWXPI0wVJ0qdnqMLhBr3zwBho/c7U8h79F6IeAN5xbAyJENHJrYv1ieQzWgcTo0Bx/4jw9rM8B+7NWOqCZcS9/DQfwPPoqJpG8ouWpvfmnvnc7g1qO9Y9BMNHj/uWOjVayfRjedq93Gc5Nyfd01Om6qXWJ3uDRl9fvNZgz9ZmPYBAA6uyHn4ZpcciR22yG0ReRSqEuOlTQn9J58Dr1XU4zDtqMcxwlrhBHIqITizYN4iAAYB0huZM6mT43Um7K411WiC/122d4ZHxC6qVTm8LPGxuH9m+eORyXZbndnYz0Li51KpEHIQTDTEXcLAxGfgpEXPbddmirhnOvvU++I1gGRzsSeoCu2I7U9PhxNnMO4ctMjbl8FaPhfL9jKt8WmqvdZP8AhnQoiLU4wiIgCIiAIiIAiKiA4jbgGti8Nh57s7zhznqNAfeV2lNsADQBcNhf9XthxJtTBgGDk2LcLld050AlZQzbZ14nKMIbK/3I621O/iHF7zutgMZfQXMTqdbaePMYqto0breAzPU/IQOWp9LtIlz3vJgFxlx4zlzOVh7hmfLc+8UwSf1HPwHsjn8FyVHd3Pcw0OWCWxgLYzVFe9sayfL36qxZnWi5p+z93WRryTab65k8hwWJrfcry+MrcTqfohDNpr20+v6Qbn9ztOg+qxVsW59iYGgGQ8OPM35rWSVNyqgtTKHx/AzPUoXznYcB938ViQKC1jIaugsFVjLX7o8z4aqwOjLPif4VRJ/lCLGX0waIaI+J6u4chHzV9Cg5+dm6fQfNKVNrbm5+9D856LIMQ5xhg6nh4/ZPE5KfqUb2N6k1lMWF+Op++HvDl0WxOMd6YiIY9p8SLg+6R9wOXYxrfW77/wBPDwNh425HJb/ZuP3a9MudcPb3WzYTBLrybccuEWW0JWaOPEU+eDWpKDhIgrhdjabqGPr0CQGuBIHR0tj/AGl3ku7C4vtgej7VoumA9sa3048YyXRU1T8zycM7qUN16HbIqBVWpyBERAEREAREQBUcqrHW9V3Q/BAjhNh6gdj8S7iHGZ/qAy1+i7XtF0U3ng0nyXD/AIWgGtXdrut83E/Jdt2mYpPiZ3HerM5aReVjS+S/1O3GK1e21iIn0HuINUmYswASB+3Km3rHRY6jh6rQOgy/3OzcfcOC2303OkHutzLQf+T3H55cjZV/KtEB2ejALz+3PLV140hclj3IzXc8xrHONr/ThyCvZRA/qP8AxB4E6nkFvuZIOUfpBtGm87UafptZataqMmje0FrDoNfnrKi1jRTb0MLxrNuJy8GrCSrnnUmSrFU0SCIiEhERAAr9/grFUFAZWMGbys35i0Dujln9OE581pkq5vSSlyrjfU2GPJFu439WvOOfT3rZwDocCwboDhNRxiLj2vZPSXea18PR3iJ7xyjTpbPoFvUq7Glsd98gNjJsn2YsD+2/PVWRlUfhsiXWFcVtlTH5/CuJ4D3OkZ9V2dLITwH3dcXtsCcdhR01j2l21Pl+x8/hPxf0fodwFVUCqtTkCIiAIiIAiIgKBYsV6jv2n4LKFixIljh/SfghMdThvwr9evpZlrzm7Rdr2lHonzluOnpC4z8KmwcR/sH/AG0XZ9pOik83sxxtnksqXyHZjP8A0fb0RHTuDRui0fqNrED2eRNz7MhaVesxksAk6sbc8Tvuy6j3gFVr1XvBP/xU9ST3zOcn2ZtYCTwIWi6oAIpjdb+o/If3XK2ezCG5biXk3qOjUMHx59T4StarU0FgrgwmSMtXu49ePS6HdblnxI+A08VmdCSRiDONvmqE8FkaxzzYdSfmSthuGDRJufvT75wosWcktTUawqjgs5lxho8eGmeSuNENzu7h/fLx92qWHMawaVQrLVdx9wWMt42QlMoiuDD96o5sZoTctV7HBWIgMr6xNpgcBry+i28FRuJO4OHtEcz7I48uV1oscRlmvU7Mpt3hv3v6vnJ4cb+WamObMqmUSXqPqjoPguN2uj/EcJ4SLcTGZXZ08h0C4zat8dpYTw14k6TZd8/l+x87hfxH9H6HbBVVAqrQ5AiIgCIiAIiIAsdYd09D8FkVrggRw34Xgh+Jm3eYIvYy+dI89Pf2PaLopPPBruWi478PobicXTJ7xIMXya505j+sZ+5dtWphzS0iQRBHIrKl8lvqdmLfx2/p6Ih+oXPP63cBO637+xqqGkBdxDj17otlI9Y8m25m4UmN2bwwaGilA4S6/W9xbJW1Nl8K7Ol/ydz52z8gsfYSO5cRp7Mi95c4gNBJ0tl0AsPitih2b7TzOsD5mb+8DiQbKTKGz2GYIbSAvOZ4R7uSud2Bhz/4+HtO08c0WHfch8ThokyNnuA7rRfgPsfAdBmrThPaqGP6R9M+g43Lc1JVLZ/DtypgXGp0ER05Kg2dw8z6OTa5J0m2eV8uQU+wZX3hBaJkbV3QP/W3T9R92XhJ5jNaZaSJA3Gfqd93PISVKDtlsITvGlJ4lzuIPHl5lVqbL4Vxk0/+TrZ2F7C/kFDoMvHiNNdmRZTpkzuDLN7oEfJvxWehgrb2mZe63iAdP6nR0myk/wDy7hpB9GO6LCTAtExlPPmUr7OYZ8b1OYyG86OsTnz5lOnZL4nB9mRZUeMqYLjq4/XTmY6BYW0HOmL8XaDx+/FSo7ZbCkR6O37nXvN73z8gsp2dw8AejAAyAJgWjLz6qOnZPvOmtEyJnUYsLn7yH8+Sv/IuAl1uWp+nPLqpWobO4ZuVMTJMkk3PXhpwVauz2HcCDTzzO86cozmU6dj3pHZkQOBBWbBD/UaHWG8JHipWp7MYVuVIDPU6+OarU2cwzgR6MXINiRkIFwbcet1PTy3EuKU2rWZ61PILi9s3H8/hd0Sbf9l2rRAhcRtWQ7tHDNziJHCXTlH8rep8v2POwn4jfk/Q7kKqoFVaHIEREAREQFFgq4hjY3nASQBJGZyC8bbPtN1Cgdyz3d1pg2tcjQEaT55KLqmIqEklziXG5JJJ8VjUqqDsd+FwLrrmbsiW6u0OGaSDXZLc4M6xFszdYau1GGFvSSb2a1xy8LTpKiWCI8voqmo4WlY9RLY7lwqn+ZnRYfGeixlSvTcHbzjAjNpztoOfunJdVh9r2R32EHXdII04xz45C8mFGgqkZW+aqysQZzPPRUjWcdDepgoVLX7ZEs0tpcO4A7xExm0669P5WLEbV4VkAvM8ADIvEHgdYUXvxrzkY56/T7zWuCrvEMxXC4d2yVW7XYc6ujUxl9eXNKW12HcQAKhP7fr09/VRYXk5kws7MYQIbYffvPP3Qo6iQfDKfa5KTtpqA/VpYAa566ccuEq2ttTh25l2toGmWuZ8tYUXHGu9m3E6n+Og81YK3ieeQ8NT1U9RIhcLh3uSgNrsPBMPj2e7d54NEyeuVs1e/aigM97LKBnPq553nlrCi44p14zOZNyev8ZI3FEdef39806iRPuyHmShV2qw7RJLgL+zwyAEySeA8YVKW1dBxgB86jdHd4bxmBN/covFe8uJ8M+k+yOiv/OujdAAbwH3nzN06hke7IeZKB2moTEuzj1dIzzy04+Cwf5xw0wN82vAEAxcTMGMrWUZVcQ42mBw/niqMqRpPLT6+KjqJErhdPvclJm1mHMkb8AZxY9L9b5WzVcPtbhnuLWlxgxO6Y9+qi41y71jbhf+5V78c6N1ndHEZn3ZDkPeVPUSD4ZDzJRftRhg4NLnb2oDSd2+R4GLxwSrtPh2t3i5wESO7newA1Pw1hRbTxG6LAE88h4a+Nuqw1arnGXEk806iQXC6e7JFxG3FP8A8dNzjbMhoA1k3iPNePgO0WHF/mawgaG9rQ0NbYkD9Ts9AFybahCuGJIvmeJ06DT7yVXWk9TWOApwTUe+RLI2lw27vGpujm1w0nh4dVmp9u4c3FVvjb4qH/zBmTc6ToqjEu1Kt1D2MHwqO7JsoYhjxLXtcORBWZQzgMa9j95jyHfrJMN5BvzPHIZmU9nMaa1Br3XdcEgQCRYkCT8VvTqc55+KwjoZ3uj00RFqcZr43CsqtLHtBadFyeL2MAM0nAyc33I8oMcIi2RNx2iKkoRlqa0686fysjbFbMVxlTJnWQT8bZ6cLytb/LFQHvU3E30tbPrn5a5KUkVPYROtcRqrsiHcX2fUBhtF4jNxY7ra3AG//Va7uznt9YOB4QZ4eF4U0wqbo4KnTrc1XFZL/H9yGKHZb3XPdbnPIZkcueS2P8OtYZWJPn1OdhlrKlw0Wn2RpoNLhWOwdMiDTaRexA1Mn3m6dOtw+KN9iHamGvusBc4+/rwaOfwSlgZy73P2Rxv7RHLxUuHsuiQR6GnDvW7rb5m9r3JPiqf4VQt/pMtAHdFg3IdAo6fzL+9PJkSHBE2Ann9/BY34YCbzGZ0Hj8h5KW3di4cjd9E2CItIsNLe/mbq1nYOGBaRRaN31c7WiwmJ1njfNR07LLii2ZFVPs5xu6WjpczlbTxVK+GAHAacT/Ov0Ur/AOBYf/1DTV2nG951nPWVjOzmFJ3jRBM5lzjy1PPyHAJ07C4pG+aZEooEmADyGp5xwVz8Nu+sbnIDNSxT2ewzcqQuZN3XPMk3jQaG4uqUtm8K0kikJIIkueTfO5Mg81HTst71hsyLKeAdG87uN4n4deWaNwhcYY09Tnztp95KV6nYGHcZNISBAu6wiLAGG+HE8Srh2Lh4I9E2DmL6CAOg4ZaqenZX3pHZkR1aAZYnedlAyB4TqeQV7cE6e9n+gRI66M8fcpXpdh4dp3m0WAxExcCIsdLa8ydVmpdk0GiBRYBJMbrcyIJ91k6d7h8VXZMiR+FJsBfgMhzJPxKsOEgx6zuA0+/sKY6eApN9WkwXBs0C4EA5ZgWV9PCsbkxo6ADLJT0/mU96v8pDg7OfwJPAA8Y+NuquHY9aYFGoTYQGnW1zkFM26OAVYU9MtyvvWf5SJDsziBYUnud7mi8ZnP4LeobFVyDvATMZgDqOXPyKk5UhWWHiZy4nVeiRw/ZWwjQ7erO3gDZrZAPU5xyHvXZ4Wg1jQ1jQ1oEAAQAOizIVpGEY6HJVrzqu82VRURXMSqIigBERSCiIigBVREBRERSAUREBVERAEREBRERAVVERAVREQFEREBVUKqiAIiIAiIgP/9k=" alt="Default Photo" class="profile-photo"> <!-- Default if none exists -->
        <?php endif; ?>

        <h2>User Details</h2>
        <p><strong>Username:</strong> <?= htmlspecialchars($user_data['username']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user_data['email']) ?></p>
        <p><strong>Help Statement:</strong> <?= htmlspecialchars($user_data['help_statement']) ?></p>
        <p><strong>Number of Donations Made:</strong> <?= htmlspecialchars($user_data['no_of_donations_made']) ?></p>
        <p><strong>Last Visited On:</strong> <?= htmlspecialchars($user_data['lv']) ?></p>

        <!-- Form to change profile photo -->
        <div class="upload-form">
            <form method="post" enctype="multipart/form-data"> <!-- Form to change profile photo -->
                <input type="file" name="photo" accept="image/*" required> <!-- File input for photo -->
                <button type="submit">Change Profile Photo</button> <!-- Button to submit change -->
            </form>
        </div>

        <!-- Form to delete account with password verification -->
        <div class="delete-form">
            <form method="post"> <!-- Form to delete the account -->
                <label for="password">Password:</label> <!-- Password label -->
                <input type="password" name="password" required> <!-- Password input -->
                <input type="hidden" name="delete_account" value="1"> <!-- Hidden input to indicate deletion -->
                <button type="submit"
                    onclick="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">Delete
                    Account</button> <!-- Red delete button with confirmation -->
            </form>
        </div>
    </div>
</body>

</html>