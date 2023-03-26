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
        }elseif (substr($user_id, 0, 1) == "S") {
            echo "<script> alert('Student login successful')</script>";
            echo "<script> window.location.replace('student.php')</script>";
        }elseif (substr($user_id, 0, 1) == "C") {
            echo "<script> alert('Client login successful')</script>";
            echo "<script> window.location.replace('client.php')</script>";
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
    <style>
        body {
            background-image: url("pic/wallpaperflare.com_wallpaper.jpg");
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
            color: #fff;
            text-align: center;
            height: 100vh;
            margin: 0;
            padding: 0;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            margin: 0 auto;
        }
        form {
            background-color: rgba(	128, 128, 128, 0.8);
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            max-width: 500px;
            margin: 0 auto;
        }
        h1 {
            font-size: 48px;
            margin-bottom: 20px;
        }
        label {
            display: block;
            font-size: 24px;
            margin-bottom: 10px;
            text-align: left;
        }
        input[type="text"], input[type="password"] {
            border: none;
            border-radius: 5px;
            font-size: 24px;
            padding: 10px;
            width: 100%;
            margin-bottom: 20px;
        }
        input[type="submit"] {
            background-color: #0095ff;
            border: none;
            border-radius: 5px;
            color: #fff;
            font-size: 24px;
            padding: 10px 20px;
            cursor: pointer;
            margin-top: 20px;
        }
        input[type="submit"]:hover {
            background-color: #0073e6;
        }
        .signup {
            font-size: 24px;
            color: #fff;
            text-decoration: none;
            margin-left: 10px;
            border-bottom: 2px solid #fff;
            padding-bottom: 5px;
        }
        .signup:hover {
            border-bottom-color: #0073e6;
        }
    </style>
</head>

<body>
    <div class="container">
        <form action="index.php" method="post">
            <h1>Welcome !</h1>
            <br>
            <label for="idname">Username</label>
            <input type="text" name="name" id="idname" required>
            <label for="idpass">Password</label>
            <input type="password" name="password" id="idpass" required>
            <label for="idremember">Remember me  <input type="checkbox" name="rememberme" id="idremember"> </label>
            <input type="submit" name="submit" id="idsubmit" value="Login">
            <a href="signup.php" class="signup">Sign up</a>
        </form>
    </div>
</body>
</html>

