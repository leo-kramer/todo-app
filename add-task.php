<?php
$task = '';
$task_err = 'New task';

if (isset($_POST["submit"])) {
  // Validate form input
  if (empty($_POST['task'])) {
    $task_err = 'Write down a task';
  } else {
    $task = filter_input(INPUT_POST, 'task', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $status = $_POST["status"];
    $priority = $_POST["priority"];
  }

  if (!empty($task_err)) {
    $sql = "INSERT INTO tasks (name, status, priority) VALUES ('$task', '$status', '$priority')";

    if (mysqli_query($conn, $sql)) {
      // Succesfully created task
      header("Location: " . htmlspecialchars($_SERVER["PHP_SELF"]));
    } else {
      echo "Error: mysqli_error($conn)";
    }
  }
}
