<script>
    alert("Already Donated by Someone");
</script>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help for People</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(114.9deg, rgb(0, 40, 60) 41.6%, rgb(0, 143, 213) 93.4%);
        }
        .container {
            max-width: calc(100% + 100vh);
            margin: 0 auto;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            color: goldenrod;
        }
        h1 {
            text-align: center;
            margin-top: 30px;
            margin-bottom: 20px;
        }
        form {
            text-align: center;
            margin-bottom: 20px;
        }
        form label {
            margin-right: 10px;
        }
        form select {
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-right: 10px;
            background-color: bisque;
        }
        form button {
            padding: 8px 16px;
            background: linear-gradient(114.9deg, rgb(0, 40, 60) 41.6%, rgb(0, 143, 213) 93.4%);
            color: goldenrod;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        form button:hover
        {
            font-size: 1rem;
            font-weight: bolder;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background: linear-gradient(112.1deg, rgb(32, 38, 57) 11.4%, rgb(63, 76, 119) 70.2%);
            cursor: pointer;
            color: goldenrod;
        }
        tr:nth-child(even) {
            background: radial-gradient(328px at 2.9% 15%, rgb(191, 224, 251) 0%, rgb(232, 233, 251) 25.8%, rgb(252, 239, 250) 50.8%, rgb(234, 251, 251) 77.6%, rgb(240, 251, 244) 100.7%);
        }
        tr:hover {
            background: radial-gradient(328px at 2.9% 15%, rgb(191, 224, 251) 0%, rgb(232, 233, 251) 25.8%, rgb(252, 239, 250) 50.8%, rgb(234, 251, 251) 77.6%, rgb(240, 251, 244) 100.7%);
        }
        th a {
            color: goldenrod;
            text-decoration: none;
        }
        th a:hover {
            color: grey;
        }
        td
        {
            color: gold;
            background: radial-gradient(902px at 10% 20%, rgb(18, 50, 90) 0%, rgb(207, 199, 252) 100.2%);
        }
        .asc:after {
            content: "\25b2";
            margin-left: 5px;
        }
        .desc:after {
            content: "\25bc";
            margin-left: 5px;
        }
        .donate-btn {
            padding: 5px 10px;
            background: linear-gradient(69.8deg, rgb(25, 49, 108) 2.8%, rgb(1, 179, 201) 97.8%);
            color: goldenrod;
            font-weight: bolder;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        #name
        {
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-right: 10px;
            background-color: bisque;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>List of People Seeking Help</h1>
        <div class="search-container">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET">
                <label for="name">Search by Name:</label>
                <input type="text" id="name" name="name" placeholder="Enter name...">
                <label for="subject">Select Subject:</label>
                <select name="subject" id="subject">
                    <option value="">All</option>
                    <option value="Educational">Educational</option>
                    <option value="Financial">Financial</option>
                    <option value="FoodHunger">FoodHunger</option>
                    <option value="Medical">Medical</option>
                </select>
                <label for="sort">Sort By:</label>
                <select name="sort" id="sort">
                    <option value="name_asc">Name Ascending</option>
                    <option value="name_desc">Name Descending</option>
                    <option value="phone_asc">Phone Ascending</option>
                    <option value="phone_desc">Phone Descending</option>
                    <option value="amount_asc">Amount Ascending</option>
                    <option value="amount_desc">Amount Descending</option>
                    <option value="address_asc">Address Ascending</option>
                    <option value="address_desc">Address Descending</option>
                    <option value="subject_asc">Subject Ascending</option>
                    <option value="subject_desc">Subject Descending</option>
                    <option value="type_asc">Type Ascending</option>
                    <option value="type_desc">Type Descending</option>
                    <option value="uname_asc">Username Ascending</option>
                    <option value="uname_desc">Username Descending</option>
                    <option value="doh_asc">Date Ascending</option>
                    <option value="doh_desc">Date Descending</option>
                </select>
                <button type="submit">Search</button>
            </form>
        </div>

        <?php
// Your PHP code here
// Database connection
$user = $_SESSION['username'];
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sampledb";
$user = $_SESSION['username'];
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetching form data
$name = $_GET['name'];
$subject = $_GET['subject'];
$sort = $_GET['sort'];

// Constructing SQL query
$sql = "SELECT * FROM `record` WHERE `amount` > 0"; // Exclude persons with amount '0'

// Applying filters
$conditions = array();
if (!empty($name)) {
    $conditions[] = "`fname` LIKE '%$name%'";
}
if (!empty($subject)) {
    $conditions[] = "`type` = '$subject'";
}
if (!empty($conditions)) {
    $sql .= " AND " . implode(' AND ', $conditions);
}

// Sorting logic
switch ($sort) {
    case 'name_asc':
        $sql .= " ORDER BY `fname` ASC";
        break;
    case 'name_desc':
        $sql .= " ORDER BY `fname` DESC";
        break;
    case 'phone_asc':
        $sql .= " ORDER BY `phone` ASC";
        break;
    case 'phone_desc':
        $sql .= " ORDER BY `phone` DESC";
        break;
    case 'amount_asc':
        $sql .= " ORDER BY `amount` ASC";
        break;
    case 'amount_desc':
        $sql .= " ORDER BY `amount` DESC";
        break;
    case 'address_asc':
        $sql .= " ORDER BY `address` ASC";
        break;
    case 'address_desc':
        $sql .= " ORDER BY `address` DESC";
        break;
    case 'subject_asc':
        $sql .= " ORDER BY `subject` ASC";
        break;
    case 'subject_desc':
        $sql .= " ORDER BY `subject` DESC";
        break;
    case 'type_asc':
        $sql .= " ORDER BY `type` ASC";
        break;
    case 'type_desc':
        $sql .= " ORDER BY `type` DESC";
        break;
    case 'uname_asc':
        $sql .= " ORDER BY `uname` ASC";
        break;
    case 'uname_desc':
        $sql .= " ORDER BY `uname` DESC";
        break;
    case 'doh_asc':
        $sql .= " ORDER BY `doh` ASC";
        break;
    case 'doh_desc':
        $sql .= " ORDER BY `doh` DESC";
        break;
    default:
        // Default sorting
        $sql .= " ORDER BY `doh` DESC"; // Sort by date descending
        break;
}

// Executing SQL query
$result = $conn->query($sql);
// Displaying results
if ($result->num_rows > 0) {
    echo "<table><tr><th>Name<a href=\"$_SERVER[PHP_SELF]?sort=name_asc\"><span class=\"asc\"></span></a><a href=\"$_SERVER[PHP_SELF]?sort=name_desc\"> <span class=\"desc\"></span></a></th><th>Phone<a href=\"$_SERVER[PHP_SELF]?sort=phone_asc\"><span class=\"asc\"></span></a><a href=\"$_SERVER[PHP_SELF]?sort=phone_desc\"> <span class=\"desc\"></span></a></th><th>Amount Needed<a href=\"$_SERVER[PHP_SELF]?sort=amount_asc\"><span class=\"asc\"></span></a><a href=\"$_SERVER[PHP_SELF]?sort=amount_desc\"><span class=\"desc\"></span></a></th><th>Address<a href=\"$_SERVER[PHP_SELF]?sort=address_asc\"><span class=\"asc\"></span></a><a href=\"$_SERVER[PHP_SELF]?sort=address_desc\"><span class=\"desc\"></span></a></th><th>Subject<a href=\"$_SERVER[PHP_SELF]?sort=subject_asc\"><span class=\"asc\"></span></a><a href=\"$_SERVER[PHP_SELF]?sort=subject_desc\"><span class=\"desc\"></span></a></th><th>Type<a href=\"$_SERVER[PHP_SELF]?sort=type_asc\"><span class=\"asc\"></span></a><a href=\"$_SERVER[PHP_SELF]?sort=type_desc\"> <span class=\"desc\"></span></a></th><th>Raised User<a href=\"$_SERVER[PHP_SELF]?sort=uname_asc\"><span class=\"asc\"></span></a><a href=\"$_SERVER[PHP_SELF]?sort=uname_desc\"><span class=\"desc\"></span></a></th><th>Date<a href=\"$_SERVER[PHP_SELF]?sort=doh_asc\"><span class=\"asc\"></span></a><a href=\"$_SERVER[PHP_SELF]?sort=doh_desc\"><span class=\"desc\"></span></a></th><th>Action</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["fname"]."</td><td>".$row["phone"]."</td><td>".$row["amount"]."</td><td>".$row["address"]."</td><td>".$row["subject"]."</td><td>".$row["type"]."</td><td>".$row["uname"]."</td><td>".$row["doh"]."</td><td><form action=\"donate.php\" method=\"POST\"><input type=\"hidden\" name=\"name\" value=\"" . $row["fname"] . "\"><input type=\"hidden\" name=\"amount\" value=\"" . $row["amount"] . "\"><button type=\"submit\" class=\"donate-btn\">Donate</button></form></td></tr>";
    }
    echo "</table>";
} else {
    echo "No results found";
}

// Closing connection
$conn->close();
?>

    </div>
</body>
</html>





