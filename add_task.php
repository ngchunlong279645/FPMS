<?php
session_start();
$id = $_GET['id'];
$task_id = 'T' . rand(1000,9999);
if (!isset($_SESSION['session_id'])) {
    echo "<script>alert('Session not available. Please login');</script>";
    echo "<script> window.location.replace('login.php')</script>";
}

	

if (isset($_POST['submit'])) {
    include_once("dbconnect.php");
    $task_name = addslashes($_POST['task_name']); 
    $due_date = addslashes($_POST['due_date']);
    $std_matric = addslashes($_POST['std_matric']);
    $sqladdtask = "INSERT INTO `tbl_dashboard`(`task_id`, `task_name`, `due_date`, `std_id`) 
    VALUES ('$task_id','$task_name','$due_date','$std_matric')";
    
  
    try {
      $conn->exec( $sqladdtask);
          echo "<script>alert('Success')</script>";
          echo "<script>window.location.replace('dashboard.php?id=$std_matric')</script>";
  } catch (PDOException $e) {
      echo "<script>alert('Failed')</script>";
      echo "<script>window.location.replace('addtask.php?id=$std_matric')</script>";
  }
        
  }

?>

<!DOCTYPE html>
<html>
<head>
	<title>Add Task</title>
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<style>
		input[type=text], input[type=date] {
			width: 100%;
			padding: 12px 20px;
			margin: 8px 0;
			display: inline-block;
			border: 1px solid #ccc;
			border-radius: 4px;
			box-sizing: border-box;
		}
		
		input[type=submit] {
			background-color: #4CAF50;
			color: white;
			padding: 12px 20px;
			border: none;
			border-radius: 4px;
			cursor: pointer;
		}
		
		input[type=submit]:hover {
			background-color: #45a049;
		}
		
		.container {
			border-radius: 5px;
			background-color: #f2f2f2;
			padding: 20px;
			margin-top: 20px;
		}
	</style>
</head>
<body>
	<header>
    <a href="<?php 
            echo "dashboard.php?id=$id"; 
        ?>" class="button w3-right back-button">Back</a>
		<h1>Add Task</h1>
        
	</header>
	<main>
		<div class="w3-container container">
			<form action="add_task.php" method="post">
				<label for="task_id">Task ID:</label>
				<input type="text" id="task_id" name="task_id" value="<?php echo $task_id ?>" readonly><br>

				<label for="task_name">Task Name:</label>
				<input type="text" id="task_name" name="task_name"><br>

				<label for="due_date">Due Date:</label>
				<input type="date" id="due_date" name="due_date"><br>

				<input type="hidden" name="std_matric" value="<?php echo $id ?>">

				<input type="submit" name="submit" value="Submit">
			</form>
		</div>
	</main>
</body>
</html>
