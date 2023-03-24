<?php
session_start();
$name = $_SESSION["name"];

include 'dbconnect.php';
$sql = "SELECT * FROM tbl_users WHERE username = '$name '";
  $select_stmt = $conn->prepare($sql);
  $select_stmt->execute();
  $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
  $user_id = $row["user_id"];

if (!isset($_SESSION['session_id'])) {
    echo "<script>alert('Session not available. Please login');</script>";
    echo "<script> window.location.replace('login.php')</script>";
}

if (isset($_POST['submit'])) {
    $operation = $_POST['submit'];
    $pid = $_POST['pid'];
    $project_title = addslashes($_POST['title']); 
    $project_requirement = addslashes($_POST['requirement']);
    $project_client = addslashes($_POST['client']);
    $project_description = addslashes($_POST['description']);
    $project_start = addslashes($_POST['start']);
    $project_end = addslashes($_POST['end']);
   $sqlupdateP = "UPDATE `tbl_projects` SET `project_title`=' $project_title',`project_requirement`='$project_requirement',
    `project_client`='$project_client',`project_description`='$project_description',`project_start`='$project_start',`project_end`='$project_end'
    WHERE project_id = '$pid'";
    try {
        $conn->exec($sqlupdateP);
        echo "<script>alert('Success')</script>";
        echo "<script>window.location.replace('manageproject.php')</script>";
    } catch (PDOException $e) {
       echo "<script>alert('Failed')</script>";
       echo "<script>window.location.replace('updateproject.php')</script>";
    }
}

if (isset($_GET['submit'])) {
    $operation = $_GET['submit'];
    if ($operation == 'details') {
        $pid = $_GET['pid'];
        $sqlupdateP = "SELECT * FROM tbl_projects WHERE project_id = '$pid'";
        $stmt = $conn->prepare($sqlupdateP);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        $number_of_rows = $stmt->rowCount();
        if ($number_of_rows > 0) {
            foreach ($rows as $projects) {
                $ptitle = $projects['project_title'];
                $prequirement = $projects['project_requirement'];
                $pclient = $projects['project_client'];
                $pdescription = $projects['project_description'];
                $pstart = $projects['project_start'];
                $pend = $projects['project_end'];
            }
        }else{
            echo "<script>alert('No project found')</script>";
            echo "<script>window.location.replace('manageproject.php')</script>";
        }
    }
}else{
   echo "<script>alert('Error')</script>";
   echo "<script>window.location.replace('manageproject.php')</script>";
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
            <h3>Update Project</h3>
        </div>
    </div>
    <div class="w3-bar w3-yellow">
        <a href="manageproject.php" class="w3-bar-item w3-button w3-right">Back</a>
    </div>
    <div class="w3-content w3-padding-32">
        <form class="w3-card w3-padding" action="updateproject.php" method="post" enctype="multipart/form-data" onsubmit="return confirm('Are you sure?')">
            <div class="w3-container w3-yellow">
                <h3>Project ID : <?php echo $pid ?> </h3>
            </div>
            <hr>
            <input type="hidden" name="pid" value="<?php echo $pid ?>">
            <div class="w3-row">
                <div class="w3-half" style="padding-right:4px">
                    <p>
                        <label><b>Project title</b></label>
                        <input class="w3-input w3-border w3-round " name="title" type="text" value="<?php echo $ptitle ?>" required>
                    </p>
                </div>
                <div class="w3-half" style="padding-right:4px">
                    <p>
                        <label><b>Project Client</b></label>
                        <?php if(substr($user_id, 0, 1) == "A") { ?>
                            <input class="w3-input w3-border w3-round"  name="client" type="text" value="<?php echo $pclient ?>" required>
                        <?php } elseif(substr($user_id, 0, 1) == "C") { ?>
                            <input class="w3-input w3-border w3-round" name="client" type="text" value="<?php echo $pclient; ?>" readonly>
                        <?php } ?>
                    </p>
                </div>
            </div>
            <div class="w3-row">
                <div class="w3-full" style="padding-right:4px">
                 <p>
                    <label><b>Project Requirement</b></label>
                    <textarea class="w3-input w3-border w3-round" rows="4" width="100%" name="requirement" required><?php echo $prequirement ?></textarea>
                </p>
                </div>
            </div>
            <div class="w3-row">
                <div class="w3-full" style="padding-right:4px">
                    <p>
                        <label><b>Project Description</b></label>
                        <textarea class="w3-input w3-border w3-round" rows="4" width="100%" name="description" required><?php echo $pdescription ?></textarea>
                    </p>
                </div>
                <div class="w3-half" style="padding-right:4px">
                    <p>
                        <label><b>Date of Start</b></label>
                        <input class="w3-input w3-border w3-round" name="start" type="date" value="<?php echo $pstart ?>" required>
                    </p>
                </div>
                <div class="w3-half" style="padding-right:4px">
                         <p>
                            <label><b>Date of End</b> </label>
                            <input class="w3-input w3-border w3-round" name="end" type="date" value="<?php echo $pend ?>" required>
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