<?php

// Define the database connection parameters
$host = "localhost";
$user = "root";
$password = "";
$dbname = "ete52e_2324zs_02";


// Create a new database connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check for errors
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

// Define the API endpoints
$endpoints = array(
	"contacts" => array(
		"GET" => "get_contacts",
		"POST" => "add_contact",
		"PUT" => "update_contact",
		"DELETE" => "delete_contact"
	)
);

// Define the request method and endpoint
$method = $_SERVER["REQUEST_METHOD"];
$endpoint = $_GET["endpoint"] ?? "";

// Check if the endpoint is valid
if (!isset($endpoints[$endpoint])) {
	http_response_code(404);
	echo json_encode(array("error" => "Endpoint not found"));
	exit();
}

// Call the appropriate function based on the request method
$function = $endpoints[$endpoint][$method];
if (function_exists($function)) {
	$function();
} else {
	http_response_code(405);
	echo json_encode(array("error" => "Method not allowed"));
}

// Define the functions for each endpoint
function get_contacts()
{
	global $conn;
	$query = "SELECT * FROM contactus";
	$result = $conn->query($query);
	$contacts = array();
	while ($row = $result->fetch_assoc()) {
		$contacts[] = $row;
	}
	echo json_encode($contacts);
}

function add_contact()
{
	$data = json_decode(file_get_contents("php://input"), true);
	global $conn;
	$fname = $data["fname"];
	$lname = $data["lname"];
	$email = $data["email"];
	$phone_number = $data["phone_number"];
	$activity = $data["activity"];
	$message = $data["message"];
	$query = "INSERT INTO contactus (fname, lname, email, phone_number, activity, message) VALUES ('$fname', '$lname', '$email', '$phone_number', '$activity', '$message')";
	$conn->query($query);
	echo json_encode(array("success" => "Contact added". "fname = ".$data['fname']. "\nquery = ".$query));
}
function update_contact()
{
	global $conn;
	$data = json_decode(file_get_contents("php://input"), true);
	$contactid = $data["contactid"];
	$fname = $data["fname"];
	$lname = $data["lname"];
	$email = $data["email"];
	$phone_number = $data["phone_number"];
	$activity = $data["activity"];
	$message = $data["message"];
	$query = "UPDATE contactus SET fname='$fname', lname='$lname', email='$email', phone_number='$phone_number', activity='$activity', message='$message' WHERE contactid=$contactid";
	$conn->query($query);
	echo json_encode(array("success" => "Contact updated"));
}

function delete_contact()
{
	global $conn;
	$contactid = $_GET["contactid"];
	$query = "DELETE FROM contactus WHERE contactid=$contactid";
	$conn->query($query);
	echo json_encode(array("success" => "Contact deleted"));
}
