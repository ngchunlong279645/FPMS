<?php
session_start();
$name = $_SESSION["name"];
if (!isset($_SESSION['session_id'])) {
    echo "<script>alert('Session not available. Please login');</script>";
    echo "<script> window.location.replace('login.php')</script>";
}

include_once("dbconnect.php");

// Check if the user already has a project assigned to them
$sqlcheckproject = "SELECT * FROM tbl_projects WHERE std_name = '$name'";
$select_stmt = $conn->prepare($sqlcheckproject);
$select_stmt->execute();
$rowcount = $select_stmt->rowCount();

if ($rowcount > 0) {
    // If the user already has a project assigned, show an error message and do not allow them to add another project
    echo "<script>alert('You have already been assigned a project');</script>";
    echo "<script>window.location.replace('projectstatus.php')</script>";
} else {
    if (isset($_GET['submit'])) {
        $operation = $_GET['submit'];
        if ($operation == 'add') {
            $project_id = $_GET['pid'];
            $sqlprojects = "SELECT * FROM tbl_projects WHERE project_id = '$project_id'";
            $select_stmt = $conn->prepare($sqlprojects);
            $select_stmt->execute();
            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
            $project_title = $row["project_title"];
            $client_name = $row["project_client"];

            $sqladdproject = "UPDATE `tbl_projects` SET `std_name`='$name' WHERE project_id = '$project_id'";
            $conn->exec($sqladdproject);

            // Add the new query here
            $sqlupdateuser = "UPDATE `tbl_student` SET  `client_name`='$client_name',`project_title`='$project_title' WHERE `std_name`='$name'";
            $conn->exec($sqlupdateuser);

            echo "<script>alert('Project added')</script>";
            echo "<script>window.location.replace('projectstatus.php')</script>";
        }
        if ($operation == 'search') {
            $search = $_GET['search'];
            $option = $_GET['option'];
            if ($option == "Select") {
                $sqlprojects = "SELECT * FROM tbl_projects WHERE project_title LIKE '%$search%'";
            }
        } else {
            $sqlprojects = "SELECT * FROM tbl_projects";
        }
    }

    $results_per_page = 5;
    if (isset($_GET['pageno'])) {
        $pageno = (int)$_GET['pageno'];
        $page_first_result = ($pageno - 1) * $results_per_page;
    } else {
        $pageno = 1;
        $page_first_result = 0;
    }

    $sqlprojects = "SELECT * FROM tbl_projects WHERE std_name = ''";
    $stmt = $conn->prepare($sqlprojects);
    $stmt->execute();
    $number_of_result = $stmt->rowCount();
    $number_of_page = ceil($number_of_result / $results_per_page);
    $sqlprojects = $sqlprojects . " LIMIT $page_first_result , $results_per_page";
    $stmt = $conn->prepare($sqlprojects);
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $rows = $stmt->fetchAll();
}

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Final Project Management System</title>
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

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
			width: 110px;
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
        <div class="w3-card w3-container w3-padding w3-margin w3-round">
        <form>
            <div class="w3-row">
                <div class="w3-threequarter" style="padding-right:4px">
                    <p>
                        <input class="w3-input w3-block w3-round w3-border" type="search" name="search" placeholder="Enter search term" />
                    </p>
                </div>
                <div class="w3-rest" style="padding-right:4px">
                    <p>
                         <button class="w3-button w3-grey w3-round w3-right" type="submit" name="submit" value="search">search</button>
                    </p>  
                </div>
            </div>
            
        </form>

    </div>
        <div class="w3-margin w3-border" style="overflow-x:auto ;">
        <?php
        $i = 0;
        echo "<table class='w3-table w3-striped w3-bordered' style='width:100%'>
         <tr><th style='width:5%'>No</th><th style='width:5%'>Project ID</th><th style='width:15%'>Project Title</th>
          <th style='width:20%'>Description</th><th style='width:10%'>Client</th> <th style='width:10%'>Date of Start</th>
          <th style='width:10%'>Date of End</th><th style='width:5%'>Duration (days)</th><th style='width:5%'>Operations</th></tr>";
        foreach ($rows as $projects) {
            $i++;
            $pid = $projects['project_id'];
            $ptitle = $projects['project_title'];
            $pclient = $projects['project_client'];
            $pdescription = $projects['project_description'];
            $pdos = $projects['project_start'];
            $pdoe = $projects['project_end'];
            $pdoe_timestamp = strtotime($pdoe);
            $pdos_timestamp = strtotime($pdos);
            $duration = ceil(($pdoe_timestamp - $pdos_timestamp) / (60 * 60 * 24));
            echo "<tr><td>$i</td><td>$pid</td><td> $ptitle</td><td>$pdescription</td><td>$pclient</td><td>$pdos</td><td>$pdoe</td><td>$duration</td>
            <td><button class='btn'><a href='projectstatusAdd.php?submit=add&pid=$pid' class='fa fa-plus'  onclick=\"return confirm('Are you sure?')\"></a></button></td></tr>";
        }
        echo "</table>";
        ?>
    </div>
    <br>
    <?php
        $num = 1;
        if ($pageno == 1) {
            $num = 1;
        } else if ($pageno == 2) {
            $num = ($num) + 10;
        } else {
            $num = $pageno * 10 - 9;
        }
        echo "<div class='w3-container w3-row'>";
        echo "<center>";
        for ($page = 1; $page <= $number_of_page; $page++) {
            echo '<a href = "projectstatusAdd.php?pageno=' . $page . '" style=
            "text-decoration: none">&nbsp&nbsp' . $page . ' </a>';
        }
        echo " ( " . $pageno . " )";
        echo "</center>";
        echo "</div>";
    ?>
    <br>
		</div>
	</div>
</body>
</html>
