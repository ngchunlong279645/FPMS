<?php
session_start();
$name = $_SESSION["name"];

include 'dbconnect.php';
$sql = "SELECT * FROM tbl_users WHERE username = '$name '";
  $select_stmt = $conn->prepare($sql);
  $select_stmt->execute();
  $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
  $user_id = $row["user_id"];
  $user_password= $row["user_password"];

if (!isset($_SESSION['session_id'])) {
  echo "<script>alert('Session not available. Please login');</script>";
  echo "<script> window.location.replace('login.php')</script>";
}

if (isset($_POST['submit'])) {
  include 'dbconnect.php';

  $current_password = $_POST['current_password'];
  $new_password = $_POST['new_password'];
  $confirm_password =$_POST['confirm_password']; 
  try {
    if ($current_password == $user_password) {
      if ($new_password == $confirm_password) {
        $sqlpass = "UPDATE tbl_users SET user_password = '$new_password' WHERE user_id = '$user_id'";
        $conn->exec($sqlpass);
        echo "<script> alert('Password updated successful')</script>";
        if (substr($user_id, 0, 1) == "A") {
          echo "<script> window.location.replace('admin.php')</script>";
      } elseif (substr($user_id, 0, 1) == "L") {
          echo "<script> window.location.replace('lecturer.php')</script>";
      }elseif (substr($user_id, 0, 1) == "S") {
          echo "<script> window.location.replace('student.php')</script>";
      }elseif (substr($user_id, 0, 1) == "C") {
        echo "<script> window.location.replace('client.php')</script>";
    }
        }$error_message = 'New password and confirm password do not match.';
      } else {
        $error_message = 'Current password is incorrect.';
      }
    } catch (PDOException $e){
        echo "<script>alert('Failed')</script>";
       echo "<script>window.location.replace('chgpassword.php')</script>";
    }

  
 
  }

?>

<html>
<head>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <title>Change Password</title>
  <style>
    body {
      font-family: Arial, sans-serif;
    }
    .container {
      width: 500px;
      margin: 0 auto;
    }
    form {
      border: 1px solid #ccc;
      padding: 20px;
      box-shadow: 2px 2px 5px #ccc;
    }
    h1 {
      text-align: center;
      margin-top: 35px;
    }
    label {
      font-weight: bold;
      margin-top: 20px;
      display: block;
    }
    input[type="password"], input[type="submit"] {
      width: 100%;
      padding: 10px;
      margin-top: 10px;
      font-size: 16px;
    }
    input[type="submit"] {
      background-color: #4CAF50;
      color: white;
      cursor: pointer;
    }
    p.error {
      color: red;
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
  </style>
</head>
<body>
<a href="<?php 
    if(substr($user_id, 0, 1) == "A") { 
        echo 'admin.php'; 
    } else if(substr($user_id, 0, 1) == "L") { 
        echo 'lecturer.php'; 
    } else if(substr($user_id, 0, 1) == "C") { 
        echo 'client.php'; 
    } else {
      echo 'student.php'; 
    } 
?>" class="button w3-right back-button">Back</a><header class="w3-header w3-blue w3-center w3-padding-32 ">
    <h1>FINAL PROJECT MANAGEMENT SYSTEM</h1>
</header>
  <div class="container">
    <h1>Change Password</h1>
    <?php if (isset($error_message)) { ?>
      <p class="error"><?php echo $error_message; ?></p>
    <?php } ?>
    <form action="" method="post">
      <label for="current_password">Current Password:</label>
      <input type="password" id="current_password" name="current_password">
      <label for="new_password">New Password:</label>
      <input type="password" id="new_password" name="new_password">
      <label for="confirm_password">Confirm Password:</label>
      <input type="password" id="confirm_password" name="confirm_password">
      <input type="submit" name="submit" value="Change Password">
    </form>
  </div>
</body>
</html>