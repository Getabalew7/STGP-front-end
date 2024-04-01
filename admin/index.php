<?php
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

$email = "test@test.com";
$password = "password";
$role = 1; // Assuming a default role of 1 for new users

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
die(password_verify($password, $hashed_password));
// Prepare and execute the SQL statement to insert email, hashed password, and role
$stmt = $conn->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, ?)");

$stmt->bind_param("ssi", $email, $hashed_password, $role);
if ($stmt->execute()) {
	echo 'User registered successfully';
} else {
	echo 'Error registering user';
}
echo "what happe";
$stmt->close();
mysqli_close($conn);

?>
