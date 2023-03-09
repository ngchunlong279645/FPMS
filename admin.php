<?php
session_start();
$name = $_SESSION["name"];


if (!isset($_SESSION['session_id'])) {
    echo "<script>alert('Session not available. Please login');</script>";
    echo "<script> window.location.replace('index.php')</script>";
    
}

?>

<!DOCTYPE html>
<html lang="en">

<style>
    .add-student-link {
      color: blue;
      text-decoration: underline;
      cursor: pointer;
    }
</style>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>Welcome to Final Project Management System</title>
</head>

<body>
<a href="index.php" class="w3-bar-item w3-button w3-right">Logout</a>
    <header class="w3-header w3-blue w3-center w3-padding-32 ">
        <h1>FINAL PROJECT MANAGEMENT SYSTEM</h1>
    </header>

    <div class="w3-blue">
        <div class="w3-bar w3-light-blue">
            <a href="chg.php" class="w3-bar-item w3-button w3-right">Change Password</a>
            <a href="#" class="w3-bar-item w3-button w3-right">Report</a>
            <a href="#" class="w3-bar-item w3-button w3-right">Manage Project</a>
            <a href="manageuser.php" class="w3-bar-item w3-button w3-right">Manage User</a>
            <a href="admin.php" class="w3-bar-item w3-button w3-right">Profile</a>
            
        </div>
    </div>
    <div>
        <h3><?php echo "Welcome $name" ?> 
        
        <iframe src="https://calendar.google.com/calendar/embed?" style="border: 0" width="400" height="500" frameborder="0" scrolling="no" class =" w3-right"></iframe>
        </h3>
        
        
        <div>
        <p  class =" w3-center"><a class="add-student-link" href="addInfo.php">Click here to add information</a> </p>
        
                <img src="pic/lecturer.webp " style = "width:400px; height:350px;">
            
        </div>
       
        
    </div>
    
    


    <footer class="w3-footer w3-center w3-bottom w3-light-blue">FPMS</footer>

</body>

</html>


