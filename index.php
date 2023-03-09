<?php
session_start();
if (isset($_POST['submit'])) {
    include_once("dbconnect.php");
    $name = trim($_POST['name']);
    $password = trim($_POST['password']);
    $sqllogin = "SELECT * FROM tbl_users WHERE username = '$name' AND user_password = '$password'";

    $select_stmt = $conn->prepare($sqllogin);
    $select_stmt->execute();
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
    if ($select_stmt->rowCount() > 0) {
        $user_id = $row["user_id"];
        $_SESSION["session_id"] = session_id();
        $_SESSION["name"] = $name;
        if (substr($user_id, 0, 1) == "A") {
            echo "<script> alert('Admin login successful')</script>";
            echo "<script> window.location.replace('admin.php')</script>";
        } elseif (substr($user_id, 0, 1) == "L") {
            echo "<script> alert('Lecturer login successful')</script>";
            echo "<script> window.location.replace('lecturer.php')</script>";
        }
    } else {
        session_unset();
        session_destroy();
        echo "<script> alert('Login fail')</script>";
        echo "<script> window.location.replace('index.php')</script>";
    }
}
if (isset($_GET["status"])) {
    if (($_GET["status"] == "logout")) {
        session_unset();
        session_destroy();
        echo "<script> alert('Session Cleared')</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
    
<body >
    <header class="w3-header w3-blue w3-center w3-padding-32 ">
        <h1>FINAL PROJECT MANAGEMENT SYSTEM</h1>
        <p>Login Page</p>
    </header>
    <div style="display: flex; justify-content: flex-end">
    <img src="pic/Optergy-BMS-Applications-900.jpg " style = "width:auto; height:auto;">
        <div class="w3-card w3-padding w3-margin" style="width:600px;margin:auto;text-align:left;">
            <form action="index.php" method="post">
                <p>
                    <label class="w3-text-black"><b>Username</b></label>
                    <input class="w3-input w3-round w3-border" type="name" name="name" id="idname" required> 
                </p>
                <p>
                    <label class="w3-text-black"><b>Password</b></label>
                    <input class="w3-input w3-round w3-border" type="password" name="password" id="idpass" required>
                </p>
                <p>
                <input class="w3-check" name="rememberme" type="checkbox" id="idremember" >
                    <label> Remember Me </label>
                </p>
                <p>
                    <input class="w3-button w3-round w3-border w3-blue" type="submit" name="submit" id="idsubmit">
                    <a href="signup.php" class="w3-red w3-button ">SignUp</a>
                   
                </p>
                
                
            </form>
        </div>   
    
</body>

</html>