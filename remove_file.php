<?php
if (isset($_GET['task_id'])) {
  $task_id = $_GET['task_id'];
  $target_file = "../task/" . $task_id . ".pdf";
  
  if (unlink($target_file)) {
    
    echo 'File removed successfully.';
  } else {
    echo 'Failed to remove file.';
  }
}
?>
