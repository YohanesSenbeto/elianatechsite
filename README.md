<html>
<head>
	<title>WAN IP Subnet Mask and Default Gateway Finder</title>
	<style>
      /* CSS code goes here */
      body {
        background-color: #255255255;
      }
      h1 {
        color: black;
      }
#my-element {
        padding-bottom: 20px;
        padding-left: 10px;
      }
      div {
  
        border-width: 2px;
      }
       button {
        background-color: green;
        color: white;
        border: none;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 2px 2px;
        cursor: pointer;
      }
    </style>
</head>
<body>
<h1>Enter your WAN IP address</h1>
<form method="post" action="WANIP.php">
  <label for="wan_ip">Enter WAN IP:</label>
  <input type="text" id="wan_ip" name="wan_ip"><br><br>
  <button type="submit">Find Subnet Mask and Default Gateway</button><br>
</form>
<br>
<br>
<br>
<br>
<br>
<img src="https://th.bing.com/th/id/R.23d6ec354620f34e861e9774a054ad73?rik=406vii0gRRehmA&pid=ImgRaw&r=0" alt="Animated GIF">
<br>
	<div id="my-element">
	
<?php
// Retrieve the user's WAN IP from the form
$wan_ip = $_POST['wan_ip'];

// Connect to your database (replace with your own credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "wantele";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query the database to retrieve the subnet mask and default gateway associated with the WAN IP
$sql = "SELECT subnet_mask, default_gateway FROM wan_ip WHERE wan_ip='$wan_ip'";
$result = $conn->query($sql);

// Display the subnet mask and default gateway if found, or an error message if not found
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $subnet_mask = $row['subnet_mask'];
    $default_gateway = $row['default_gateway'];
    echo "Subnet Mask: " . $subnet_mask . "<br>";
    echo "Default Gateway: " . $default_gateway;
} else {
    echo "No subnet mask and default gateway found for WAN IP " . $wan_ip;
}

// Close the database connection
$conn->close();
?>
