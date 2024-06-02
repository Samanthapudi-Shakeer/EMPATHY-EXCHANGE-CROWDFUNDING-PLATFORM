<?php
session_start();
// Database connection details
echo $_SESSION['$username'];
$servername = "localhost"; // Adjust as necessary
$username = "root"; // Adjust as necessary
$password = ""; // Adjust as necessary
$dbname = "sampledb"; // Adjust as necessary
session_destroy();
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// SQL query to sum the amount where type is 'edu'
$sql = "SELECT SUM(`amount`) AS totalf_amount FROM record WHERE type = 'FoodHunger'";
$asql = "SELECT SUM(`amount`) AS totalm_amount FROM record WHERE type = 'Medical'";
$bsql = "SELECT SUM(`amount`) AS totale_amount FROM record WHERE type = 'Educational'";
$csql = "SELECT SUM(`amount`) AS totalfi_amount FROM record WHERE type = 'Financial'";

// Execute the query
$result = $conn->query($sql);
$ar = $conn->query($asql);
$br = $conn->query($bsql);
$cr = $conn->query($csql);

$row = $result->fetch_assoc();
$totalf_amount = $row['totalf_amount']; // Get the sum from the result
$row = $ar->fetch_assoc();
$totalm_amount = $row['totalm_amount']; // Get the sum from the result
$row = $br->fetch_assoc();
$totale_amount = $row['totale_amount'];
$row = $cr->fetch_assoc();
$totalfi_amount = $row['totalfi_amount'];
$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
  <title>Empathy Exchange</title>
  <link rel="icon" type="image/x-icon" href="./logo.ico">


  <style>
    html {
      background: linear-gradient(89.7deg, rgb(0, 32, 95) 2.8%, rgb(132, 53, 142) 97.8%);
      overflow-x: hidden;
    }

    :root {
      --m: 4rem;
    }

    .image-container {
      position: relative;
      width: 300px;
      height: 200px;
      border: 15px ridge #07386c;
      box-sizing: border-box;
      margin-right: 25px;
      float: left;
      align-self: center;
    }

    .image-container img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: filter 0.3s ease-in-out;
      filter: grayscale(0%);
    }

    .image-container img:hover {
      filter: blur(5px);
      transition: 0.2s ease-in;
    }

    .image-number {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      font-size: 2rem;
      opacity: 1;
      color: black;
      font-weight: bold;
      transition: opacity 0.3s ease-in-out;
    }

    .image-container:hover .image-number {
      opacity: 0;
      transition: opacity 0.3s ease-in-out;
    }

    .image-letter {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      font-size: 16px;
      opacity: 0;
      transition: transform 0.3s ease-in-out;
    }

    .image-container:hover .image-letter {
      transform: translate(-50%, -50%);
      opacity: 1;
      transition: transform 0.3s ease-in-out;
      color: #ffffff;
    }

    .image-description {
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      text-align: center;
      background-color: rgba(0, 0, 0, 0.5);

      padding: 5px 0;
      opacity: 0;
      transition: opacity 0.3s ease-in-out;
    }

    .image-container:hover .image-description {
      opacity: 1;
    }

    .image-container:hover {
      border: 15px ridge blueviolet;
      transition: ease-in-out 0.8s;
    }

    .main {
      box-sizing: border-box;
      display: inline;
      justify-content: center;
      margin-top: 20%;
    }

    body {
      font-family: Arial, sans-serif;
      color: white;
      background-color: #07386c;
    }

    .heading {
      color: blueviolet;
      text-align: center;
      padding: 20px 0;
      background: linear-gradient(109.2deg, rgb(254, 3, 104) 9.3%, rgb(103, 3, 255) 89.5%);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;

    }

    .heading1 {
      color: blueviolet;
      padding: 20px 0;
      background: linear-gradient(109.2deg, rgb(254, 3, 104) 9.3%, rgb(103, 3, 255) 89.5%);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
    }

    .content {
      margin-left: 10%;
      margin-right: 10%;
      padding: 20px;
      font-size: 25px;
    }

    .education {
      color: #1ACAD3;
      font-size: 27px;
      font-weight: bold;
    }

    .activism {
      color: #1ACAD3;
      font-size: 27px;
      font-weight: bold;
    }

    .science {
      color: #1ACAD3;
      font-size: 27px;
      font-weight: bold;
    }

    .thank-you {
      color: white;
      font-weight: bold;
    }

    .action-info {
      color: white;
      padding: 10px;
      text-align: center;
      margin-bottom: 45px;
    }

    .content1 {
      font-family: 'Times New Roman', Times, serif;
      font-size: 22px;
      text-align: center;
      color: white;
    }

    span {
      font-family: 'Times New Roman', Times, serif;
    }

    .ac {
      color: #1ACAD3;
      font-family: 'Times New Roman', Times, serif;
      font-size: 25px;
      text-align: center;
      margin-left: 16%;
      margin-right: 16%;
    }

    .open {
      background-color: black;
    }

    .open {
      display: flex;
      align-items: center;
    }

    .open a {
      margin: 0;
      padding: 10px;
      margin-right: 50px;
      font-family: 'Times New Roman', Times, serif;
      font-size: 18px;
      color: blueviolet;
      text-decoration: none;
    }

    .open a:hover {
      cursor: grab;
    }

    .lo {
      height: 16vh;
      width: 26vh;
      box-sizing: border-box;
      margin-left: 0px;
    }

    a {
      position: relative;
      text-decoration: none;
      color: #333;
      font-family: 'Times New Roman', Times, serif;
      font-weight: bold;
    }

    a::before {
      content: '';
      position: absolute;
      width: 100%;
      height: 2px;
      bottom: 0;
      left: 0;
      background-color: whitesmoke;
      visibility: hidden;
      transform: scaleX(0);
      transition: all 0.3s ease-in-out;
    }

    a:hover::before {
      visibility: visible;
      transform: scaleX(1);
    }

    .full,
    .my {
      background: linear-gradient(89.7deg, rgb(0, 32, 95) 2.8%, rgb(132, 53, 142) 97.8%);

    }

    @keyframes glow {
      0% {
        box-shadow: 0 0 5px 0 rgba(138, 43, 226, 0.8);
      }



      100% {
        box-shadow: 0 0 5px 0 rgba(138, 43, 226, 0.8);
      }
    }

    /*newome*/
    /* Actual CodePen code */
    #AboutArticle {
      position: relative;
      display: flex;
      flex-direction: row;
      min-width: 800px;
      max-width: 800px;
      background-color: rgba(255, 255, 255, 0.05);
      z-index: 1;
      padding: 20px;
      margin: 20px 0px;
      border-radius: 5px;
      animation: glow 1s infinite alternate;
    }

    #AboutArticle:hover>#About img {
      left: 600px;
      transition: all .6s ease;
    }

    #AboutArticle:hover>#About #AboutMe {
      width: 0;
      transition: all .6s ease;
    }

    #AboutArticle:hover>#About #AboutInfo {
      width: 555px;
      transition: all .6s ease;
    }

    #About {
      position: relative;
      display: flex;
      flex-direction: row;
      justify-content: flex-start;
      align-items: center;
      width: 100%;
      padding: 0;
      margin: 0;
      left: 0;
    }

    #About img {
      position: absolute;
      left: 0;
      border-radius: 5px;
      box-shadow: 0 -2px 10px rgba(0, 0, 0, 1);
      transition: all .6s ease;
      width: 200px;
      height: 300px;
    }

    #AboutMe h1 {
      font-size: 20px;
      font-weight: 700;
      letter-spacing: 1px;
      text-transform: uppercase;
    }

    #AboutMe h1::first-letter {
      font-size: 25px;
    }

    #AboutMe {
      overflow: hidden;
      position: absolute;
      width: 590px;
      min-height: 300px;
      max-height: 300px;
      right: 0;
      transition: all .6s ease;
    }

    #AboutMe div {
      position: absolute;
      overflow: hidden;
      right: 0;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: flex-start;
      padding: 20px;
      text-align: justify;
      min-width: 550px;
      max-width: 550px;
      min-height: 100%;
      max-height: 100%;
    }

    #AboutInfoText span h1 {
      font-size: 20px;
      font-weight: 700;
      letter-spacing: 1px;
      text-transform: uppercase;
    }

    #AboutInfoText span h1::first-letter {
      font-size: 25px;
    }

    #AboutInfoText span h3 {
      letter-spacing: 0.5px;
      font-size: 15px;
      text-transform: uppercase;
    }

    #AboutInfoText span h3::first-letter {
      font-size: 20px;
    }

    #AboutInfo {
      position: relative;
      text-align: center;
      overflow: hidden;
      width: 0;
      min-height: 300px;
      max-height: 300px;
      padding: 0;
      margin: 0;
      right: 0;
      transition: all .6s ease;
    }

    #AboutInfo #AboutInfoText span>* {
      display: inline-block;
      text-decoration: none;
      color: var(--OnBackground);
      padding: 0;
      margin: 0;
    }

    #AboutInfo #AboutInfoText {
      position: absolute;
      overflow: hidden;
      left: 0;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      column-gap: 0px;
      row-gap: 0px;
      min-width: 555px;
      max-width: 555px;
      min-height: 300px;
      max-height: 300px;
    }

    #InfoIcons .LinkIcons {
      color: var(--Secondary) !important;
      text-shadow: 0 -2px 10px rgba(0, 0, 0, 1);
    }

    /* Just page formatting */
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap");

    :root {
      --Background: #000000;
      --Surface: #222222;
      --Primary: #ff7597;
      --Secondary: #ff0266;
      --OnColor: #121212;
      --OnBackground: #fff;
    }

    body {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      background-color: var(--Background);
      padding: 0;
      margin: 0;
      font-family: "Poppins", sans-serif;
      color: #f0ffff;
      height 100vh;
      width 100%;
    }

    * {
      font-family: 'Poppins', sans-serif;
    }

    .section {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      width: 70%;
      background-color: var(--Surface);
      border-radius: 5px;
      padding: 20px;
      margin: 10px 0px;
    }

    p {
      text-align: justify;
    }


    h1 {
      color: white;
      text-align: center;
    }

    .hope {
      width: 100%;
      height: 100%;
      opacity: 0.1;
      z-index: -1;
      grid-area: 1/1;
      object-fit: cover;
    }

    .hope:hover {
      opacity: 1;
    }

    /** container **/
    .container {
      display: flex;
      align-items: stretch;
      justify-content: space-between;
      z-index: 1;
      gap: 10px;
    }

    /** cards **/
    .cont-items {
      color: white;
      background: linear-gradient(89.7deg, rgb(0, 32, 95) 2.8%, rgb(132, 53, 142) 97.8%);
      height: 60vh;
      width: 240px;
      border: 2px solid transparent;
      /* Transparent border */
      border-radius: 20px;
      /* Optional: rounded corners */
      box-shadow: 0 0 20px 0 rgba(255, 255, 255, 0.5);
      /* Light glow */
      overflow: hidden;
      display: grid;
      transition: border-radius 500ms, opacity 500ms, width 500ms;
      user-select: none;
      isolation: isolate;
    }

    .container:hover>.cont-items {
      opacity: 0.3;

    }

    .cont-items:hover>img {
      background: radial-gradient(circle at 11.7% 80.6%, rgb(249, 185, 255) 0%, rgb(177, 172, 255) 49.3%, rgb(98, 203, 255) 89%);
      opacity: 1;
    }

    .cont-items:hover .icon {
      opacity: 0;
    }

    .container:hover>.cont-items:hover {
      opacity: 1;
      height: 40vw;
      width: 80vw;
      border-radius: 50px;

    }

    /** icon **/
    .icon {
      width: 100px;
      height: 100px;
      margin-inline: auto;
      border-radius: 50px;
      color: black;
      background-color: pink;
      text-align: center;
      grid-area: 1/1;
      transition: width 1000ms;
      translate: 0 20px;
    }

    .footer {
      position: relative;
      text-align: center;
      padding: 20px;
      padding-top: 0;
      font-size: 20px;
      color: white;
      background: linear-gradient(to bottom, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 1));
    }

    .footer .social-icons {
      display: flex;
      justify-content: center;
      gap: 20px;
      margin-top: 10px;
    }

    .footer img {
      height: calc(0.4 * var(--m));
      object-fit: cover;
    }

    .footer .social-icons a {
      text-decoration: none;
      color: white;
      font-size: 24px;
      transition: color 0.3s, transform 0.3s;
    }

    .footer .social-icons a:hover {
      color: #f2f2f2;
      transform: scale(1.1);
    }

    .glowing-box {
      display: inline-block;
      background: linear-gradient(to bottom, rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.5));
      color: white;
      padding: 10px;
      border-radius: 10px;
      margin: 10px;
      text-align: center;
      box-shadow: 0px 0px 10px 2px rgba(255, 255, 255, 0.5);
    }

    .glowing-box:hover {
      box-shadow: 0px 0px 20px 4px rgba(255, 255, 255, 0.7);
    }

    .footer-text {
      font-size: 18px;
      text-align: left;
      margin-top: 20px;
    }

    footer {
      margin-top: 8px;
      z-index: 500;
      width: 100%;
      height: 100vh;

      display: flex;
      flex-direction: row;
      justify-content: space-evenly;
      align-items: flex-end;
      padding: 5rem 2vw;
      position: relative;
    }

    footer::before {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(rgba(0, 0, 0, 0) 5%,
          rgba(0, 0, 0, 0.3) 20%,
          rgba(0, 0, 0, 0.6) 30%,
          rgba(0, 0, 0, 0.8) 40%,
          rgba(0, 0, 0, 1) 50%,
          rgb(0, 0, 0));
      z-index: -7;

    }

    .col {
      flex-direction: column;
      align-items: flex-start;
      justify-content: flex-start;
      padding: calc(0.3 * var(--m)) calc(0.8 * var(--m));
      width: 28%;
    }

    .col2,
    .col3 {
      background-color: #121212;
      border-radius: calc(0.5 * var(--m))
    }

    .social {
      display: flex;
      flex-direction: row;
      justify-content: flex-start;
      gap: 1rem;
    }
  </style>

