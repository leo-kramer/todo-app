<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My To Do List</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <h1>My To Do List</h1>

  <!-- Kanban board -->
  <ul>
    <?php include 'sort-tasks.php';
    $tasks = json_decode(file_get_contents("tasks.json"));
    $sorted_tasks = sort_tasks_by_status($tasks);

    foreach ($sorted_tasks as $status => $status_tasks) {
      if ($status === "unsorted" && empty($status_tasks)) {
        echo "";
        break;
      }

      $status_heading = ucfirst(str_replace("_", " ", $status));

      echo "<li><h2>$status_heading</h2><ul>";

      if (!empty($status_tasks)) {
        foreach ($status_tasks as $index => $task) {
          $name = $task['name'];
          $priority = $task['priority'];
          echo "<li>
            <p>$name</p>
            <p>$priority</p>
            <button onclick='deleteTask($index)'>Delete task</button>
          </li>";
        }
      }

      echo "<li>
          <form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>
            <input type='text' name='task' placeholder='New task' required>
            <input type='hidden' name='status' value='$status'>

            <label for='priority'>Priority: </label>
            <select name='priority' required>
              <option value='Immediate'>Immediate</option>
              <option value='High'>High</option>
              <option value='Normal' selected>Normal</option> <!-- Default option -->
              <option value='Low'>Low</option>
            </select>

            <input type='submit' name='submit' value='Add task'>
          </form>
        </li>
      </ul>
    </li>";
    }
    ?>
  </ul>
  <script src="assets/scripts/script.js"></script>
  <?php include 'add-task.php' ?>
  <?php include 'delete-task.php' ?>
</body>

</html>