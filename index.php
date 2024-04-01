<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="STGP is a community-driven website for social travelers and backpackers to share interesting places, events, and activities for an authentic Prague experience.">
	<meta name="keywords" content="Prague, social travelers, backpackers, authentic Prague experience, events in Prague, local restaurants, Prague goulash, homebrew beer">
	<meta name="author" content="MSc student in informatic group 02">
	<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
	<link rel="canonical" href="https://ete52e.pef.czu.cz/zs2324/02/">
	<link rel="sitemap" type="application/xml" title="Sitemap" href="https://ete52e.pef.czu.cz/zs2324/02/">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="css/style.css">
	<title>STGP-Prague</title>
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
	<main>
		<div id="myCarousel" class="carousel slide" data-ride="carousel">
			<!-- Indicators -->
			<ol class="carousel-indicators">
				<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
				<li data-target="#myCarousel" data-slide-to="1"></li>
				<li data-target="#myCarousel" data-slide-to="2"></li>
			</ol>

			<!-- Wrapper for slides -->
			<div class="carousel-inner">

				<div class="item active">
					<img src="images/charless.jpg" alt="Charles Bridge" style="width:100%;">
					<div class="carousel-caption">
						<h3>Charless Bride</h3>
						<p>Charles Bridge is a medieval stone arch bridge that crosses the Vltava river in Prague, Czech
							Republic. </p>
					</div>
				</div>

				<div class="item">
					<img src="images/prague-castle.jpg" alt="PRague Castle" style="width:100%;">
					<div class="carousel-caption">
						<h3>Prague Castle</h3>
						<p>Prague Castle is a castle complex in Prague 1 within Prague, Czech Republic, built in the 9th
							century.</p>
					</div>
				</div>

				<div class="item">
					<img src="images/st-vitus.jpg" alt="St. Vitus Cathedral" style="width:100%;">
					<div class="carousel-caption">
						<h3>St. Vitus Cathedral</h3>
						<p>The Metropolitan Cathedral of Saints Vitus, Wenceslaus and Adalbert is a Catholic
							metropolitan cathedral in Prague</p>
					</div>
				</div>

			</div>

			<!-- Left and right controls -->
			<a class="left carousel-control" href="#myCarousel" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a class="right carousel-control" href="#myCarousel" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>
		<hr />
		<section class="quick-meals-section container">
			<h2>Quick Meals,Cuisine and Drinks</h2>
			<div class="quick-meals-list">
				<?php
				$servername = "localhost";
				$database = "ete52e_2324zs_02";
				$username = "root";
				$password = "";

				$connection = mysqli_connect($servername, $username, $password, $database);
				if (!$connection) {
					die("Connection failed : " . mysqli_connect_error());
				}

				$sql = "SELECT * FROM suggestion WHERE type  in ('meals', 'cousine','beer') and approved =1";

				$result = mysqli_query($connection, $sql);

				if ($result) {
					while ($row = mysqli_fetch_assoc($result)) {
						echo '<div class="quick-meal">';
						echo '<img src="images/'.$row['type'] .'/'. $row['image'] . '" alt="' . $row['title'] . '">';
						echo '<div class="meal-details">';
						echo '<h3>' . $row['tittle'] . '</h3>';
						echo '<p><i class="description">Description :</i> ' . $row['description'] . '</p>';
						echo '<p class="rating">Rating: <span class="anonymous-user-rating">';
						// // Assuming rating is stored as a field in the database
						// for ($i = 0; $i < $row['rating']; $i++) {
						// 	echo '<i class="glyphicon glyphicon-star"></i>';
						// }
						// Assuming maximum rating is 5
						$emptyStars = 5;
						for ($i = 0; $i < $emptyStars; $i++) {
							echo '<i class="glyphicon glyphicon-star"></i>';
						}
						echo '</span></p>';
						echo '</div>';
						echo '</div>';
					}
				} else {
					// Handle error if the query fails
					echo "Error: " . mysqli_error($connection);
				}

				?>

			</div>
		</section>

		<section class="Event-section container">
			<h2>Events and Activities</h2>
			<div class="quick-meals-list">
				<?php

				$sql = "SELECT * FROM suggestion WHERE TYPE IN ('activities','events') and approved =1";

				$result = mysqli_query($connection, $sql);
				if ($result) {
					while ($row = mysqli_fetch_assoc($result)) {
						echo '<div class="quick-meal">';
						echo '<img src="images/' .$row['type'].'/'. $row['image'] . '" alt="' . $row['title'] . '">';
						echo '<div class="meal-details">';
						echo '<h3>' . $row['tittle'] . '</h3>';
						echo '<p><i class="description">Description :</i> ' . $row['description'] . '</p>';
						echo '<p class="rating">Rating: <span class="anonymous-user-rating">';
						$emptyStars = 5;
						for ($i = 0; $i < $emptyStars; $i++) {
							echo '<i class="glyphicon glyphicon-star"></i>';
						}
						echo '</span></p>';
						echo '</div>';
						echo '</div>';
					}
				} else {
					// Handle error if the query fails
					echo "Error: " . mysqli_error($connection);
				}
				mysqli_close($connection);
				?>

			</div>
		</section>

		<section class="group-members-section">
			<h2>Group Members</h2>
			<div class="group-members-list">
				<div class="group-member">
					<div class="member-info">
						<h3>Hailemariam Getabalew Amtate</h3>
						<p>Role: Developer</p>
					</div>
				</div>
				<div class="group-member">
					<div class="member-info">
						<h3>Kidan Admasu Wodaje</h3>
						<p>Role: Developer</p>
					</div>
				</div>
				<div class="group-member">
					<div class="member-info">
						<h3>Mengesha Robel Hayelom</h3>
						<p>Role: UI|UX Designer</p>
					</div>
				</div>
				<div class="group-member">
					<div class="member-info">
						<h3>Teklemariam, Ashenafi Muluneh</h3>
						<p>Role: UI Designer</p>
					</div>
				</div>
				<div class="group-member">
					<div class="member-info">
						<h3>Admasu Eyoel</h3>
						<p>Role: UI Designer</p>
					</div>
				</div>
			</div>
		</section>

	</main>
	<footer class="footer">
		<p>&copy; 2023 Your Website Name. All rights reserved.</p>
	</footer>

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<script src="js/script.js"></script>
</body>

</html>
