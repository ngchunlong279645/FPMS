<?php
session_start();
$name = $_SESSION["name"];
if (!isset($_SESSION['session_id'])) {
    echo "<script>alert('Session not available. Please login');</script>";
    echo "<script> window.location.replace('login.php')</script>";
}

include_once("dbconnect.php");

$sqlprojects = "SELECT * FROM tbl_projects WHERE std_name = '$name'";
$stmt = $conn->prepare($sqlprojects);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
	<title>Final Project Management System</title>
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

	<style>
		body {
			margin: 0;
			padding: 0;
			font-family: 'Roboto', sans-serif;
		}

		header {
			display: flex;
			align-items: center;
			background-color: #263238;
			color: #fff;
			height: 80px;
			padding: 0 16px;
			box-shadow: 0 2px 4px rgba(0,0,0,.24);
		}

		h1 {
			margin: 30px;
			font-size: 30px;
			font-weight: 500;
			flex-grow: 1;
		}

		.back-button {
			background-color: transparent;
			border: none;
			color: #fff;
			font-size: 24px;
			cursor: pointer;
		}

		.container {
			display: flex;
			flex-direction: row;
			height: 89vh;
		}

		.sidebar {
			display: flex;
			flex-direction: column;
			align-items: center;
			background-color: #ECEFF1;
			color: #546E7A;
			width: 80px;
			padding-top: 24px;
			box-shadow: 2px 0 4px rgba(0,0,0,.24);
		}

		.sidebar a {
			text-decoration: none;
			color: inherit;
			padding: 16px 0;
			display: flex;
			align-items: center;
			justify-content: center;
			flex-grow: 1;
			width: 100%;
			transition: background-color .3s;
		}

		.sidebar a:hover {
			background-color: #CFD8DC;
		}

		.sidebar a.active {
			background-color: #CFD8DC;
		}

		.main {
		display: flex;
		flex-direction: column;
		align-items: center;
		margin-top: 50px;
	}

	.project-info {
		border-collapse: collapse;
		width: 100%;
		max-width: 1200px;
		margin: 50px ;
	}

	.project-info th {
		background-color: #f2f2f2;
		color: #666;
		font-size: 30px;
		font-weight: bold;
		padding: 20px;
		text-align: center;
	}

	.project-info td {
		font-size: 18px;
		padding: 10px 20px;
		border-bottom: 1px solid #ddd;
		
	}

	.project-info tr:hover {
		background-color: #f2f2f2;
	}

	.project-info .title {
		font-weight: bold;
		color: #333;
		
	}

	.project-info td:first-child {
		width: 150px;
	}

	.project-info td:last-child {
		text-align: left;
		text-align: justify;
	}

	</style>
</head>
<body>
	<header>
	<a href="student.php"><button class="back-button "><i class="material-icons ">arrow_back</i></button></a>
	
		<h1>Project Status</h1>
	</header>
	<div class="container">
		<div class="sidebar">
		<a href="projectstatus.php"  class="active" ><i class="material-icons">data_usage</i></a>
			<a href="projectstatusAdd.php" ><i class="material-icons">add_box</i></a>
			<a href="projectstatusDelete.php"><i class="material-icons">remove_circle</i></a>
		</div>
		<div class="main">
	<?php if (count($rows) > 0): ?>
		<table class="project-info">
			<tr>
				<th colspan="2">Project Info</th>
			</tr>
			<?php foreach ($rows as $row): ?>
				<tr>
					<td class="title">Title</td>
					<td><?php echo $row["project_title"]; ?></td>
				</tr>
				<tr>
					<td class="title">Description</td>
					<td><?php echo $row["project_description"]; ?></td>
				</tr>
				<tr>
					<td class="title">Requirements</td>
					<td><?php echo $row["project_requirement"]; ?></td>
				</tr>
				<tr>
					<td class="title">Start Date</td>
					<td><?php echo $row["project_start"]; ?></td>
				</tr>
				<tr>
					<td class="title">End Date</td>
					<td><?php echo $row["project_end"]; ?></td>
				</tr>
				<tr>
					<td class="title">Client</td>
					<td><?php 
					$client_name = $row["project_client"];
					$sqlgetuid = "SELECT `user_id` FROM `tbl_users` WHERE `username` = '$client_name'";
					$stmt = $conn->prepare($sqlgetuid);
					$stmt->execute();
					$row = $stmt->fetch(PDO::FETCH_ASSOC);
					$uid = $row['user_id'];

					echo "<a href='userprofile.php?id={$uid}'>" . $client_name . "</a>";
					?></td>
				</tr>
			<?php endforeach; ?>
		</table>
	<?php else: ?>
		<p>You don't have any projects yet. Please add a project first.</p>
	<?php endif; ?>
</div>



</body>
</html>
