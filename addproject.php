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
  include_once("dbconnect.php");
  $project_id = rand(10000, 99999);
  $project_title = addslashes($_POST['title']); 
  $project_requirement = addslashes($_POST['requirement']);
  $project_client = addslashes($_POST['client']);
  $project_description = addslashes($_POST['description']);
  $project_start = addslashes($_POST['start']);
  $project_end = addslashes($_POST['end']);
  echo $sqladdproject = "INSERT INTO `tbl_projects`(`project_id`, `project_title`, `project_requirement`, `project_client`, `project_description`, `project_start`, `project_end`) 
  VALUES ('$project_id','$project_title','$project_requirement','$project_client','$project_description','$project_start','$project_end')";
  

  try {
    $conn->exec($sqladdproject);
        echo "<script>alert('Success')</script>";
        echo "<script>window.location.replace('manageproject.php')</script>";
} catch (PDOException $e) {
    echo "<script>alert('Failed')</script>";
    echo "<script>window.location.replace('addproject.php')</script>";
}
      
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
  <body>
  <div class="w3-bar w3-grey">
        <a href="manageproject.php" class="w3-bar-item w3-button w3-right">Back</a>
    </div>
    <div class="w3-content w3-padding-32">
        <form class="w3-card w3-padding" action="addproject.php" method="post" enctype="multipart/form-data" onsubmit="return confirm('Are you sure?')">
        <h1>Add New Project</h1>   
	    <form>
        <div class="w3-row">
          <div class="w3-half" style="padding-right:4px">
            <p>
              <label>
                <b>Project Title</b>
              </label>
              <input class="w3-input w3-border w3-round" name="title" type="text" required>
            </p>
          </div>
          <div class="w3-half" style="padding-right:4px">
            <p>
                <label><b>Project Client</b></label>
                <?php if(substr($user_id, 0, 1) == "A") { ?>
                    <input class="w3-input w3-border w3-round" name="client" type="text" required>
                <?php } elseif(substr($user_id, 0, 1) == "C") { ?>
                    <input class="w3-input w3-border w3-round" name="client" type="text" value="<?php echo $name; ?>" readonly>
                <?php } ?>
            </p>
        </div>
          <div class="w3-full" style="padding-right:4px">
            <p>
              <label>
                <b>Project Requirement</b>
              </label>
              <textarea class="w3-input w3-border w3-round" rows="4" width="100%" name="requirement" type="text" required></textarea>
            </p>
          </div>
        </div>
        <div class="w3-row">
          <div class="w3-full" style="padding-right:4px">
            <p>
              <label>
                <b>Project Description</b>
              </label>
              <textarea class="w3-input w3-border w3-round" rows="4" width="100%" name="description" type="text" required></textarea>
            </p>
          </div>
        </div> 
        <div>
          <div class="w3-half" style="padding-right:4px">
            <p>
              <label>
                <b>Date of Start</b>
              </label>
              <input class="w3-input w3-border w3-round" name="start" type="date" required>
            </p>
          </div>
          <div class="w3-half" style="padding-right:4px">
            <p>
              <label>
                <b>Date of End</b>
              </label>
              <input class="w3-input w3-border w3-round" name="end" type="date" required>
            </p>
          </div>
        </div>
          <div class="w3-row">
            <div class="w3-half" style="padding-right:4px">
                <p>
                    <input class="w3-button w3-blue w3-round w3-block w3-border" type="submit" name="submit" value="Submit">
                </p>
            </div>
         </div>
      </form>
    </div>
    </div>
    <div class="w3-center w3-bottom w3-grey">FPMS</div>
  </body>
</html>