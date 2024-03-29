<?php
session_start();
if (!isset($_SESSION['session_id'])) {
    echo "<script>alert('Session not available. Please login');</script>";
    echo "<script> window.location.replace('login.php')</script>";
}

include_once("dbconnect.php");

if (isset($_POST['submit'])) {
    $operation = $_POST['submit'];
    $uid = $_POST['uid'];
    $name = addslashes($_POST['name']); 
    $useremail = addslashes($_POST['email']);
    $password = $_POST['password']; 
    $sqlupdate = "UPDATE `tbl_users` SET `username`='$name',`user_email`='$useremail',`user_password`='$password'
    WHERE user_id = '$uid'";
         if (substr($uid , 0, 1) == "S") {
            $sqlgetname = "SELECT `std_name` FROM `tbl_student` WHERE user_id = '$uid'";
            $stmt = $conn->prepare($sqlgetname);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $std_name = $row['std_name'];

            $sqlcheckstd = "SELECT * FROM `tbl_projects` WHERE `std_name` = '$std_name'";
            $stmt = $conn->prepare($sqlcheckstd);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $sqlupdateprostd = "UPDATE `tbl_projects` SET `std_name`='$name' WHERE `std_name` = '$std_name'";
                $stmt = $conn->prepare($sqlupdateprostd);
                $stmt->execute();
            }

            $sqlupdatestd = "UPDATE `tbl_student` SET `std_name`='$name', `std_email`='$useremail' WHERE user_id = '$uid'";
            $stmt = $conn->prepare($sqlupdatestd);
            $stmt->execute();

         }else if (substr($uid , 0, 1) == "L") {
            $sqlgetname = "SELECT `lec_name` FROM `tbl_lecturer` WHERE user_id = '$uid'";
            $stmt = $conn->prepare($sqlgetname);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $lec_name = $row['lec_name'];

            $sqlchecklec = "SELECT * FROM `tbl_student` WHERE `lecturer_name` = '$lec_name'";
            $stmt = $conn->prepare($sqlchecklec);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $sqlupdatestdlec = "UPDATE `tbl_student` SET `lecturer_name`='$name' WHERE `lecturer_name` = '$lec_name'";
                $stmt = $conn->prepare($sqlupdatestdlec);
                $stmt->execute();
            }

            $sqlupdatelec = "UPDATE `tbl_lecturer` SET `lec_name`='$name', `lec_email`='$useremail' WHERE user_id = '$uid'";
            $stmt = $conn->prepare($sqlupdatelec);
            $stmt->execute();


         }else if (substr($uid , 0, 1) == "C") {
            $sqlgetname = "SELECT `client_name` FROM `tbl_client` WHERE user_id = '$uid'";
            $stmt = $conn->prepare($sqlgetname);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $client_name = $row['client_name'];

            $sqlcheckclie = "SELECT * FROM `tbl_projects` WHERE `project_client` = '$client_name'";
            $stmt = $conn->prepare($sqlcheckclie);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $sqlupdateproclie = "UPDATE `tbl_projects` SET `project_client`='$name' WHERE `project_client` = '$client_name'";
                

                $sqlcheckstdclient = "SELECT * FROM `tbl_student` WHERE `client_name` = '$client_name'";
                $stmt = $conn->prepare($sqlcheckstdclient);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($row) {
                    $sqlupdatestdclient = "UPDATE `tbl_student` SET `client_name`='$name' WHERE `client_name` = '$client_name'";
                    $stmt = $conn->prepare($sqlupdatestdclient);
                    $stmt->execute();
                }
                $stmt = $conn->prepare($sqlupdateproclie);
                $stmt->execute();
            }

            $sqlupdatecli = "UPDATE `tbl_client` SET `client_name`='$name', `client_email`='$useremail' WHERE user_id = '$uid'";
            $stmt = $conn->prepare($sqlupdatecli);
            $stmt->execute();
         }else{
            $sqlupdateadmin = "UPDATE `tbl_admin` SET `admin_name`='$name', `admin_email`='$useremail' WHERE user_id = '$uid'";
            $stmt = $conn->prepare($sqlupdateadmin);
            $stmt->execute();
         }

    try {
        $conn->exec( $sqlupdate);
            echo "<script>alert('Success')</script>";
            echo "<script>window.location.replace('manageuser.php')</script>";
    } catch (PDOException $e) {
       echo "<script>alert('Failed')</script>";
        echo "<script>window.location.replace('updateuser.php')</script>";
    }
}

if (isset($_GET['submit'])) {
    $operation = $_GET['submit'];
    if ($operation == 'details') {
        $uid = $_GET['uid'];
        $sqluser = "SELECT * FROM tbl_users WHERE user_id = '$uid'";
        $stmt = $conn->prepare($sqluser);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        $number_of_rows = $stmt->rowCount();
        if ($number_of_rows > 0) {
            foreach ($rows as $users) {
                $urole = $users['user_role'];
                $uid = $users['user_id'];
                $uname = $users['username'];
                $upass = $users['user_password'];
                $uemail = $users['user_email'];
            }
        }else{
            echo "<script>alert('No user found')</script>";
            echo "<script>window.location.replace('manageuser.php')</script>";
        }
    }
}else{
    echo "<script>alert('Error')</script>";
    echo "<script>window.location.replace('manageuser.php')</script>";
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
    <script src="../js/menu.js"></script>
    <script src="../js/script.js"></script>

    <title>Welcome to Final Project Management System</title>
</head>

<body>
    <div class="w3-yellow">
        <div class="w3-container">
            <h3>Update User</h3>
        </div>
    </div>
    <div class="w3-bar w3-yellow">
        <a href="manageuser.php" class="w3-bar-item w3-button w3-right">Back</a>
    </div>
    <div class="w3-content w3-padding-32">
        <form class="w3-card w3-padding" action="updateuser.php" method="post" enctype="multipart/form-data" onsubmit="return confirm('Are you sure?')">
            <div class="w3-container w3-yellow">
                <h3>User ID : <?php echo $uid ?> </h3>
            </div>
            <hr>
            <input type="hidden" name="uid" value="<?php echo $uid ?>">
            <div class="w3-row">
                <div class="w3-half" style="padding-right:4px">
                    <p>
                        <label><b>User Name</b></label>
                        <input class="w3-input w3-border w3-round " name="name" type="text" value="<?php echo $uname ?>" required>
                    </p>
                </div>
                <div class="w3-half" style="padding-right:4px">
                    <p>
                        <label><b>User Role</b></label>
                        <span class="w3-input w3-border w3-round w3-light-grey"><?php echo $urole?></span>
                    </p>
                </div>
            </div>
            <p>
                <label><b>Email</b></label>
                <textarea class="w3-input w3-border w3-round" rows="4" width="100%" name="email" required><?php echo $uemail ?></textarea>
            </p>
            <div class="w3-row">
                <div class="w3-third" style="padding-right:4px">
                    <p>
                        <label><b>User Password</b></label>
                        <input class="w3-input w3-border w3-round" name="password" type="text" value="<?php echo $upass ?>" required>
                    </p>
                </div>
                <p>
                    <input class="w3-button w3-yellow w3-round w3-block w3-border" type="submit" name="submit" value="Update">
                </p>
            </div>
        </form>
    </div>

    <footer class="w3-footer w3-center w3-bottom w3-yellow">FPMS</footer>

</body>

</html>