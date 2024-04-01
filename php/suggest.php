<?php
$servername = "localhost";
$database = "ete52e_2324zs_02";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$title = $_POST['title'];
	$type = $_POST['type'];
	$place = $_POST['place'];
	$description = $_POST['description'];

	$image = $_FILES['image'];
	$imageName = $image['name'];
	$imagePath = '../images/' .$type.'/'. $imageName;


	// Validate if the uploaded file is an image
	$imageFileType = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));
	$allowedExtensions = array("jpg", "jpeg", "png", "gif");

	if (!in_array($imageFileType, $allowedExtensions)) {
		echo "Invalid file format. Please upload a valid image file.";
		exit;
	}

	// Save image to images folder
	if(!move_uploaded_file($image['tmp_name'], $imagePath))
	{
		die("invalid image path ". $type. " ". $imagePath);
	};
	//die($imagePath);

	// Insert data into the 'suggestion' table
	$sql = "INSERT INTO suggestion (suggestid,tittle, type, place, description, image,approved) VALUES (NUll,'$title', '$type', '$place', '$description', '$imageName',1)";

	if ($conn->query($sql) === TRUE) {
		echo "New record created successfully";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
}

// Close connection
$conn->close();
?>
