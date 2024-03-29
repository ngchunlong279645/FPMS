<?php
session_start();
$name = $_SESSION["name"];

include_once("dbconnect.php");
$sql = "SELECT * FROM tbl_users WHERE username = '$name '";
  $select_stmt = $conn->prepare($sql);
  $select_stmt->execute();
  $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
  $user_id = $row["user_id"];

if (!isset($_SESSION['session_id'])) {
    echo "<script>alert('Session not available. Please login');</script>";
    echo "<script> window.location.replace('login.php')</script>";
}

if (substr($user_id, 0, 1) == "C") {
    $sqlstd = "SELECT * FROM `tbl_student` WHERE `client_name` = '$name'";
} else if (substr($user_id, 0, 1) == "L") {
    $sqlstd = "SELECT * FROM `tbl_student` WHERE `lecturer_name` = '$name'";
} else {
    $sqlstd = "SELECT * FROM `tbl_student`";
}



if (isset($_POST['submit'])) {
    include_once("dbconnect.php");
    $matric = $_POST['matric'];
   
    try {
        // Retrieve student name using matric number
        $sqlgetname = "SELECT `std_name` FROM `tbl_student` WHERE `std_matric` = '$matric'";
        $stmt = $conn->prepare($sqlgetname);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $std_name = $row['std_name'];
        
        // Check if user already exists in tbl_student
        $sqlcheckuser = "SELECT * FROM `tbl_student` WHERE `std_matric` = '$matric'";
        $stmt = $conn->prepare($sqlcheckuser);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // If user exists, update lecturer_name or client_name based on user_id
        if ($row) {
            if (substr($user_id , 0, 1) == "C") {
                $project_id = $_POST['project_id'];
                $sqlproject = "SELECT `project_title`, `project_client` FROM `tbl_projects` WHERE `project_id` = '$project_id'";
                $stmt = $conn->prepare($sqlproject);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $project_title = $row['project_title'];
                $project_client = $row['project_client'];
        
                // Check if project_title already exists in tbl_student
                $sqlcheckproject = "SELECT * FROM `tbl_student` WHERE `project_title` = '$project_title'";
                $stmt = $conn->prepare($sqlcheckproject);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($row) {
                    echo "<script>alert('Project title already exists.')</script>";
                    echo "<script>window.location.replace('managestudent.php')</script>";
                    exit;
                }

                // Check if the project client matches the name in the $name variable
                if ($project_client != $name) {
                    echo "<script>alert('You are not authorized to add this project.')</script>";
                    echo "<script>window.location.replace('managestudent.php')</script>";
                    exit;
                }
        
                // Check if std_name already exists in tbl_projects
                $sqlcheckname = "SELECT * FROM `tbl_projects` WHERE `std_name` = '$std_name'";
                $stmt = $conn->prepare($sqlcheckname);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($row) {
                    echo "<script>alert('Student already assigned to a project.')</script>";
                    echo "<script>window.location.replace('managestudent.php')</script>";
                    exit;
                }
        
                $sqlupdateuser = "UPDATE `tbl_student` SET `client_name`='$name', `project_title`='$project_title' WHERE `std_matric`='$matric'";
                $sqlupdateproject = "UPDATE `tbl_projects` SET `std_name`='$std_name' WHERE `project_id`='$project_id'";
                $stmt = $conn->prepare($sqlupdateproject);
                $stmt->execute();
        
            } else if (substr($user_id , 0, 1) == "L") {
                $sqlcheckuser = "SELECT * FROM `tbl_student` WHERE `std_matric` = '$matric'";
                $stmt = $conn->prepare($sqlcheckuser);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // If user exists
                if ($row) {
                    // Check if lecturer_name field is empty
                    if (empty($row['lecturer_name'])) {
                        // If field is empty, update lecturer_name
                        $sqlupdateuser = "UPDATE `tbl_student` SET `lecturer_name`='$name' WHERE `std_matric`='$matric'";
                        $stmt = $conn->prepare($sqlupdateuser);
                        $stmt->execute();
                        
                        echo "<script>alert('Student added successfully.')</script>";
                        echo "<script>window.location.replace('managestudent.php')</script>";
                    } else {
                        // If field is not empty, display error message
                        echo "<script>alert('Cannot add this student. Other lecturer already exists.')</script>";
                        echo "<script>window.location.replace('managestudent.php')</script>";
                    }
                } else {
                    echo "<script>alert('No student found.')</script>";
                    echo "<script>window.location.replace('managestudent.php')</script>";
                }
            }
        } else {
            echo "<script>alert('No student found.')</script>";
            echo "<script>window.location.replace('managestudent.php')</script>";
        }
         // Execute the update query
           
            $stmt = $conn->prepare($sqlupdateuser);
            $stmt->execute();
            
            echo "<script>alert('Student added successfully.')</script>";
            echo "<script>window.location.replace('managestudent.php')</script>";
        } catch (PDOException $e) {
            echo "<script>alert('Failed to add student information.')</script>";
            echo "<script>window.location.replace('managestudent.php')</script>";
        }
    }


    if (isset($_GET['submit'])) {
        $operation = $_GET['submit'];
        if ($operation == 'delete') {
            $matric = $_GET['matric'];
            $sqlgetname = "SELECT `std_name` FROM `tbl_student` WHERE `std_matric` = '$matric'";
            $stmt = $conn->prepare($sqlgetname);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $std_name = $row['std_name'];

            if (substr($user_id, 0, 1) == "C") {
                $sqldeleteproject = "UPDATE `tbl_projects` SET `std_name` = NULL WHERE `std_name` = '$std_name'";
                $conn->exec($sqldeleteproject);
                $sqldeleteStd = "UPDATE `tbl_student` SET `client_name` = NULL ,`project_title`= NULL WHERE `std_matric` = '$matric'";
                
            } else if (substr($user_id, 0, 1) == "L") {
                $sqldeleteStd = "UPDATE `tbl_student` SET `lecturer_name` = NULL WHERE `std_matric` = '$matric'";
            } else {
                $sqldeleteStd = "DELETE FROM `tbl_student` WHERE `std_matric` = '$matric'";
            }
            $conn->exec($sqldeleteStd);
           echo "<script>alert('Student deleted')</script>";
           echo "<script>window.location.replace('managestudent.php')</script>";
        }
        if ($operation == 'search') {
            $search = $_GET['search'];
            if (substr($user_id, 0, 1) == "C") {
                $sqlstd = "SELECT * FROM tbl_student WHERE std_name LIKE '%$search%' AND client_name ='$name'";
            }else if (substr($user_id, 0, 1) == "L") {
                $sqlstd = "SELECT * FROM tbl_student WHERE std_name LIKE '%$search%' AND lecturer_name ='$name'";
            }
           
        }
    }

    
    
    

