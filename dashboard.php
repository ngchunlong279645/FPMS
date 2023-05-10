<?php
session_start();
$name = $_SESSION["name"];

include_once("dbconnect.php");
$sqluser = "SELECT * FROM tbl_users WHERE username = '$name '";
  $select_stmt = $conn->prepare($sqluser);
  $select_stmt->execute();
  $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
  $user_id = $row["user_id"];



if (!isset($_SESSION['session_id'])) {
    echo "<script>alert('Session not available. Please login');</script>";
    echo "<script> window.location.replace('login.php')</script>";
}

if (substr($user_id, 0, 1) == "S") {
    $sql = "SELECT * FROM tbl_student WHERE std_name = '$name'";
    $select_stmt = $conn->prepare($sql);
    $select_stmt->execute();
    $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
    $std_matric = $row["std_matric"];
}  else {
    $id = $_GET['id'];
    $std_matric = $id;
    $sqlstudent = "SELECT * FROM tbl_student WHERE std_matric = '$id'";
    $stmt = $conn->prepare($sqlstudent);
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $rows = $stmt->fetchAll();
}

if (isset($_GET['submit'])) {
    $operation = $_GET['submit'];
    if ($operation == 'delete') {
        $task_id = $_GET['task_id'];
        $sqldeletetask = "DELETE FROM `tbl_dashboard` WHERE task_id = '$task_id'";
        
    }
    try {
        $conn->exec($sqldeletetask);
        echo "<script>alert('Task deleted')</script>";
        echo "<script>window.location.replace('dashboard.php?id='.$id')</script>";
        } catch (PDOException $e){
            echo "<script>alert('Failed')</script>";
           echo "<script>window.location.replace('dashboard.php?id='.$id')</script>";
        
      }
} 





$results_per_page = 20;
if (isset($_GET['pageno'])) {
     $pageno = (int)$_GET['pageno'];
    $page_first_result = ($pageno - 1) * $results_per_page;
} else {
     $pageno = 1;
    $page_first_result = 0;
}

$sql = "SELECT * FROM tbl_dashboard WHERE std_id = '$std_matric '";
$stmt = $conn->prepare($sql);
$stmt->execute();
$number_of_result = $stmt->rowCount();
$number_of_page = ceil($number_of_result / $results_per_page);
$sql = $sql. " LIMIT $page_first_result , $results_per_page";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$rows = $stmt->fetchAll();



if (isset($_POST['submit'])) {
  $task_id = $_GET['task_id'];
  $now = date("Y-m-d H:i:s");
  $status = 'Submitted';
  $sql = "UPDATE tbl_dashboard SET submission_date = '$now' , `status` = '$status' WHERE task_id = '$task_id'";
  try {
   $conn->exec( $sql);
    if (file_exists($_FILES["fileToUpload"]["tmp_name"]) || is_uploaded_file($_FILES["fileToUpload"]["tmp_name"])) {
      // Call the uploadImage function here
      saveUpload($task_id);
      // Update submission_time in the database
      echo "<script>alert('File uploaded successfully.')</script>";
      echo "<script>window.location.replace('dashboard.php')</script>";
    } else {
      echo "<script>alert('Please select a file to upload.')</script>";
      echo "<script>window.location.replace('dashboard.php')</script>";
    }
  } catch (PDOException $e) {
  echo "<script>alert('Failed to upload file.')</script>";
  echo "<script>window.location.replace('dashboard.php')</script>";
  }
}


  if (isset($_POST['edit'])) {
    $task_id = $_POST['task_id'];
    try {
      if (file_exists($_FILES["fileToUpload"]["tmp_name"]) || is_uploaded_file($_FILES["fileToUpload"]["tmp_name"])) {
        // Call the uploadImage function here
        saveUpload($task_id);
        echo "<script>alert('File edit successfully.')</script>";
        echo "<script>window.location.replace('dashboard.php')</script>";
      } else {
        echo "<script>alert('Please select a file to upload.')</script>";
        echo "<script>window.location.replace('dashboard.php')</script>";
      }
    } catch (PDOException $e) {
      echo "<script>alert('Failed to edit file.')</script>";
      echo "<script>window.location.replace('dashboard.php')</script>";
    }
  }
  

  

function saveUpload($task_id)
{
    $target_dir = "../task/";
    $target_file = $target_dir . $task_id . ".pdf";
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
}

  
  

?>



