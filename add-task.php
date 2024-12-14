<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $task = $_POST["task"];
  $status = $_POST["status"];
  $priority = $_POST["priority"];
  $data = json_decode(file_get_contents("tasks.json"), true);

  $new_data = array("name" => $task, "status" => $status, "priority" => $priority);

  if (!empty($data)) {
    $data[] = $new_data; // Append new data to the existing data
  } else {
    $data = array($new_data);
  }

  file_put_contents("tasks.json", json_encode($data));
  header("Location: " . htmlspecialchars($_SERVER["PHP_SELF"]));
}
