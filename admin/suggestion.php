<?php
session_start();
if (!isset($_SESSION['email'])) {

	header("Location: index.html");
	exit; // Ensure script execution stops after redirection
}
?>
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
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
	<title>STGP-Prague Suggest Others</title>
</head>

<body>
	<nav class="navbar navbar-light bg-light">
		<div class="container">
			<a class="navbar-brand">STGP-Prague</a>
			<div class="d-flex">
				<a class="btn btn-block" id="loggedInUser">
					<?php
					echo $_SESSION['email'];
					?>
				</a>
				<form method="post" action="logout.php">
					<button type="submit" class="btn btn-block" name="logout" id="logoutBtn">Logout</button>
				</form>
			</div>
	</nav>
	<br />
	<div class="container">
		<table id="dataTable" class="table table-striped table-bordered" style="width:100%;">
			<thead>
				<tr>
					<th>Suggest ID</th>
					<th>Title</th>
					<th>Type</th>
					<th>Place</th>
					<th>Description</th>
					<th>Image</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<!-- Data will be loaded here dynamically -->
			</tbody>
		</table>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
	<script src="script.js"></script>
	<script>
		$(document).ready(function() {
			var table = $('#dataTable').DataTable({
				"ajax": {
					"url": "featch_suggesion.php",
					"dataSrc": ""
				},
				"columns": [{
						"data": "suggestid"
					},
					{
						"data": "tittle"
					},
					{
						"data": "type"
					},
					{
						"data": "place"
					},
					{
						"data": "description"
					},
					{
						"data": "image"
					},
					{
						"data": "approved",
						"render": function(data, type, row) {
							var btnText = data === "1" ? 'Disapprove' : 'Approve';
							var btnClass = data === "1" ? 'btn-danger' : 'btn-success';
							return '<button class="btn ' + btnClass + ' approval-btn" data-id="' + row.suggestid + '">' + btnText + '</button>';
						}
					}
				]
			});
			$('#dataTable').on('click', '.approval-btn', function() {
				var suggestId = $(this).data('id');
				var currentStatus = $(this).text();
				var newStatus = currentStatus === 'Approve' ? 1 : 0;
				$.ajax({
					url: 'manage_suggesion.php',
					type: 'POST',
					data: {
						suggestid: suggestId,
						status: newStatus
					},
					success: function(response) {
						console.log(response);
						table.ajax.reload(); // Reload the DataTable after status update
					},
					error: function(xhr, status, error) {
						console.log(error);
					}
				});
			});

			$('#dataTable').on('click', '.edit-btn', function() {
				var suggestId = $(this).data('id');
				// Implement your edit logic here using the suggestId
				console.log('Edit button clicked for Suggest ID: ' + suggestId);
			});

			$('#dataTable').on('click', '.delete-btn', function() {
				var suggestId = $(this).data('id');
				// Implement your delete logic here using the suggestId
				console.log('Delete button clicked for Suggest ID: ' + suggestId);
			});
		});
		document.getElementById('logoutBtn').addEventListener('click', function(e) {
			e.preventDefault(); // Prevent the default form submission
			Swal.fire({
				title: 'Logout Confirmation',
				text: 'Are you sure you want to logout?',
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, logout'
			}).then((result) => {
				if (result.isConfirmed) {
					// Submit the form to trigger session destruction
					document.querySelector('form').submit();
				}
			});
		});
	</script>
</body>

</html>