<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
    body {
    margin: 0;
    font-family: Arial, sans-serif;
    }

    header {
        background-color: #333;
        color: #fff;
        padding: 35px;
    }

    header h1 {
        margin: 0;
        font-size: 36px;
    }

    header p {
        margin: 0;
        font-size: 18px;
    }

    main {
        max-width: 950px;
        margin: 0 auto;
        padding: 20px;
    }

    
    ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    li {
        margin-bottom: 5px;
    }

    label {
        font-size: 18px;
        display: block;
        margin-bottom: 10px;
    }

    input[type=file] {
        display: block;
        margin-bottom: 10px;
    }


    #remove-btn {
        background-color: #f44336;
        margin-left: 10px;
    }

    footer {
        background-color: #f2f2f2;
        padding: 10px;
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

    .add-task-button {
        background-color: #4CAF50;
        border: none;
        color: white;
        padding: 12px 30px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
    }

    .add-btn {
      background-color: green;
      color: white;
      padding: 10px 20px;
      border-radius: 5px;
      text-decoration: none;
      cursor: pointer;
    }

    .popup-page {
      display: none;
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 1;
    }

    .popup-page-content {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background-color: white;
      padding: 20px;
      border-radius: 5px;
    }

    .close-popup-page {
      position: absolute;
      top: 10px;
      right: 10px;
      font-size: 18px;
      cursor: pointer;
    }

    .edit-popup-page {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  z-index: 9999;
}

.edit-popup-page-content {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background-color: #fff;
  padding: 20px;
  border-radius: 5px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
}

.close-edit-popup-page {
  position: absolute;
  top: 10px;
  right: 10px;
  font-size: 24px;
  font-weight: bold;
  cursor: pointer;
}


    .left-align-form {
        text-align: left;
    }
    .left-align-form input[type="submit"] {
        float: right;
    }
    
    


</style>
<body>
    <header>
    <a href="<?php 
    if(substr($user_id, 0, 1) == "L") { 
        echo "studentprofile.php?id=$id"; 
    } else if(substr($user_id, 0, 1) == "C") {
        echo "studentprofile.php?id=$id";
    } else {
        echo 'student.php'; 
    } ?>" class="button w3-right back-button">Back</a>

        <h1>Dashboard</h1>
       
    </header>
    <main>
    <?php 
       if(substr($user_id, 0, 1) == "L") { 
        echo '<a href="add_task.php?id='.$id.'" class="button w3-right add-task-button">Add Task</a>'; 
    }
    
    
    
    
        ?>
        <section id="progress">
            <h2>Progress Status</h2>
            <p>Your current progress: 0%</p>
        </section>
        <section id="tasks">
            <div class="w3-margin w3-border" style="overflow-x:auto;">
            <?php
                $i = 0;
                echo "<table class='w3-table w3-striped w3-bordered' style='width:100%'>
                    <tr><th style='width:5%'>No</th><th style='width:20%'>Task </th><th style='width:20%'>Due date</th><th style='width:30%'>Submission date</th>";
                    
                    if(substr($user_id, 0, 1) == "S") { 
                      echo "<th style='width:10%'>Upload</th>";
                  }
                    echo "<th style='width:10%'>Status</th><th style='width:10%'>Grade</th>";
                   
                if(substr($user_id, 0, 1) == "L") { 
                    echo " <th style='width:10%'>Download</th><th style='width:5%'>Operations</th>";
                }
                echo "</tr>";
                foreach ($rows as $dashboard) {
                  $i++;
                  $task_id = $dashboard['task_id'];
                  $task_name = $dashboard['task_name'];
                  $due_date = $dashboard['due_date'];
                  $submission_date = $dashboard['submission_date'];
                                
                  $target_dir = "../task/";
                  $file_path = $target_dir . $task_id . ".pdf";
                  $has_file = file_exists($file_path);
                               
                  $grade = $dashboard['grade'];
                  $status = $dashboard['status'];
                 
                  if(substr($user_id, 0, 1) == "L") {             
                    if ($has_file) {
                      $download = "<a href='$file_path'>Download</a>";  
                    } else {
                      $download = "<a href='#'>Download</a>";  
                    }
                  }
                  
                  echo "<tr><td>$i</td><td>$task_name</td><td>$due_date</td><td>$submission_date</td>";
                  if(substr($user_id, 0, 1) == "S") {               
                  if ($has_file) {
                    echo "<td>
                            <a href='$file_path' target='_blank' class='view-btn w3-bar-item w3-button w3-right'>View</a>
                            <a href='#' class='edit-btn w3-bar-item w3-button w3-right' data-taskid='$task_id'>Edit</a>
                          </td>";
                } else {
                    echo "<td>
                            <a href='#' class='add-btn w3-bar-item w3-button w3-right' data-taskid='$task_id'>Upload</a>
                          </td>";
                }
              }
                
                              
                  echo"<td> $status</td><td> $grade</td>";
                  if(substr($user_id, 0, 1) == "L") { 
                   echo "<td> $download</td>";
                  }
                  if(substr($user_id, 0, 1) == "L") { 
                    echo "<td><button class='btn'><a href='dashboard.php?submit=delete&id=$id&task_id=$task_id' class='fa fa-trash' onclick=\"return confirm('Are you sure?')\"></a></button>
                    <button class='btn'><a href='edit_task.php?submit=details&id=$id&task_id=$task_id' class='fa fa-edit'></a></button></td>";
                  }
                  echo "</tr>";
                }
                
                  
                echo "</table>";
            ?>

            </div>
        </section>
    </main>
</body>

<div class="popup-page">
  <div class="popup-page-content">
    <span class="close-popup-page">&times;</span>
    <form action="dashboard.php?task_id=<?php echo $task_id; ?>" method="POST" class="left-align-form" enctype="multipart/form-data">
      <h3>Upload file</h3>
      <input type="file" name="fileToUpload" id="fileToUpload">
      <input type="submit" name="submit" value="Submit">
    </form>
  </div>
</div>

<div class="edit-popup-page">
  <div class="edit-popup-page-content">
    <span class="close-edit-popup-page">&times;</span>
    <form action="dashboard.php?task_id=<?php echo $task_id; ?>" method="POST" class="left-align-form" enctype="multipart/form-data">
      <h3>Edit file</h3>
      <div id="edit-file-container">
      </div>
      <input type="file" name="fileToUpload" id="fileToUpload">
      <input type="hidden" name="task_id" value="" id="edit-task-id">
      <input type="submit" name="edit" value="Update">
      <input type="button" name="remove" value="Remove" id="remove-file-btn">

    </form>
  </div>
</div>


<script>
const addBtns = document.querySelectorAll('.add-btn');
const popupPage = document.querySelector('.popup-page');
const closePopupPage = document.querySelector('.close-popup-page');
const editBtns = document.querySelectorAll('.edit-btn');
const editPopupPage = document.querySelector('.edit-popup-page');
const removeFileBtn = document.querySelector('#remove-file-btn');
const closeEditPopupPage = document.querySelector('.close-edit-popup-page');
const form = document.querySelector('.left-align-form');
const fileInput = document.querySelector('#fileToUpload');

addBtns.forEach(addBtn => {
  addBtn.addEventListener('click', function(event) {
    event.preventDefault();
    const task_id = this.getAttribute('data-taskid');
    form.action = `dashboard.php?task_id=${task_id}`;
    fileInput.value = '';
    popupPage.style.display = 'block';
  });
});



closePopupPage.addEventListener('click', function() {
  popupPage.style.display = 'none';
});

editBtns.forEach(editBtn => {
  editBtn.addEventListener('click', function(event) {
    event.preventDefault();
    const task_id = this.getAttribute('data-taskid');
    form.action = `edit_task.php?task_id=${task_id}`;
    fileInput.value = '';
    editPopupPage.style.display = 'block';
  });
});

closeEditPopupPage.addEventListener('click', function() {
  editPopupPage.style.display = 'none';
});

$(document).ready(function() {
  $('.edit-btn').click(function(e) {
    e.preventDefault();
    var task_id = $(this).data('taskid');
    $('#edit-task-id').val(task_id);
    $('.edit-popup-page').css('display', 'block');
  });
});

removeFileBtn.addEventListener('click', function(event) {
  event.preventDefault();
  const task_id = document.querySelector('#edit-task-id').value;
  if (confirm('Are you sure you want to remove the file?')) {
    // Call a PHP script that removes the file from the server
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4) {
        if (xhr.status === 200) {
          alert('File removed successfully.');
          location.reload(); // Refresh the page to update the UI
        } else {
          alert('Failed to remove file.');
        }
      }
    }
    xhr.open('GET', `remove_file.php?task_id=${task_id}`, true);
    xhr.send();
  }
});








</script>



</html>

