<?php

$servername = "localhost";
$database = "ete52e_2324zs_02";
$username = "root";
$password = "";

$connection = mysqli_connect($servername, $username, $password, $database);
if (!$connection) {
	die("Connection failed : " . mysqli_connect_error());
}
$selectedTypes = isset($_POST['types']) ? $_POST['types'] : array();

$sql = "SELECT * FROM suggestion";
if (!empty($selectedTypes) && in_array("all", $selectedTypes)) {
	// If "All" is selected, fetch all data
	$sql .= " WHERE 1 AND approved = 1";
} elseif (!empty($selectedTypes)) {
	// If specific types are selected, fetch based on those types
	$sql .= " WHERE approved = 1 AND type IN ('" . implode("','", $selectedTypes) . "')";
}

$result = mysqli_query($connection, $sql);
if ($result->num_rows > 0) {

	while ($row = $result->fetch_assoc()) {
		// Generate HTML content dynamically
		echo '<div class="content-box">';
		echo '<div class="content-profile">';
		echo '<div class="profile-img">';
		echo '<img src="images/' . $row['type'] . '/' . $row['image'] . '" alt="' . $row['title'] . '" />';
		echo '</div>';
		echo '</div>';
		echo '<div class="content-content">';
		echo '<div class="title-rating">';
		echo '<div class="title-location">';
		echo '<strong>' . $row['tittle'] . '</strong>';
		echo '<span>@' . $row['place'] . '</span>';
		echo '</div>';
		echo '<div class="reviews">';
		echo '<p class="rating">Rating: <span class="anonymous-user-rating">';
		for ($i = 0; $i < 5; $i++) {
			echo '<i class="glyphicon glyphicon-star"></i>';
		}
		echo $row['rating'] . '</span></p>';
		echo '</div>';
		echo '</div>';
		echo '<p>' . $row['description'] . '</p>';
		echo '<button class="btn btn-success">Read More ...</button>';
		echo '</div>';
		echo '</div>';
	}
} else {
	echo "0 results";
}
$connection->close();
?>
