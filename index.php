<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My To Do List</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <!-- Task list -->
  <ul>
    <?php
    $tasks = json_decode(file_get_contents("tasks.json"));

    if (empty($tasks)) {
      echo "Start writing down a task!";
    } else {
      foreach ($tasks as $index => $task)
        echo "<li>
          <p>$task[0]</p>      
          <button onclick='deleteTask($index)'>Delete task</button>
        </li>";
    }
    ?>
    <li>
      <form method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="text" name="task"></input>
        <input type="submit" name="submit" value="Add task"></input>
      </form>
    </li>
  </ul>
  <script src="assets/scripts/script.js"></script>
  <?php include 'add-task.php' ?>
  <?php include 'delete-task.php' ?>
</body>

</html>