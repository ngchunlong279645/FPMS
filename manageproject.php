<?php
session_start();
if (!isset($_SESSION['session_id'])) {
    echo "<script>alert('Session not available. Please login');</script>";
    echo "<script> window.location.replace('login.php')</script>";
}
include_once("dbconnect.php");

if (isset($_GET['submit'])) {
    $operation = $_GET['submit'];
    if ($operation == 'delete') {
        $project_id = $_GET['pid'];
        $sqldeleteproject = "DELETE FROM `tbl_projects` WHERE project_id = '$project_id'";
        $conn->exec($sqldeleteproject);
        echo "<script>alert('Project deleted')</script>";
        echo "<script>window.location.replace('manageproject.php')</script>";
    }
    if ($operation == 'search') {
        $search = $_GET['search'];
        $sqlprojects = "SELECT * FROM tbl_projects WHERE project_title LIKE '%$search%'";
    }
} else {
    $sqlprojects = "SELECT * FROM tbl_projects";
}

$results_per_page = 5;
if (isset($_GET['pageno'])) {
     $pageno = (int)$_GET['pageno'];
     $page_first_result = ($pageno - 1) * $results_per_page;
} else {
     $pageno = 1;
     $page_first_result = 0;
}

$stmt = $conn->prepare($sqlprojects);
$stmt->execute();
$number_of_result = $stmt->rowCount();
$number_of_page = ceil($number_of_result / $results_per_page);
$sqlprojects = $sqlprojects. " LIMIT $page_first_result , $results_per_page";
$stmt = $conn->prepare($sqlprojects);
$stmt->execute();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$rows = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="../js/menu.js" defer></script>

    <title>Welcome to Final Project Management System</title>
</head>

<body>
    <div class="w3-grey">
    <a href="admin.php" class="w3-bar-item w3-button w3-right">Back</a>
        <div class="w3-container">
            <h3>Manage Project</h3>
        </div>
    </div>
    <div class="w3-bar w3-grey">
        <a href="addproject.php" class="w3-bar-item w3-button w3-right">Add Project</a>
    </div>
    <div class="w3-card w3-container w3-padding w3-margin w3-round">
        <h3> Search</h3>
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
         <tr><th style='width:5%'>No</th><th style='width:5%'>Project ID</th><th style='width:10%'>Project Title</th><th style='width:20%'>Requirement</th>
          <th style='width:20%'>Description</th><th style='width:10%'>Supervisor</th> <th style='width:10%'>Date of Start</th>
          <th style='width:10%'>Date of End</th><th style='width:5%'>Duration (days)</th><th style='width:5%'>Operations</th></tr>";
        foreach ($rows as $projects) {
            $i++;
            $pid = $projects['project_id'];
            $ptitle = $projects['project_title'];
            $prequirement = $projects['project_requirement'];
            $psupervisor = $projects['project_supervisor'];
            $pdescription = $projects['project_description'];
            $pdos = $projects['project_start'];
            $pdoe = $projects['project_end'];
            $pdoe_timestamp = strtotime($pdoe);
            $pdos_timestamp = strtotime($pdos);
            $duration = ceil(($pdoe_timestamp - $pdos_timestamp) / (60 * 60 * 24));
            echo "<tr><td>$i</td><td>$pid</td><td> $ptitle</td><td>$prequirement</td><td>$pdescription</td><td>$psupervisor</td><td>$pdos</td><td>$pdoe</td><td>$duration</td>
            <td><button class='btn'><a href='manageproject.php?submit=delete&pid=$pid' class='fa fa-trash' onclick=\"return confirm('Are you sure?')\"></a></button>
            <button class='btn'><a href='updateproject.php?submit=details&pid=$pid' class='fa fa-edit'></a></button></td></tr>";
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
            echo '<a href = "manageproject.php?pageno=' . $page . '" style=
            "text-decoration: none">&nbsp&nbsp' . $page . ' </a>';
        }
        echo " ( " . $pageno . " )";
        echo "</center>";
        echo "</div>";
    ?>
    <br>

<footer class="w3-footer w3-center w3-bottom w3-grey">FPMS</footer>

</body>

</html>