$results_per_page = 20;
if (isset($_GET['pageno'])) {
     $pageno = (int)$_GET['pageno'];
    $page_first_result = ($pageno - 1) * $results_per_page;
} else {
     $pageno = 1;
    $page_first_result = 0;
}


$stmt = $conn->prepare($sqlstd);
$stmt->execute();
$number_of_result = $stmt->rowCount();
$number_of_page = ceil($number_of_result / $results_per_page);
$sqlstd = $sqlstd. " LIMIT $page_first_result , $results_per_page";
$stmt = $conn->prepare($sqlstd);
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

<style>
       .add-student-btn {
      background-color: green;
      color: white;
      padding: 10px 20px;
      border-radius: 5px;
      text-decoration: none;
      cursor: pointer;
    }

    .popup-page {
      display: none;
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 1;
    }

    .popup-page-content {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background-color: white;
      padding: 20px;
      border-radius: 5px;
    }

    .close-popup-page {
      position: absolute;
      top: 10px;
      right: 10px;
      font-size: 18px;
      cursor: pointer;
    }

    .left-align-form {
        text-align: left;
    }
    .left-align-form input[type="submit"] {
        float: right;
    }

    </style>

<body>
    <div class="w3-grey">
    <a href="<?php 
    if(substr($user_id, 0, 1) == "L") { 
        echo 'lecturer.php'; 
    } else {
      echo 'client.php'; 
    } 
