<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $task = $_POST["task"];
  $new_data = array($task);
  $data = json_decode(file_get_contents("tasks.json"));

  if (!empty($data)) {
    $data[] = $new_data; // Append new data to the existing data
  } else {
    $data = array($new_data);
  }

  file_put_contents("tasks.json", json_encode($data));

  echo "<br />";
  echo "$task has been saved.";
}
