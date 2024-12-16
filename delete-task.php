<?php include "config/database.php" ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
  // Get DELETE request data
  $input = json_decode(file_get_contents("php://input"), true);
  $index = $input["index"];

  $logs = []; // Store logs to be outputted in script.js

  $sql = "DELETE FROM tasks WHERE id = $index";

  if (mysqli_query($conn, $sql)) {
    // Succesfully created task
    $logs[] = "Task $index deleted.";
  } else {
    $logs[] = "Error: mysqli_error($conn)";
  }

  print_r($logs);
}
