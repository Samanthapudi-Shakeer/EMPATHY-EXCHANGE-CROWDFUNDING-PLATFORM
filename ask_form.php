<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch POST data
    $fullname = $_POST['fullname'];
    $phone = $_POST['phoneno'];
    $amount = $_POST['amount'];
    $address = $_POST['address'];
    $subject = $_POST['subject'];
    $type = $_POST['helptype'];
    $deadline = $_POST['dead'];
    $timestamp = time();
    $currentDate = gmdate('Y-m-d', $timestamp);
    $uname = $_SESSION['$username'];
    $pwd = $_POST['lname'];
    
    
    // Database connection
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sampledb";

    $con = mysqli_connect($host, $username, $password, $dbname);

    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Check if phone number already exists
    $recheck = "SELECT * from record where phone = '$phone'";
    $re = mysqli_query($con, $recheck);

    if (mysqli_num_rows($re) > 0) {
        echo "<div class='alert alert-danger myclass mx-5' role='alert'>This phone number is already in use.</div>";
        echo "<div class='alert alert-danger myclass mx-5' role='alert'>Helpseeker with this phone number is alreasdy being served by us - Shakeer</div>";

    } else {
        // Check if username and password are valid
        $check_sql = "SELECT * FROM contact WHERE uname='$uname' AND pwd='$pwd'";
        $result = mysqli_query($con, $check_sql);

        if (mysqli_num_rows($result) == 1) {
            // Insert data into the 'record' table
            $insert_sql = "INSERT INTO `record`(`fname`, `phone`, `amount`, `address`, `subject`, `type`, `uname`, `doh`, `donor`, `deadline`) 
                           VALUES ('$fullname', '$phone', '$amount', '$address', '$subject', '$type', '$uname', '$currentDate', 'null', '$deadline')";

            if (mysqli_query($con, $insert_sql)) {
                echo "<div class='alert alert-success myclass mx-5' role='alert'>Your data is submitted, it is safe with us.</div>";
                header("Location: success.html");
                $_SESSION['username'] = $uname;
            } else {
                echo "Error inserting data: " . mysqli_error($con);
            }
        } else {
            echo "<div class='alert alert-danger myclass mx-5' role='alert'>Wrong Credentials provided, please re-provide.</div>";
            echo "<script>alert('Invalid username or password');</script>";
        }
    }

    mysqli_close($con);
}
?>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="./logo.ico">
    <style>
        html
        {
            background: radial-gradient(circle at 10% 20%, rgb(236, 158, 248) 0%, rgb(131, 83, 241) 90.1%);
        }
        .myclass {
            text-align: center;
            box-sizing: border-box;
            /*width: 50%;*/
            padding: 0;

        }

        :root {
            --clr-neutral-100: #60A3D9;
            --clr-neutral-200: #75E6DA;
            --clr-primary-100: #274472;
            --clr-primary-200: #BFD7ED;
        }

        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: inherit;
        }

        *:focus {
            outline: 2px solid var(--clr-primary-100);
            font-size: 18px;
        }

        *:focus-visible {
            outline: none;
        }

        ::placeholder {
            color: blueviolet;
            font-size: 0.8rem;
            font-weight: bold;
            letter-spacing: 2px;
            opacity: 0.8;
            transition: all 0.3s ease-in-out;
        }

        html {
            font-size: 100%;
            box-sizing: border-box;
        }

        body {
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
            font-size: 1rem;
            font-weight: bold;
            line-height: 1.3;
            letter-spacing: 2px;
            background: radial-gradient(circle at 10% 20%, rgb(236, 158, 248) 0%, rgb(131, 83, 241) 90.1%);
        }

        h1 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 0.5em;
        }

        .form-container {
            width: 70%;
            margin: 3em auto;
            padding: 2em;
            color: var(--clr-primary-100);
            background: linear-gradient(111.7deg, rgb(165, 41, 185) 19.9%, rgb(80, 177, 225) 95%);
            border-top: 15px solid;
            border-radius: 2px;
            box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.2);
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: 1em;
            font-weight: 700;
            letter-spacing: 1px;
            margin-top: 0.5em;
            margin-bottom: 1.5em;
            color: var(--clr-primary-100);
            background-color: var(--clr-primary-200);
            border: 2px solid var(--clr-primary-100);
            box-sizing: border-box;
            transition: all 0.3s ease-in-out;
        }

        .radio {
            margin-bottom: 2em;
        }

        p {
            margin-bottom: 0.5em;
        }

        input[type="radio"],
        input[type="checkbox"],
        #radio,
        #term {
            cursor: pointer;
        }

        fieldset {
            padding: 0.5em 1em 1em;
            margin-bottom: 2em;
            border-radius: 2px;
            border-color: var(--clr-primary-100);
        }

        legend {
            font-size: 1rem;
        }

        textarea {
            min-height: 150px;
            resize: none;
        }

        .btn {
            color: var(--clr-primary-200);
            background: linear-gradient(109.8deg, rgb(62, 5, 116) -5.2%, rgb(41, 14, 151) -5.2%, rgb(216, 68, 148) 103.3%);
            cursor: pointer;
            border: none;
            width: 100%;
            font-size: 1rem;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 1em 0;
            border-radius: 2px;
            transition: all 0.3s ease-in-out;
        }

        .btn:hover {
            color: var(--clr-primary-100);
            background: radial-gradient(circle at 10% 20%, rgb(236, 158, 248) 0%, rgb(131, 83, 241) 90.1%);
            outline: auto;
            outline-color: #60A3D9;
            transition: all 0.3s ease-in-out;
        }

        @media (max-width: 640px) {
            .form-container {
                width: 95%;
            }
        }

        img {
            margin-top: 15%;
            height: 18%;
            width: 15%;
            border-radius: 50%;
            box-sizing: border-box;
        }
        *,
