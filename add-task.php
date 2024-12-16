<?php
if (isset($_POST["submit"])) {
  $task = $_POST["task"];
  $status = $_POST["status"];
  $priority = $_POST["priority"];

  $result = mysqli_query($conn, 'SELECT * FROM tasks');
  $data = mysqli_fetch_all($result, MYSQLI_ASSOC); // Transform object data to an associative array

  $new_data = array("name" => $task, "status" => $status, "priority" => $priority);

  if (!empty($data)) {
    $data[] = $new_data; // Append new data to the existing data
  } else {
    $data = array($new_data);
  }

  file_put_contents("tasks.json", json_encode($data));
  header("Location: " . htmlspecialchars($_SERVER["PHP_SELF"]));
}
