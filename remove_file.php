<?php
include_once("dbconnect.php");

if (isset($_GET['task_id'])) {
  $task_id = $_GET['task_id'];
  $target_file = "../task/" . $task_id . ".pdf";
  $status = 'Not Submitted';
  
  if (unlink($target_file)) {
    $sql = "UPDATE tbl_dashboard SET submission_date = NULL , `status` = '$status' WHERE task_id = '$task_id'";
    $conn->exec( $sql);
    echo 'File removed successfully.';
  } else {
    echo 'Failed to remove file.';
  }
}
?>