</head>

<body>
  <div class="open">
    <img src="./all.jpg" alt="" class="lo">
    <img src="./logomain.png" class="lo">
    <a style="margin-left:25% ;font-size:22px;">Home</a>
    <!--<a href="./mainsite.php" style="font-size:22px;">Donate</a>-->
    <a href="./form.html" style="font-size:22px;">Register</a>
    <a href="./main.html" style="font-size:22px;">Login</a>
    <a href="./ask_form.php" style="font-size:22px;">Ask?</a>
    <!--<a href="./feedback.php" style="font-size:22px;">Feedback </a>-->
  </div>
  <div class="full">
    <div class="heading">
      <h1 style="margin-top:60px;">YOUR GENEROSITY EMPOWERS OUR WORK!</h1>
    </div>

    <div class="content">
      <p class="content1">We greatly appreciate your support in aiding individuals with essential needs, food, medical care, education, and financial assistance. Through programs in <span
          class="education">Education</span>, <span class="activism">Food for hunger</span> and <span
          class="science">Medical care.</span> <br> We advocate for global change to support a circular economy and
        sustainable communities worldwide.</p>
    </div>

    <div class="action-info">
      <p class="ac">Every person making a donation receives <span class="thank-you">A kind present from 
  Almighty.</span> <br><span class="thank-you">100%</span> of your contribution goes to direct action in our
        projects & programs.</p>
    </div>


    <div class="main">
      <div class="image-container" style="margin-left:22%">
        <img src="./hunger.jpeg" alt="Random Image 1" style="height: 100%;width: 100%;object-fit:cover">
        <div class="image-number"></div>
        <div class="image-letter" style="color:white;font-weight:bold;">
        <p>Required</p>
    <p><?php echo '<p style="text-align:center;">&#8377;</p> '.$totalf_amount;?></p>
        </div>
        <div class="image-description">
          Food Hunger Donated &#8377 5.5L
        </div>
      </div>
      <div class="image-container">
        <img src="./he2.jpg" alt="Random Image 2">
        <div class="image-number"></div>
        <div class="image-letter" style="color:white;font-weight:bold;">
        <p>Required</p>
        <p><?php echo '<p style="text-align:center;">&#8377;</p> '.$totalm_amount;?></p></div>
        <div class="image-description">
          Medical Purpose Donated &#8377 1.5L
        </div>
      </div>
      <div class="image-container">
        <img src="./he1.jpg" alt="Random Image 3">
        <div class="image-number"></div>
        <div class="image-letter" style="color:white;font-weight:bold;">
        <p>Required</p>
        <p><?php echo '<p style="text-align:center;">&#8377;</p> '.$totalfi_amount;?></p></div>
        <div class="image-description">
          Financial Support Donated &#8377 2.5L
        </div>
      </div>
  </div>
    <br>
    <br>
    <p style="clear:both;text-align:center;margin-top:80px;"></p>
    <h1 class="heading" style="margin-top:12%;margin-bottom:6%">Donate the needy now</h1>
    <p><?php $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sampledb";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    } else {
      $sql = "SELECT * FROM `record` ORDER BY `amount` desc limit 1";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo "
                    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.min.css' integrity='sha512-5PV92qsds/16vyYIJo3T/As4m2d8b6oWYfoqV+vtizRB6KhF1F9kYzWzQmsO6T3z3QG2Xdhrx7FQ+5R1LiQdUA==' crossorigin='anonymous' referrerpolicy='no-referrer' />
                    
                    <!-- Card -->
                    <article id='AboutArticle' class='Article' style='margin-left:26%'>
                      <!-- About generl info -->
                      <div id='About'>
                        <div id='AboutInfo'>
                          <div id='AboutInfoText'>
                            <span>
                            <a href='http://localhost/Mysite/main.html'>
                              <h1>Donate Now</h1>
                            </a>
                            </span>
                            <span>
                              <h3 style='color: var(--Secondary);'>For &nbsp $row[fname]</h3>
                            </span>
                            <br>
                            <span>
                              <h3>$row[type]</h3>
                              <p></p>
                            </span>
                            <span>
                              <h3></h3>
                            </span>
                            <span>
                              <h3>$row[subject]</h3>
                              <br>
                              <br>
                              <p>Phone :(91+) $row[phone] <br></p>
                            </span>
                            <span>
                              <h3><br>Address : $row[address]</h3>
                              <p></p>
                            </span>
                          </div>
                    
                        </div>
                    
                        <!-- About image -->
                        <img src='med.jpg'>
                    
                        <!-- About description -->
                        <div id='AboutMe'>
                          <div>
                            <h1>Hello this is <p style='color:blueviolet;'>$row[fname]</p></h1>
                            <h3>$row[subject]</h3>
                            <p>Amount Required : &#8377 $row[amount]</p>
                          </div>
                        </div>
                    
                      </div>
                    
                    </article>";
        }
      }
    }
    ?></p>
    <br>
    <br>
    <p><?php $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sampledb";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    } else {
      $sql = "SELECT * FROM `record` ORDER BY `amount` desc limit 1,1";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo "
                    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.min.css' integrity='sha512-5PV92qsds/16vyYIJo3T/As4m2d8b6oWYfoqV+vtizRB6KhF1F9kYzWzQmsO6T3z3QG2Xdhrx7FQ+5R1LiQdUA==' crossorigin='anonymous' referrerpolicy='no-referrer' />
                    
                    <!-- Card -->
                    <article id='AboutArticle' class='Article' style='margin-left:26%'>
                      <!-- About generl info -->
                      <div id='About'>
                        <div id='AboutInfo'>
                          <div id='AboutInfoText'>
                            <span>
                            <a href='http://localhost/Mysite/main.html'>
                              <h1>Donate Now</h1>
                            </a>
                            </span>
                            <span>
                              <h3 style='color: var(--Secondary);'>For &nbsp $row[fname]</h3>
                            </span>
                            <br>
                            <span>
                              <h3>$row[type]</h3>
                              <p></p>
                            </span>
                            <span>
                              <h3></h3>
                            </span>
                            <span>
                              <h3>$row[subject]</h3>
                              <br>
                              <br>
                              <p>(91+) $row[phone] <br></p>
                            </span>
                            <span>
                              <h3><br>Address : $row[address]</h3>
                              <p></p>
                            </span>
                          </div>
                    
                        </div>
                    
                        <!-- About image -->
                        <img src='edu.jpeg'>
                    
                        <!-- About description -->
                        <div id='AboutMe'>
                          <div>
                            <h1>Hello this is <p style='color:blueviolet;'>$row[fname]</p></h1>
                            <h3>$row[subject]</h3>
                            <p>Amount Required : &#8377 $row[amount]</p>
                          </div>
                        </div>
                    
                      </div>
                    
                    </article>";
        }
      }
    }
    ?></p>
    <br>
    <br>
    <p><?php $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sampledb";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    } else {
      $sql = "SELECT * FROM `record` ORDER BY `amount` desc limit 2,1";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo "
                    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.min.css' integrity='sha512-5PV92qsds/16vyYIJo3T/As4m2d8b6oWYfoqV+vtizRB6KhF1F9kYzWzQmsO6T3z3QG2Xdhrx7FQ+5R1LiQdUA==' crossorigin='anonymous' referrerpolicy='no-referrer' />
                    
                    <!-- Card -->
                    <article id='AboutArticle' class='Article' style='margin-left:26%'>
                      <!-- About generl info -->
                      <div id='About'>
                        <div id='AboutInfo'>
                          <div id='AboutInfoText'>
                            <span>
                            <a href='http://localhost/Mysite/main.html'>
                              <h1>Donate Now</h1>
                            </a>
                            </span>
                            <span>
                              <h3 style='color: var(--Secondary);'>For &nbsp $row[fname]</h3>
                            </span>
                            <br>
                            <span>
                              <h3>$row[type]</h3>
                              <p></p>
                            </span>
                            <span>
                              <h3></h3>
                            </span>
                            <span>
                              <h3>$row[subject]</h3>
                              <br>
                              <br>
                              <p>(91+) $row[phone] <br></p>
                            </span>
                            <span>
                              <h3><br>Address : $row[address]</h3>
                              <p></p>
                            </span>
                          </div>
                    
                        </div>
                    
                        <!-- About image -->
                        <img src='hungerr.jpg'>
                    
                        <!-- About description -->
                        <div id='AboutMe'>
                          <div>
                            <h1>Hello this is <p style='color:blueviolet;'>$row[fname]</p></h1>
                            <h3>$row[subject]</h3>
                            <p>Amount Required : &#8377 $row[amount]</p>
                          </div>
                        </div>
                    
                      </div>
                    
                    </article>
                    <!--now why help page-->
                  
                    <br>
                    <br>
  
                    <!--<h1 class='heading' style='margin-top:12%;'><pre>What  Where When  Why How</pre></h1>-->
                    <h1 class='heading' style='margin-bottom:6%''><pre>Helping ?? :{</pre></h1>
                    <div class='container' style='margin-left:9%; margin-top:7%;'>
                    <div class='cont-items'>
                      <div class='icon' style='background: radial-gradient(circle at 11.7% 80.6%, rgb(249, 185, 255) 0%, rgb(177, 172, 255) 49.3%, rgb(98, 203, 255) 89%);'><i class='fa-solid fa-heart fa-xl'><button style='background: radial-gradient(circle at 11.7% 80.6%, rgb(249, 185, 255) 0%, rgb(177, 172, 255) 49.3%, rgb(98, 203, 255) 89%);margin-top:25%;border:0px;s'><p style='font-weight:bold;color:white;font-size:18px'>Why</p></button></i><p></p></div>
                      <img class='hope' src='why1.png'</img>
                      </div>
                      <div class='cont-items'>
                      <div class='icon' style='background: radial-gradient(circle at 11.7% 80.6%, rgb(249, 185, 255) 0%, rgb(177, 172, 255) 49.3%, rgb(98, 203, 255) 89%);'><i class='fa-solid fa-heart fa-xl'><button style='background: radial-gradient(circle at 11.7% 80.6%, rgb(249, 185, 255) 0%, rgb(177, 172, 255) 49.3%, rgb(98, 203, 255) 89%);margin-top:25%;border:0px;s'><p style='font-weight:bold;color:white;font-size:18px'>What</p></button></i><p></p></div>
                      <img class='hope' src='what.png'</img>
                      </div>
                      <div class='cont-items'>
                      <div class='icon' style='background: radial-gradient(circle at 11.7% 80.6%, rgb(249, 185, 255) 0%, rgb(177, 172, 255) 49.3%, rgb(98, 203, 255) 89%);'><i class='fa-solid fa-heart fa-xl'><button style='background: radial-gradient(circle at 11.7% 80.6%, rgb(249, 185, 255) 0%, rgb(177, 172, 255) 49.3%, rgb(98, 203, 255) 89%);margin-top:25%;border:0px;s'><p style='font-weight:bold;color:white;font-size:18px'>Where</p></button></i><p></p></div>
                      <img class='hope' src='where.png'</img>
                      </div>
                      <div class='cont-items'>
                      <div class='icon' style='background: radial-gradient(circle at 11.7% 80.6%, rgb(249, 185, 255) 0%, rgb(177, 172, 255) 49.3%, rgb(98, 203, 255) 89%);'><i class='fa-solid fa-heart fa-xl'><button style='background: radial-gradient(circle at 11.7% 80.6%, rgb(249, 185, 255) 0%, rgb(177, 172, 255) 49.3%, rgb(98, 203, 255) 89%);margin-top:25%;border:0px;s'><p style='font-weight:bold;color:white;font-size:18px'>When</p></button></i><p></p></div>
                      <img class='hope' src='when.png'</img>
                      </div>
                      <div class='cont-items'>
                      <div class='icon' style='background: radial-gradient(circle at 11.7% 80.6%, rgb(249, 185, 255) 0%, rgb(177, 172, 255) 49.3%, rgb(98, 203, 255) 89%);'><i class='fa-solid fa-heart fa-xl'><button style='background: radial-gradient(circle at 11.7% 80.6%, rgb(249, 185, 255) 0%, rgb(177, 172, 255) 49.3%, rgb(98, 203, 255) 89%);margin-top:25%;border:0px;s'><p style='font-weight:bold;color:white;font-size:18px'>How</p></button></i><p></p></div>
                      <img class='hope' src='how.png'</img>
                      </div>
                    
                  <div class='bg'></div>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  <br>
                  "
          ;
        }

      }
    }
    ?></p>
    <br>
    <br>

  </div>


  <!-- Footer with fading effect -->


  <!-- Footer with fading effect and social media icons -->
  <footer class="footer">
    <h1 class="heading">Empathy Exchange</h1>
    <div class="col col2">
      <p>About</p>
      <p>Our mission</p>
      <p>Privacy Policy</p>
      <p>Terms of service</p>
      <div class="social">
        <div class="social-icons">
          <a href="https://www.instagram.com/sriram_the_1" target="_blank" title="insta"><img
              src="data:image/jpeg;base64,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"
              alt=""></a>
          <a href="https://twitter.com/Shakeer_S27" title="Email"><img style="height:20px"
              src="data:image/png;base64,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"
              alt=""></a>
          <a href="https://www.linkedin.com" target="_blank" title="LinkedIn"><img
              src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMwAAADACAMAAAB/Pny7AAAAaVBMVEUAAAD///9ubm7s7Oxra2uLi4scHBy+vr76+vpzc3P19fXw8PDIyMixsbGcnJzS0tK4uLhhYWHm5uYLCwvf39+oqKg+Pj4xMTEsLCx5eXnY2NhEREQmJiYYGBhcXFxUVFSDg4NLS0uTk5NVZwVFAAAEe0lEQVR4nO2d23aqMBBAQ1WM3EWCAlLR///IA7raUxWSaCYrjGv2Q99oZ6/QXCYZwryBfMtQs82vGmz4sVi6jsaU5eJHJli5jsWcVXCT4bHrSCCI+VWmaFwHAkFTDDI8cR0HDAnvZQrfdRgw+EUv8yEN0zdNL3N0HQQUR4/lrmOAI2fCdQhwCNa5DgGOjpWuQ4CjZK3rEOBo2c51CHB8kApBEIQm7XHflAf/Awamw3eXiHUaZSLZnHCvgParrPB+4HVc4dVpVxH37gjXG9dBvUmTBd4TC5wpnVP6rDK8bKnrwN5guxh1GRrHdWgv0xRTLp5Xuw7uRQ7RtIvnrV2H9xqJzAVZkrqUuvQv2t51hC+QKWQwpXZ9hYvnRXiaplPKhJXrGLUZHy7vQJND9EemMY+ssbxnZ66WSc+uo9RkqyGDZp96pSETYFkLyId/ZDKVRsuEX66j1ORbQ6b4dh2lJs0n9WYsVMugGWeYdDFzA89Ms1K6LLB0Zj1KmejgOkR9LgoXXEtNxVQzQrXzJl/RIFrNDPjShTOeruzGXtI9Z66De5nz5HIzQ3iEqJx40xKELowdLyNztEWFqiP7z+6pcXiC+cjNUfwZcfILmtnlFGUnojTNkgq9CUEQBEEQBEEQM6BFunR9oOniqC6Koq775dIG83KpFEX4ZxXLg7AWlvZ8vjwuYbSMeCV75HHbYJOPZn7yi40Dx19TSbNbimZcRkb4R6atJKnsuAT/HwKX+d8yfiU5ZDggoDNA1mR2p1i5Y7oAzp3Yktl1ima5sQbdy7Yk0wqNvd+BogPsCezItI8n2KcJAVPadmQ0zrH9EggwGysyr7j0w2gGVUVhQ0bjdME9UGUH8DLLRPv/5Reg7UZwmVyMT2DkwGwEg8vw19tlAGTqCS7zJgXEXGAuMiCdwGxkQoCPFs1GBuLI0XxkAM4czUcGoIZiRjK8+yAZ8+Mt1mVeGEONv8JmU4bndZTFWVTnmkaX2coEqdje8i+7rUi1dCLDDIc1mfTuyMrhorPGCU/zlIkfZ47nWOMpw8mzJZnVc8fkq07q9gizNacdmW70b6kfNJzSWJGZKLprherB3GwSYEMmnRr8SlV2IDDrzmzITGcpK1Vq0Kw7syATS2YlqvJjs2o9eBkuq+vqFE1jNqGBl5GWQpU1LhkhzYQr3jOzaj14GflsUcgnaXOTka9+L/Ial5nJKKpUNvIeYGYyiiK15eSHYUiGZEiGZEiGZEiGZEiGZEiGZEiGZEiGZEiGZEiGZEiGZEiGZEiGZEiGZEiGZEiGZEiGZEiGZEiGZEiGZD5HZiP93aO3gshlAvmB0y/5gVOzWwhO0VpCPFZosJQ+ksk/vnKKZQ9HZoUNO1/K2BeI3ngE6GGCIAiCILT5oEF1x/DeWv6EzxrXIcDRsM51CHB0DOcF7KPEDN+N5ZMsmIf5K7x37D2G7kqsSZJepkB0I56MQ9HLcDRXL8sRvJfxcjT3e8o4594gg/DytRGG4vtBhpt+BGkGXK8vu16ZGXSuYzGlu5be/wP9S1TTxpaEKQAAAABJRU5ErkJggg=="
              alt=""></a>
          <a href="mailto:shannus084@gmail.com" title="Email"><img style="height:20px"
              src="data:image/png;base64,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"
              alt=""></a>
        </div>
      </div>
    </div>
    <div class="col col3">
      <p>Services</p>
      <p>Products</p>
      <p>Join our team</p>
      <p>Partner with us</p>
      <div class="footer-text" style="font-weight:bold;">
        <br>
        EE © 2024 | Registered by Shakeer
      </div>
    </div>




  </footer>
</body>

</html>
<?php
session_start();

// Clear only this user's session data
session_unset();
session_destroy();

// Clear the session cookie for this user
setcookie("session_id", "", time() - 3600, "/"); // Expire the cookie

header("Location: login.php");
exit;
?>