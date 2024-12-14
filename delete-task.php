<?php
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
  // Get DELETE request data
  $input = json_decode(file_get_contents("php://input"), true);
  $index = $input["index"];

  $tasks = json_decode(file_get_contents("tasks.json"));

  // Delete entry
  unset($tasks[$index]);
  if (!empty($tasks)) {
    // Re-index tasks to avoid numerical gaps
    $tasks = array_values($tasks);
  } else {
    echo "No more tasks available.";
    $tasks = [];
  }
  // Update JSON file
  file_put_contents("tasks.json", json_encode($tasks));
}
