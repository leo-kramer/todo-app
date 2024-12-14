<?php
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
  // Get DELETE request data
  $input = json_decode(file_get_contents("php://input"), true);
  $index = $input["index"];
  $tasks = json_decode(file_get_contents("tasks.json"), true);

  $logs = []; // Store logs to be outputted in script.js

  if (isset($tasks[$index])) {
    $logs[] = "Task found with index: $index.";

    // Delete entry
    unset($tasks[$index]);
    $logs[] = "Task deleted.";

    if (!empty($tasks)) {
      // Re-index tasks to avoid numerical gaps
      $tasks = array_values($tasks);
      $logs[] = "Reordered tasks array.";
    } else {
      $tasks = [];
      $logs[] = "No more tasks available, providing empty array.";
    }
    // Update JSON file
    file_put_contents("tasks.json", json_encode($tasks));
    $logs[] = "Updated tasks array saved.";
  } else {
    $logs[] = "Invalid task index: $index.";
  }

  print_r($logs);
}
