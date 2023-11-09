<?php
// Retrieve the user's WAN IP from the form
$wan_ip = $_POST['wan_ip'];

// Check if the WAN IP is empty
if (empty($wan_ip)) {
    echo "<div class='result'>";
    echo "You have not entered any IP.";
    echo "</div>";
    exit; // Stop further execution
}

// Connect to your database (replace with your own credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "wantele";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the SQL statement to retrieve the subnet mask and default gateway associated with the WAN IP
$sql = "SELECT subnet_mask, default_gateway FROM wan_ip WHERE wan_ip = ?";

// Prepare the statement and bind the parameter
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $wan_ip);

// Execute the query
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Display the subnet mask and default gateway if found, or an error message if not found
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $subnet_mask = $row['subnet_mask'];
    $default_gateway = $row['default_gateway'];
    
    // Add JavaScript code to populate the form fields with the result
    echo "<script>";
    echo "document.getElementById('subnetmask').value = '" . $subnet_mask . "';";
    echo "document.getElementById('defaultgateway').value = '" . $default_gateway . "';";
    echo "</script>";

    echo "<div class='result'>";
    echo "Subnet Mask: " . $subnet_mask . "<br>";
    echo "Default Gateway: " . $default_gateway;
    echo "</div>";
} else {
    echo "<div class='result'>";
    echo "No subnet mask and default gateway found for WAN IP " . $wan_ip;
    echo "</div>";
}

// Close the statement and the database connection
$stmt->close();
$conn->close();
?>