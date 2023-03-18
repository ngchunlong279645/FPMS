<?php
session_start();
if (!isset($_SESSION['session_id'])) {
    echo "<script>alert('Session not available. Please login');</script>";
    echo "<script> window.location.replace('login.php')</script>";
}
include_once("dbconnect.php");

if (isset($_GET['submit'])) {
    $operation = $_GET['submit'];
    if ($operation == 'delete') {
        $user_id = $_GET['uid'];
        $sqldeleteuser = "DELETE FROM `tbl_users` WHERE user_id = '$user_id'";
        $conn->exec($sqldeleteuser);
        echo "<script>alert('User deleted')</script>";
        echo "<script>window.location.replace('manageuser.php')</script>";
    }
    if ($operation == 'search') {
        $search = $_GET['search'];
        $option = $_GET['option'];
        if ($option == "Select") {
            $sqluser = "SELECT * FROM tbl_users WHERE username LIKE '%$search%'";
        } else {
            $sqluser = "SELECT * FROM tbl_users WHERE user_role = '$option'";
        }
    }
} else {
    $sqluser = "SELECT * FROM tbl_users";
}

$results_per_page = 20;
if (isset($_GET['pageno'])) {
     $pageno = (int)$_GET['pageno'];
    $page_first_result = ($pageno - 1) * $results_per_page;
} else {
     $pageno = 1;
    $page_first_result = 0;
}


$stmt = $conn->prepare($sqluser );
$stmt->execute();
$number_of_result = $stmt->rowCount();
$number_of_page = ceil($number_of_result / $results_per_page);
$sqluser = $sqluser. " LIMIT $page_first_result , $results_per_page";
$stmt = $conn->prepare($sqluser);
$stmt->execute();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$rows = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="../js/menu.js" defer></script>

    <title>Welcome to Final Project Management System</title>
</head>

<body>
    <div class="w3-grey">
    <a href="lecturer.php" class="w3-bar-item w3-button w3-right">Back</a>
        <div class="w3-container">
            <h3>Manage User</h3>
        </div>
    </div>
    <div class="w3-bar w3-grey">
        <a href="adduser.php" class="w3-bar-item w3-button w3-right">Add User</a>
    </div>
    <div class="w3-card w3-container w3-padding w3-margin w3-round">
        <h3>User Search</h3>
        <form>
            <div class="w3-row">
                <div class="w3-half" style="padding-right:4px">
                    <p><input class="w3-input w3-block w3-round w3-border" type="search" name="search" placeholder="Enter search term" /></p>
                </div>
                <div class="w3-half" style="padding-right:4px">
                    <p> <select class="w3-input w3-block w3-round w3-border" name="option">
                            <option value="Select" selected>Select</option>
                            <option value="lecturer">lecturer</option>
                            <option value="admin">admin</option>
                            <option value="student">student</option>
                        </select>
                    </p>
                </div>
            </div>
            <button class="w3-button w3-grey w3-round w3-right" type="submit" name="submit" value="search">search</button>
        </form>

    </div>
    <div class="w3-margin w3-border" style="overflow-x:auto;">
        <?php
        $i = 0;
        echo "<table class='w3-table w3-striped w3-bordered' style='width:100%'>
         <tr><th style='width:5%'>No</th><th style='width:10%'>User Role</th><th style='width:10%'>User Id</th><th style='width:20%'>Username</th>
         <th style='width:30%'>Password</th> <th style='width:30%'>Email</th><th>Date of Register</th><th>Operations</th></tr>";
        foreach ($rows as $users) {
            $i++;
            $urole = $users['user_role'];
            $uid = $users['user_id'];
            $uname = $users['username'];
            $upass = $users['user_password'];
            $uemail = $users['user_email'];
            $uotp = $users['user_otp'];
            $udor = $users['user_datereg'];
            echo "<tr><td>$i</td><td>$urole</td><td>$uid</td><td>$uname</td><td>$upass</td><td>$uemail</td><td>$udor</td>
            <td><button class='btn'><a href='manageuser.php?submit=delete&uid=$uid' class='fa fa-trash' onclick=\"return confirm('Are you sure?')\"></a></button>
            <button class='btn'><a href='updateuser.php?submit=details&uid=$uid' class='fa fa-edit'></a></button></td></tr>";
        }
        echo "</table>";
        ?>
    </div>
    <br>
    <?php
        $num = 1;
        if ($pageno == 1) {
            $num = 1;
        } else if ($pageno == 2) {
            $num = ($num) + 10;
        } else {
            $num = $pageno * 10 - 9;
        }
        echo "<div class='w3-container w3-row'>";
        echo "<center>";
        for ($page = 1; $page <= $number_of_page; $page++) {
            echo '<a href = "manageuser.php?pageno=' . $page . '" style=
            "text-decoration: none">&nbsp&nbsp' . $page . ' </a>';
        }
        echo " ( " . $pageno . " )";
        echo "</center>";
        echo "</div>";
    ?>
    <br>

<footer class="w3-footer w3-center w3-bottom w3-grey">FPMS</footer>

</body>

</html>