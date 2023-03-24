<?php
session_start();
$name = $_SESSION["name"];
include_once("dbconnect.php");

if (!isset($_SESSION['session_id'])) {
    echo "<script>alert('Session not available. Please login');</script>";
    echo "<script> window.location.replace('index.php')</script>";
    
}
$sqlclient = "SELECT * FROM tbl_client WHERE client_name = '$name'";
$select_stmt = $conn->prepare($sqlclient);
$select_stmt->execute();

if (isset($_GET['submit'])) {
    $operation = $_GET['submit'];
    if ($operation == 'delete') {
        $user_id = $_GET['user_id'];
        $sqldeleteclientinfo = "DELETE FROM `tbl_client` WHERE user_id = '$user_id'";
        $conn->exec($sqldeleteclientinfo);
        echo "<script>alert('Info deleted')</script>";
        echo "<script>window.location.replace('client.php')</script>";
    }
} else {
    $sqlclient = "SELECT * FROM tbl_client";
}

if ($select_stmt->rowCount() > 0) {
    // user information is available in the database
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
    $user_id = $row['user_id'];
    $description = $row['client_description'];
    $tel = $row['client_tel'];
    $email = $row['client_email'];
    $address = $row['client_address'];
    $dob = $row['client_dateofbirth'];
    $gender = $row['client_gender'];
    $race = $row['client_races'];
    $office = $row['client_office'];
} else {
    // user information is not available in the database

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
            <a href="managestudent.php" class="w3-bar-item w3-button w3-right">Student</a>
            <a href="manageproject.php" class="w3-bar-item w3-button w3-right">Project</a>
            <a href="client.php" class="w3-bar-item w3-button w3-right">Profile</a>
            
        </div>
    </div>
    <div>
    <h2><?php echo "Welcome $name" ?></h2>
    <div class="profile-container">
  <div class="profile-image"> 
  <img src="../user/client/<?php echo $user_id?>.png" onerror="this.onerror=null;this.src='pic/lecturer.webp'" >
  </div>
  <div class="profile-info">
    <?php if ($select_stmt->rowCount() >0): ?>
      <div class="profile-details">
        <p><strong>User ID:</strong> <?php echo $user_id; ?></p>
        <p><strong>Description:</strong> <?php echo $description; ?></p>
        <p><strong>Telephone:</strong> <?php echo $tel; ?></p>
        <p><strong>Email:</strong> <?php echo $email; ?></p>
        <p><strong>Address:</strong> <?php echo $address; ?></p>
        <p><strong>Date of Birth:</strong> <?php echo $dob; ?></p>
        <p><strong>Gender:</strong> <?php echo $gender; ?></p>
        <p><strong>Race:</strong> <?php echo $race; ?></p>
        <p><strong>Office:</strong> <?php echo $office; ?></p>
        <a href="updateClientInfo.php?submit=details&user_id=<?php echo $user_id?>" class="w3-button w3-blue">Edit Profile</a>
        <a href="client.php?submit=delete&user_id=<?php echo $user_id?>" class="w3-button w3-red" >Delete Profile</a>
      
      </div>
    <?php else: ?>
      <p>You haven't filled in your information yet. Click <a class="add-info-link" href="addClientInfo.php">here</a> to fill it in.</p>
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


