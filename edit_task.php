<?php
session_start();
include_once("dbconnect.php");

if (!isset($_SESSION['session_id'])) {
    echo "<script>alert('Session not available. Please login');</script>";
    echo "<script> window.location.replace('index.php')</script>";
    
}

if (isset($_POST['submit'])) {
    $operation = $_POST['submit'];
    $task_id = $_POST['task_id']; 
    $task_name = addslashes($_POST['task_name']); 
    $due_date = addslashes($_POST['due_date']);
    $std_matric = addslashes($_POST['std_matric']);
   $sqlupdate = "UPDATE `tbl_dashboard` SET `task_name`='$task_name',`due_date`='$due_date' WHERE task_id =  '$task_id'";
    try {
        $conn->exec($sqlupdate);
        echo "<script>alert('Success')</script>";
        echo "<script>window.location.replace('dashboard.php?id=$std_matric')</script>";
    } catch (PDOException $e) {
       echo "<script>alert('Failed')</script>";
       echo "<script>window.location.replace('dashboard.php?id='$std_matric')</script>";
    }
}

if (isset($_GET['submit'])) {
    $operation = $_GET['submit'];
    if ($operation == 'details') {
        $id = $_GET['id'];
        $task_id = $_GET['task_id'];
        $sqlupdatetask = "SELECT * FROM tbl_dashboard WHERE task_id = '$task_id'";
        $stmt = $conn->prepare($sqlupdatetask);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        $number_of_rows = $stmt->rowCount();
        if ($number_of_rows > 0) {
            foreach ($rows as $task) {
                $task_id= $task['task_id'];
                $task_name= $task['task_name'];
                $due_date = $task['due_date'];
            }
        }else{
            echo "<script>alert('No task found')</script>";
            echo "<script>window.location.replace('dashboard.php?id='$std_matric')</script>";
        }
    }
}else{
  echo "<script>alert('Error')</script>";
   echo "<script>window.location.replace('dashboard.php?id='$std_matric')</script>";
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Task</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>
    <header>
        <h1>Edit Task</h1>
    </header>
    <main>
    <form class="w3-card w3-padding" action="edit_task.php" method="post" enctype="multipart/form-data" onsubmit="return confirm('Are you sure?')">
            <input type="hidden" name="task_id" value="<?php echo $task_id; ?>">
            <label class="w3-text-blue"><b>Task Name</b></label>
            <input class="w3-input w3-border" type="text" name="task_name" value="<?php echo $task_name; ?>" required>

            <label class="w3-text-blue"><b>Due Date</b></label>
            <input class="w3-input w3-border" type="date" name="due_date" value="<?php echo $due_date; ?>" required>

            <input type="hidden" name="std_matric" value="<?php echo $id ?>">
            <button class="w3-btn w3-blue w3-margin-top" type="submit" name="submit">Save Changes</button>
        </form>
    </main>
</body>
</html>
