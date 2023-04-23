<?php
session_start();
$name = $_SESSION["name"];

include_once("dbconnect.php");
$sqluser = "SELECT * FROM tbl_users WHERE username = '$name '";
  $select_stmt = $conn->prepare($sqluser);
  $select_stmt->execute();
  $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
  $user_id = $row["user_id"];



if (!isset($_SESSION['session_id'])) {
    echo "<script>alert('Session not available. Please login');</script>";
    echo "<script> window.location.replace('login.php')</script>";
}

if (substr($user_id, 0, 1) == "S") {
    $sql = "SELECT * FROM tbl_student WHERE std_name = '$name'";
    $select_stmt = $conn->prepare($sql);
    $select_stmt->execute();
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
    $std_matric = $row["std_matric"];
}  else {
    $id = $_GET['id'];
    $std_matric = $id;
    $sqlstudent = "SELECT * FROM tbl_student WHERE std_matric = '$id'";
    $stmt = $conn->prepare($sqlstudent);
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $rows = $stmt->fetchAll();
}

if (isset($_GET['submit'])) {
    $operation = $_GET['submit'];
    if ($operation == 'delete') {
        $task_id = $_GET['task_id'];
        $sqldeletetask = "DELETE FROM `tbl_dashboard` WHERE task_id = '$task_id'";
        
    }
    try {
        $conn->exec($sqldeletetask);
        echo "<script>alert('Task deleted')</script>";
        echo "<script>window.location.replace('dashboard.php?id='.$id')</script>";
        } catch (PDOException $e){
            echo "<script>alert('Failed')</script>";
           echo "<script>window.location.replace('dashboard.php?id='.$id')</script>";
        
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

$sql = "SELECT * FROM tbl_dashboard WHERE std_id = '$std_matric '";
$stmt = $conn->prepare($sql);
$stmt->execute();
$number_of_result = $stmt->rowCount();
$number_of_page = ceil($number_of_result / $results_per_page);
$sql = $sql. " LIMIT $page_first_result , $results_per_page";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$rows = $stmt->fetchAll();

?>



<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
    body {
    margin: 0;
    font-family: Arial, sans-serif;
    }

    header {
        background-color: #333;
        color: #fff;
        padding: 35px;
    }

    header h1 {
        margin: 0;
        font-size: 36px;
    }

    header p {
        margin: 0;
        font-size: 18px;
    }

    main {
        max-width: 950px;
        margin: 0 auto;
        padding: 20px;
    }

    
    ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    li {
        margin-bottom: 5px;
    }

    label {
        font-size: 18px;
        display: block;
        margin-bottom: 10px;
    }

    input[type=file] {
        display: block;
        margin-bottom: 10px;
    }


    #remove-btn {
        background-color: #f44336;
        margin-left: 10px;
    }

    footer {
        background-color: #f2f2f2;
        padding: 10px;
        text-align: center;
    }

    .back-button {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 5px;
        }

    .back-button:hover {
        background-color: #d32f2f;
        }

    .add-task-button {
        background-color: #4CAF50;
        border: none;
        color: white;
        padding: 12px 30px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
    }








</style>
<body>
    <header>
    <a href="<?php 
    if(substr($user_id, 0, 1) == "L") { 
        echo "studentprofile.php?id=$id"; 
    } else if(substr($user_id, 0, 1) == "C") {
        echo "studentprofile.php?id=$id";
    } else {
        echo 'student.php'; 
    } ?>" class="button w3-right back-button">Back</a>

        <h1>Dashboard</h1>
       
    </header>
    <main>
    <?php 
       if(substr($user_id, 0, 1) == "L") { 
        echo '<a href="add_task.php?id='.$id.'" class="button w3-right add-task-button">Add Task</a>'; 
    }
    
    
    
    
        ?>
        <section id="progress">
            <h2>Progress Status</h2>
            <p>Your current progress: 0%</p>
        </section>
        <section id="tasks">
            <div class="w3-margin w3-border" style="overflow-x:auto;">
            <?php
                $i = 0;
                echo "<table class='w3-table w3-striped w3-bordered' style='width:100%'>
                    <tr><th style='width:5%'>No</th><th style='width:20%'>Task </th><th style='width:20%'>Due date</th><th style='width:30%'>Submission date</th><th style='width:10%'>Upload</th>
                    <th style='width:10%'>Status</th>";
                if(substr($user_id, 0, 1) == "L") { 
                    echo "<th style='width:5%'>Operations</th>";
                }
                echo "</tr>";
                foreach ($rows as $dashboard) {
                    $i++;
                    $task_id = $dashboard['task_id'];
                    $task_name = $dashboard['task_name'];
                    $due_date = $dashboard['due_date'];
                    $submission_date = $dashboard['submission_date'];
                    $upload = "<a href='#'>Upload</a>";
                    $status = $dashboard['status'];
                    echo "<tr><td>$i</td><td>$task_name</td><td>$due_date</td><td>$submission_date</td><td> $upload</td><td> $status</td>";
                    if(substr($user_id, 0, 1) == "L") { 
                        echo "<td><button class='btn'><a href='dashboard.php?submit=delete&id=$id&task_id=$task_id' class='fa fa-trash' onclick=\"return confirm('Are you sure?')\"></a></button>
                        <button class='btn'><a href='edit_task.php?submit=details&id=$id&task_id=$task_id' class='fa fa-edit'></a></button></td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            ?>

            </div>
        </section>
    </main>
</body>

</html>

