<?php
//create connection to the database


$servername = "localhost";
$database = "ete52e_2324zs_02";
$username = "root";
$password = "";

$connection =  new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
	die("Connection failed :" . $connection->error);
}

$suggestID  = $_POST['suggestid'];
$newstatus = $_POST['status'];
$sql = "update suggestion set approved = $newstatus where suggestid = $suggestID";
if ($connection->query($sql) === TRUE) {
	echo "Suggestion has been successfully";
} else {
	echo "Error while updating suggestion" . $connection->error;
}
$connection->close();
?>
