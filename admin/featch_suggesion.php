<?php
// Database connection setup (replace placeholders with actual values)
// Connect to your MySQL database
$servername = "localhost";
$database = "ete52e_2324zs_02";
$username = "root";
$password = "";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT suggestid, tittle, type, place, description, image,approved FROM suggestion";
$result = $conn->query($sql);

$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);

$conn->close();
?>
