<?php
if (isset($_POST['submit'])) {
  include_once("dbconnect.php");
  $username = addslashes($_POST['name']); 
  $useremail = addslashes($_POST['email']);
  $credit = 5;  
  $otp = rand(10000, 99999);
  $password = $_POST['passworda']; 
  $role = ($_POST['role']);
  $userID = generateUserID($role);
  $userID = $conn->quote($userID);
  echo $sqlregister = "INSERT INTO `tbl_users`(`user_id`, `user_role`, `username`, `user_email`, `user_password`, `user_otp`, `user_credit`) 
  VALUES ($userID, '$role','$username','$useremail','$password','$otp','$credit')";
  
  try {
  $conn->exec($sqlregister);
  echo "<script>alert('Success')</script>";
  echo "<script>window.location.replace('index.php')</script>"; 
  } catch (PDOException $e){
      echo "<script>alert('Failed')</script>";
     echo "<script>window.location.replace('signup.php')</script>";
  
}
      
}

function generateUserID($role) {
  $prefix = substr($role, 0, 1);
  $suffix = rand(1000, 9999);
  return $prefix . $suffix;
}


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href = "../css/style.css">
    <script src="../js/menu.js"></script>
    <script src="../js/script.js"></script>
    <title>Welcome to FPMS</title>
  </head>
  <body style="max-width:1200px;margin:0 auto;">
    <header class="w3-header w3-blue w3-center w3-padding-32">
        <h3>Final Project Management System</h3>
    </header>
    <div class="w3-bar w3-blue">
      <a href="index.php" class="w3-bar-item w3-button w3-right">Back</a>
    </div>
    <div class="w3-content w3-padding-32">
      <form class="w3-card w3-padding" action="signup.php" method="post" enctype="multipart/form-data" onsubmit="return confirm('Are you sure?')">
        <div class="w3-container w3-blue">
          <h3>New Account</h3>
        </div>
        <div class="w3-row">
          <div class="w3-half" style="padding-right:4px">
            <p>
              <label>
                <b>Name</b>
              </label>
              <input class="w3-input w3-border w3-round" name="name" type="text" required>
            </p>
          </div>
          <div class="w3-half" style="padding-right:4px">
            <p>
              <label>
                <b>Email</b>
              </label>
              <input class="w3-input w3-border w3-round" name="email" type="email" required>
            </p>
          </div>
        </div>
        <div class="w3-row">
          <div class="w3-half" style="padding-right:4px">
            <p>
              <label>
                <b>Role</b>
              </label>
              <select class="w3-select w3-border w3-round" name="role">
                <option value="Lecturer">Lecturer</option>
                <option value="Admin">Admin</option>
                <option value="Student">Student</option>
                <option value="Client">Client</option>
              </select>
            </p>
          </div>
          <div class="w3-row">
          <div class="w3-half" style="padding-right:4px">
            <p>
              <label>
                <b>Password</b>
              </label>
              <input class="w3-input w3-border w3-round" name="passworda" type="password" required>
            </p>
          </div>
          <div class="w3-half" style="padding-right:4px">
            <p>
              <label>
                <b>Re-enter Password</b>
              </label>
              <input class="w3-input w3-border w3-round" name="passwordb" type="password" required>
            </p>
          </div>
        </div>
          <div class="w3-row">
            <div class="w3-half" style="padding-right:4px">
                <label for="agree"><input type="checkbox" name="agree" required> I agree to the <a href="#">terms and conditions</a>.</label>
            <hr>
            </div>
            <div class="w3-half" style="padding-right:4px">
                <p>
                    <input class="w3-button w3-blue w3-round w3-block w3-border" type="submit" name="submit" value="Submit">
                </p>
            </div>
         </div>
         <div><a href="index.php">Already have an account? Login</a></div><br>
      </form>
    </div>
    </div>
    <div class="w3-center w3-bottom w3-blue" style="max-width:1200px;margin:0 auto;">FPMS</div>
  </body>
</html>