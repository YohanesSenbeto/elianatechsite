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
