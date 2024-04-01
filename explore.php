<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<meta name="description" content="STGP is a community-driven website for social travelers and backpackers to share interesting places, events, and activities for an authentic Prague experience.">
	<meta name="keywords" content="Prague, social travelers, backpackers, authentic Prague experience, events in Prague, local restaurants, Prague goulash, homebrew beer">
	<meta name="author" content="MSc student in informatic group 02">
	<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
	<link rel="canonical" href="https://ete52e.pef.czu.cz/zs2324/02/">
	<link rel="sitemap" type="application/xml" title="Sitemap" href="https://ete52e.pef.czu.cz/zs2324/02/">
	<link rel="stylesheet" href="css/style.css">
	<title>STGP-Prague Explore more</title>
</head>

<body>
	<div class="alert alert-info">
		<p>!!! This is just a students project for study purposes only !!!</p>
	</div>
	<br />
	</div>
	<nav class="nav-bar">
		<a href="index.html" class="navbar-brand">STGP-Prague</a>
		<div class="navbar-toggle" id="navbarToggle">&#9776;</div>
		<ul class="navbar-nav" id="navbarNav">
			<li><a href="index.html">Trending</a></li>
			<li><a href="explore.html">Explore</a></li>
			<li><a href="suggest.html">Suggest</a></li>
			<li><a href="resource.html">Usefull Resource</a></li>
			<li><a href="contact.html">Contact Us</a></li>
			<li><a href="about.html">About US</a></li>
		</ul>
	</nav>
	<div class="container" style="display: flex;">
		<div class="sidebar">
			<h2>Looking for</h2>
			<form id="checkbox-form">
				<label><input type="checkbox" name="types[]" value="all" onchange="fetchData()"> All</label>
				<label><input type="checkbox" name="types[]" value="cousine-beer" onchange="fetchData()"> Cuisine and Beer</label>
				<label><input type="checkbox" name="types[]" value="events" onchange="fetchData()"> Events</label>
				<label><input type="checkbox" name="types[]" value="activities" onchange="fetchData()"> Activities</label>
				<label><input type="checkbox" name="types[]" value="night-life" onchange="fetchData()"> Night Life</label>
			</form>
		</div>
		<div class="content-box-container">
			<h2>Explore the best out of Prague</h2>
			<div id="content-container" class="content-box-container">
				<?php

				$servername = "localhost";
				$database = "ete52e_2324zs_02";
				$username = "root";
				$password = "";

				$connection = mysqli_connect($servername, $username, $password, $database);
				if (!$connection) {
					die("Connection failed : " . mysqli_connect_error());
				}


				$sql = "SELECT * FROM suggestion WHERE approved =1";
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

			</div>

		</div>
	</div>

	<footer class="footer">
		<p>&copy; 2023 Your Website Name. All rights reserved.</p>
	</footer>

	<!-- jQuery library -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<script src="js/script.js"></script>
	<script>
		function fetchData() {
			//alert("dwkjdfsd")
			var form = document.getElementById("checkbox-form");
			var formData = new FormData(form);

			var xhr = new XMLHttpRequest();
			xhr.open("POST", "filter.php", true);
			xhr.onreadystatechange = function() {
				//alert(xhr.responseText)
				if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
					document.getElementById("content-container").innerHTML = xhr.responseText;
				}
			};
			xhr.send(formData);
		}
	</script>
</body>

</html>
