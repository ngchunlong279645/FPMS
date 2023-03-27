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

if (isset($_POST['submit'])) {
    echo $sqldeleteproject = "UPDATE `tbl_projects` SET `std_name` = NULL WHERE std_name = '$name'";
	echo $sqldeletestd = "UPDATE `tbl_student` SET `client_name` = NULL ,`project_title`= NULL WHERE std_name = '$name'";
    try {
		$conn->exec($sqldeletestd);
        $conn->exec($sqldeleteproject);
            echo "<script>alert('Project deleted')</script>";
            echo "<script>window.location.replace('projectstatusDelete.php')</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Failed')</script>";
       echo "<script>window.location.replace('projectstatusDelete.php')</script>";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Final Project Management System</title>
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href = "../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


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

        table {
			border-collapse: collapse;
			width: 100%;
		}

		th, td {
			text-align: left;
			padding: 8px;
		}

		tr:nth-child(even){background-color: #f2f2f2}

		th {
			background-color: #4CAF50;
			color: white;
		}

		form {
			display: inline-block;
		}

		.delete-button {
			background-color: red;
			color: white;
			border: none;
			padding: 8px 16px;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			font-size: 14px;
			margin: 4px 2px;
			cursor: pointer;
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
        <a href="projectstatus.php"><i class="material-icons">data_usage</i></a>
        <a href="projectstatusAdd.php"><i class="material-icons">add_box</i></a>
        <a href="projectstatusDelete.php" class="active"><i class="material-icons">remove_circle</i></a>
    </div>
    <div class="main">
        <h2>Delete Projects</h2>
        <?php if (count($rows) > 0): ?>
            <table>
                <thead>
                <tr>
                    <th>Project ID</th>
                    <th>Project Title</th>
                    <th>Project Client</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <td><?php echo $row["project_id"]; ?></td>
                        <td><?php echo $row["project_title"]; ?></td>
                        <td><?php echo $row["project_client"]; ?></td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="project_id" value="<?php echo $row["project_id"]; ?>">
                                <button type="submit" name="submit" value="delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>You don't have any projects to delete. Please add a project first.</p>
<?php endif; ?>
</div>
</div>

</body>
</html>