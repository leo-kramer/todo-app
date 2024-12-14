<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Get POST request data
  $input = json_decode(file_get_contents("php://input"), true);
  $task_index = $input["index"];
  $newStatus = $input["status"];
  $tasks = json_decode(file_get_contents("tasks.json"), true);

  $logs = []; // Store logs to be outputted in script.js
  $found_task = false;

  foreach ($tasks as $index => &$task) {
    if ($index == $task_index) {
      $task[1] = $newStatus;

      $logs[] = "Task $task_index status updated to $newStatus.";
      $found_task = true;
      break;
    }
  }

  if (!$found_task) {
    $logs[] = "Failed to find task with index: $task_index.";
  }

  file_put_contents("tasks.json", json_encode($tasks));
  $logs[] = "Updated changes made to tasks.";

  print_r($logs);
}
