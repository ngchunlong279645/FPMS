<?php
session_start();
$name = $_SESSION["name"];
include_once("dbconnect.php");

if (!isset($_SESSION['session_id'])) {
    echo "<script>alert('Session not available. Please login');</script>";
    echo "<script> window.location.replace('index.php')</script>";
    
}
$sqllec = "SELECT * FROM tbl_lecturer WHERE lec_name = '$name'";
$select_stmt = $conn->prepare($sqllec);
$select_stmt->execute();


if ($select_stmt->rowCount() > 0) {
    // user information is available in the database
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
    $user_id = $row['user_id'];
    $description = $row['lec_description'];
    $tel = $row['lec_tel'];
    $email = $row['lec_email'];
    $address = $row['lec_address'];
    $dob = $row['lec_dateofbirth'];
    $gender = $row['lec_gender'];
    $race = $row['lec_races'];
    $office = $row['lec_office'];
} else {
    // user information is not available in the database
    $profile_picture = "";
    $description = "";
    $tel = "";
    $email = "";
    $address = "";
    $dob = "";
    $gender = "";
    $race = "";
    $office = "";
}

?>

<!DOCTYPE html>
<html lang="en">

<style>
    .add-info-link {
      color: blue;
      text-decoration: underline;
      cursor: pointer;
    }

    .profile-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin: 20px;
    }

    .profile-image {
    margin-right: 50px;
    }

    .profile-info {
    flex-grow: 1;
    }

    .profile-calendar {
    flex-shrink: 0;
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
            <a href="student.php" class="w3-bar-item w3-button w3-right">Student</a>
            <a href="lecturer.php" class="w3-bar-item w3-button w3-right">Profile</a>
            
        </div>
    </div>
    <h2><?php echo "Welcome $name" ?></h2>
    <div class="profile-container">
  <div class="profile-image">
    <img src="../user/lecturer/<?php echo $user_id?>.png" onerror="this.onerror=null;this.src='pic/lecturer.webp'" alt="Profile image" style="max-height:500px;max-width:400px">
  </div>
  <div class="profile-info">
    <?php if ($select_stmt->rowCount() >0): ?>
      <div class="profile-details">
        <p><strong>Description:</strong> <?php echo $description; ?></p>
        <p><strong>Telephone:</strong> <?php echo $tel; ?></p>
        <p><strong>Email:</strong> <?php echo $email; ?></p>
        <p><strong>Address:</strong> <?php echo $address; ?></p>
        <p><strong>Date of Birth:</strong> <?php echo $dob; ?></p>
        <p><strong>Gender:</strong> <?php echo $gender; ?></p>
        <p><strong>Race:</strong> <?php echo $race; ?></p>
        <p><strong>Office:</strong> <?php echo $office; ?></p>
        <a href="updateLecInfo.php" class="w3-button w3-blue">Edit Profile</a>
      </div>
    <?php else: ?>
      <p>You haven't filled in your information yet. Click <a class="add-info-link" href="addLecInfo.php">here</a> to fill it in.</p>
    <?php endif; ?>
  </div>
  <div class="profile-calendar">
    <iframe src="https://calendar.google.com/calendar/embed?" style="border: 0" width="400" height="500" frameborder="0" scrolling="no"></iframe>
  </div>
</div>
</body>
</html>
        
    </div>
    
    


    <footer class="w3-footer w3-center w3-bottom w3-light-blue">FPMS</footer>

</body>

</html>