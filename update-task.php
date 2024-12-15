<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Get POST request data
  $input = json_decode(file_get_contents("php://input"), true);
  $task_index = $input["index"];
  // Check if status or priority is being updated, save that value
  $updateValue = isset($input["status"]) ?  $input["status"] : $input["priority"];
  $updateKey = isset($input["status"]) ? "status" : "priority";
  $tasks = json_decode(file_get_contents("tasks.json"), true);

  $logs = []; // Store logs to be outputted in script.js
  $found_task = false;

  if (!$updateValue || !$updateKey) {
    $logs[] = "Invalid value: $updateValue OR key: $updateKey.";
  }

  foreach ($tasks as $index => &$task) {
    if ($index == $task_index) {
      $task[$updateKey] = $updateValue;

      $logs[] = "Task $task_index $updateKey updated to $updateValue.";
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
