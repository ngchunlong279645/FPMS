<?php
session_start();
$name = $_SESSION["name"];
include_once("dbconnect.php");

if (!isset($_SESSION['session_id'])) {
    echo "<script>alert('Session not available. Please login');</script>";
    echo "<script> window.location.replace('index.php')</script>";
    
}
$sqlstudent = "SELECT * FROM tbl_student WHERE std_name = '$name'";
$select_stmt = $conn->prepare($sqlstudent);
$select_stmt->execute();

/*if (isset($_GET['submit'])) {
   $operation = $_GET['submit'];
    if ($operation == 'delete') {
       $user_id = $_GET['user_id'];
       $sqldeletestdinfo = "DELETE FROM `tbl_student` WHERE user_id = '$user_id'";
       $conn->exec($sqldeletestdinfo);
       echo "<script>alert('Info deleted')</script>";
      echo "<script>window.location.replace('student.php')</script>";
   }
} else {
   $sqlstudent = "SELECT * FROM tbl_student";
} */

if ($select_stmt->rowCount() > 0) {
    // user information is available in the database
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
    $user_id = $row['user_id'];
    $matric = $row['std_matric'];
    $description = $row['std_description'];
    $tel = $row['std_tel'];
    $email = $row['std_email'];
    $address = $row['std_address'];
    $dob = $row['std_dateofbirth'];
    $gender = $row['std_gender'];
    $race = $row['std_races'];
	$course= $row['std_course'];
    $lec_name= $row['lecturer_name'];
    $project_title = $row['project_title'];

} else {
    // user information is not available in the database

    $matric = "";
    $description = "";
    $tel = "";
    $email = "";
    $address = "";
    $dob = "";
    $gender = "";
    $race = "";
	$course = "";
    $lec_name = "";
    $project_title = "";

}

?>

<!DOCTYPE html>
<html lang="en">

<style>
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #f5f5f5;
    }

    header {
        color: white;
        font-size: 36px;
        font-weight: bold;
    }

    .w3-bar {
        background-color: #fff;
        border-bottom: 1px solid #ccc;
        position: sticky;
        top: 0;
        z-index: 1;
    }

    .w3-bar a {
        color: #444;
        display: block;
        float: right;
        font-size: 16px;
        font-weight: bold;
        padding: 12px 16px;
        text-decoration: none;
        text-align: center;
    }

    .w3-bar a:hover {
        background-color: #ddd;
        color: #000;
    }

    h2 {
        font-size: 24px;
        font-weight: bold;
        margin: 24px 0;
        text-align: center;
    }

    .profile-container {
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: flex-start;
        margin: 24px 0;
    }

    .profile-image {
        border-radius: 50%;
        overflow: hidden;
        margin-right: 24px;
        box-shadow: 0px 2px 8px rgba(0, 0, 0, 1);
    }

    .profile-image img {
        width: 400px;
        height: 500px;
    }

    .profile-info {
        flex: 1;
    }

    .profile-details {
        margin-top: 24px;
        border-top: 1px solid #ccc;
        padding-top: 24px;
    }

    .profile-details p {
        margin: 8px 0;
    }

    .add-info-link {
        color: #1da1f2;
        text-decoration: none;
    }

    .add-info-link:hover {
        text-decoration: underline;
    }

    .profile-calendar {
        flex: 1;
        margin-left: 24px;
    }

    iframe {
        border: none;
        width: 100%;
        height: 500px;
    }

    footer {
        background-color: #fff;
        border-top: 1px solid #ccc;
        padding: 12px 0;
        font-size: 12px;
        color: #444;
        position: absolute;
        bottom: 0;
        width: 100%;
    }

    .logout-button {
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

  .logout-button:hover {
    background-color: #d32f2f;
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
<a href="index.php" class="button w3-right logout-button">Logout</a>
    <header class="w3-header w3-blue w3-center w3-padding-32 ">
        <h1>FINAL PROJECT MANAGEMENT SYSTEM</h1>
    </header>

    <div class="w3-blue">
        <div class="w3-bar w3-light-blue">
            <a href="chgpassword.php" class="w3-bar-item w3-button w3-right">Change Password</a>
            <?php if ($project_title != ""): ?>
            <a href="dashboard.php" class="w3-bar-item w3-button w3-right">Dashboard</a>
        <?php else: ?>
            <a class="w3-bar-item w3-button w3-right" onclick="alert('Please add a project first.');">Dashboard</a>
        <?php endif; ?>
            <?php if ($select_stmt->rowCount() > 0): ?>
            <a href="projectstatus.php" class="w3-bar-item w3-button w3-right">Project Status</a>
        <?php else: ?>
            <a class="w3-bar-item w3-button w3-right"  onclick="alert('Please fill up your information first.');">Project Status</a>
        <?php endif; ?>
            <a href="student.php" class="w3-bar-item w3-button w3-right">Profile</a>
        </div>
    </div>
    <div>
    <h2><?php echo "Welcome $name" ?></h2>
    <div class="profile-container">
  <div class="profile-image"> 
  <img src="../user/student/<?php echo $user_id?>.png" onerror="this.onerror=null;this.src='pic/lecturer.webp'" >
  </div>
  <div class="profile-info">
    <?php if ($select_stmt->rowCount() >0): ?>
      <div class="profile-details">
        <p><strong>Matric Number:</strong> <?php echo $matric; ?></p>
        <p><strong>Description:</strong> <?php echo $description; ?></p>
        <p><strong>Telephone:</strong> <?php echo $tel; ?></p>
        <p><strong>Email:</strong> <?php echo $email; ?></p>
        <p><strong>Address:</strong> <?php echo $address; ?></p>
        <p><strong>Date of Birth:</strong> <?php echo $dob; ?></p>
        <p><strong>Gender:</strong> <?php echo $gender; ?></p>
        <p><strong>Race:</strong> <?php echo $race; ?></p>
		<p><strong>Course:</strong> <?php echo $course; ?></p>
        <p><strong>Lecturer:</strong> 
            <?php 
            
            $sqlgetuid = "SELECT `user_id` FROM `tbl_users` WHERE `username` = '$lec_name'";
            $stmt = $conn->prepare($sqlgetuid);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $uid = $row['user_id'];

            echo "<a href='userprofile.php?id={$uid}'>" . $lec_name . "</a>";
            
            }
            ?></p>

        <a href="updateStdInfo.php?submit=details&user_id=<?php echo $user_id?>" class="w3-button w3-blue">Edit Profile</a>
        
      
      </div>
    <?php else: ?>
      <p>You haven't filled in your information yet. Click <a class="add-info-link" href="addStdInfo.php">here</a> to fill it in.</p>
    <?php endif; ?>
  </div>
  <div class="profile-calendar">
    <iframe src="https://calendar.google.com/calendar/embed?src=<?php echo $email?>&ctz=Asia%2FKuala_Lumpur"></iframe>
  <hr>
    </div>
</div>
</body>
</html>

</div>




<footer class="w3-footer w3-center w3-bottom w3-light-blue">FPMS</footer>

</body>

</html>