?>" class="w3-bar-item w3-button w3-right">Back</a>
        <div class="w3-container">
            <h3>Manage Student</h3>
        </div>
    </div>
    <div class="w3-bar w3-grey">  
        <a class="add-student-btn w3-bar-item w3-button w3-right" >Add Student</a>
    </div>
    <div class="w3-card w3-container w3-padding w3-margin w3-round">
        <h3>Student Search</h3>
        <form>
            <div class="w3-row">
                <div class="w3-half" style="padding-right:4px">
                    <p><input class="w3-input w3-block w3-round w3-border" type="search" name="search" placeholder="Enter search term" /></p>
                </div>
            </div>
            <button class="w3-button w3-grey w3-round w3-right" type="submit" name="submit" value="search">search</button>
        </form>

    </div>
    <div class="w3-margin w3-border" style="overflow-x:auto;">
        <?php
        $i = 0;
        echo "<table class='w3-table w3-striped w3-bordered' style='width:100%'>
         <tr><th style='width:5%'>No</th><th style='width:10%'>Matric No.</th><th style='width:20%'>Student Name</th><th style='width:30%'>Project Title</th>";
            if(substr($user_id, 0, 1) == "C") { 
                echo "<th style='width:30%'>Lecturer Name</th>";
            } else {
                echo "<th style='width:30%'>Client Name</th>";
            }
            echo "<th style='width:5%'>Operations</th></tr>";

        foreach ($rows as $student) {
            $i++;
            $std_matric = $student['std_matric'];
            $std_name = "<a href='studentprofile.php?id={$student['std_matric']}'>" . $student['std_name'] . "</a>";
            $project_title = $student['project_title'];
            
            if(substr($user_id, 0, 1) == "L") {
                // if user_id starts with L, show the client name
                $client_name = $student['client_name'];
                echo "<tr><td>$i</td><td>$std_matric</td><td>$std_name</td><td>$project_title</td><td>$client_name</td>
                <td><button class='btn'><a href='managestudent.php?submit=delete&matric=$std_matric' class='fa fa-trash' onclick=\"return confirm('Are you sure?')\"></a></button>";
            } else {
                // if user_id starts with C, show the lecturer name
                $lecturer_name = $student['lecturer_name'];
                echo "<tr><td>$i</td><td>$std_matric</td><td>$std_name</td><td>$project_title</td><td>$lecturer_name</td>
                <td><button class='btn'><a href='managestudent.php?submit=delete&matric=$std_matric' class='fa fa-trash' onclick=\"return confirm('Are you sure?')\"></a></button>";
            }
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
            echo '<a href = "managestudent.php?pageno=' . $page . '" style=
            "text-decoration: none">&nbsp&nbsp' . $page . ' </a>';
        }
        echo " ( " . $pageno . " )";
        echo "</center>";
        echo "</div>";
    ?>
    <br>

<footer class="w3-footer w3-center w3-bottom w3-grey">FPMS</footer>

<div class="popup-page">
  <div class="popup-page-content">
    <span class="close-popup-page">&times;</span>
    <form action="managestudent.php" method="POST" class="left-align-form">
      <label for="matric-number">Matric Number:</label>
      <input type="text" name="matric" id="matric">
      <?php
        if(substr($user_id, 0, 1) == 'C') {
          echo '<label for="project-name">Project ID:</label>
          <input type="text" name="project_id" id="project_id">';
        }
      ?>
      
      <input type="submit" name="submit" value="submit">
    </form>
  </div>
</div>

  <script>
    const addStudentBtn = document.querySelector('.add-student-btn');
    const popupPage = document.querySelector('.popup-page');
    const closePopupPage = document.querySelector('.close-popup-page');

    addStudentBtn.addEventListener('click', function(event) {
      event.preventDefault();
      popupPage.style.display = 'block';
    });

    closePopupPage.addEventListener('click', function() {
      popupPage.style.display = 'none';
    });
  </script>
  </body>
</html>