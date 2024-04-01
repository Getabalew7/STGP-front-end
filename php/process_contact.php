<?php
// process_form.php

// Handle the form data sent via POST
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$phone_number = $_POST['phone_number'];
$activity = $_POST['activity'];
$message = $_POST['message'];

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

// Prepare and execute SQL query to insert form data into the database
$sql = "INSERT INTO contactus (contactid, fname, lname, email, phone_number, activity, message)
        VALUES (NULL,'$fname', '$lname', '$email', '$phone_number', '$activity', '$message')";

if ($conn->query($sql) === TRUE) {
	echo "We have successfully recived your Message";
} else {
	echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
