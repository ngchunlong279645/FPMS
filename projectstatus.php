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
			flex-grow: 1;
			padding: 24px;
		}
	</style>
</head>
<body>
	<header>
	<a href="student.php"><button class="back-button"><i class="material-icons">arrow_back</i></button></a>
	
		<h1>Project Status</h1>
	</header>
	<div class="container">
		<div class="sidebar">
		<a href="projectstatus.php" ><i class="material-icons">data_usage</i></a>
			<a href="projectstatusAdd.php" class="active"><i class="material-icons">add_box</i></a>
			<a href="projectstatusDelete.php"><i class="material-icons">remove_circle</i></a>
		</div>
		<div class="main">
			<!-- main content goes here -->
		</div>
	</div>
</body>
</html>
