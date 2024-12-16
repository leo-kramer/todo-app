<?php include "config/database.php" ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $input = json_decode(file_get_contents("php://input"), true);
  $task_index = $input["index"];
  // Check if status or priority is being updated, save that value
  $updateValue = isset($input["status"]) ?  $input["status"] : $input["priority"];
  $updateKey = isset($input["status"]) ? "status" : "priority";
  $tasks = json_decode(file_get_contents("tasks.json"), true);

  $logs = []; // Store logs to be outputted in script.js
  $found_task = false;
  $logs[] = "test";

  if (!$updateValue || !$updateKey) {
    $logs[] = "Invalid value: $updateValue OR key: $updateKey.";
  }

  $sql = "UPDATE tasks SET $updateKey = '$updateValue' WHERE id = $task_index";

  if (mysqli_query($conn, $sql)) {
    // Succesfully created task
    $logs[] = "Task $task_index $updateKey updated to $updateValue.";
  } else {
    $logs[] = "Error: mysqli_error($conn)";
  }

  print_r($logs);
}