*::before,
*::after {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
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
  background: linear-gradient(109.8deg, rgb(62, 5, 116) -5.2%, rgb(41, 14, 151) -5.2%, rgb(216, 68, 148) 103.3%);
  position: relative;
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
    background: radial-gradient(circle at 10% 20%, rgb(236, 158, 248) 0%, rgb(131, 83, 241) 90.1%);

    position: absolute;
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
    <div align="center"><img src="./logomain.png" alt="" style="margin: 0; padding: 0;"></div>
    <button onclick="srun()" class="button">
  <span class="text"><a href="site.php" style="text-decoration:none; color:steelblue;font-weight:bold;">Go Back</a></span>
  <div class="overlay">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right">
      <path d="M5 12h14" />
      <path d="m12 5 7 7-7 7" />
    </svg>
  </div>
</button>
    <div class="form-container">
        <h1>Ask for a Help <br><span style='color:steel;font-weight:bolder'>Empathy Exchange</h1>
        <form action="ask_form.php" class="form" method="POST" role="form">
            <label for="first-name">Fullname of Help Seeker</label>
            <input type="text" name="fullname" id="first-name" placeholder="Fullname" required>

            <label for="last-name">Phone Number of Help Seeker</label>
            <input type="text" name="phoneno" id="phoneno" placeholder="Phone Number linked with Active Bank Account"
                required>

            <label for="number">Amount Required</label>
            <input type="text" name="amount" id="number" placeholder="Amount Required" required>

            <label for="">Address</label>
            <input type="text" name="address" id="email" placeholder="Address" required>
            <!--<input type="file" placeholder="Only Image" name="photo">-->
            <fieldset>
                <legend>Choose type of help needed (Optional)</legend>
                <select name="helptype" id="help-type">
                <option value="Medical">Medical</option>
                <option value="Educational">Education</option>
                <option value="Financial">Financial</option>
                <option value="FoodHunger">Food Hunger </option>
                </select>
                <br>
                <label for="subject">Describe about your help</label>
                <textarea name="subject" id="subject" placeholder="Write something about requirement . . .(Max 250)"
                    required></textarea>
                <br>
                <br>
                
                <br>
                <br>
                <br>
                <label for="subject">Deadline Date for Requirement</label>
                <input type="date" name="dead" id="dead" placeholder="Date"
                    required>
                    <br>
                    <br>
                <label for="fname">Username </label>
                <input type="text" name="fname" id="fname" placeholder="Enter your Username here !!" required>
                <label for="">Password</label>
                <input type="password" name="lname" id="lname" placeholder="Enter your Password here!! &#x1F92B;"
                    required>
                <input type="checkbox" id="terms" name="terms">
                <label for="terms" id="term">I Agree to the <a href="https://docs.google.com/presentation/d/1EPFfd3OZ_33mu2QO5w69dtVnJFFo6Wc2HZGRIKA0gH8/edit#slide=id.g26ff1b1eeff_0_0" style="text-decoration:none;color:yellow">Terms and Conditions</a></label>
                <br><br>
                <input type="reset" value="Reset" class="btn"><br><br>
                <input type="submit" value="Submit" name="submit" class="btn">

        </form>
    </div>
    <script>
        // Animation

        // Focus Input
        window.addEventListener('load', function () {
            const formInputs = document.querySelectorAll('.form input');
            formInputs.forEach(input => {
                input.addEventListener('focus', function () {
                    this.style.transform = 'scale(1.03)';
                });
                input.addEventListener('blur', function () {
                    this.style.transform = 'scale(1)';
                });
            });
        });
        function srun()
        {
            location.replace("site.php");
        }
    </script>
</body>