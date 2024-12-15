<?php include 'add-task.php' ?>
<?php include 'delete-task.php' ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
  <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <title>My To Do List</title>

</head>

<body class="bg-dark text-bg-dark">
  <h1 class="text-center mt-5">My to-do list</h1>

  <!-- Kanban board -->
  <main class="d-lg-flex justify-content-around m-5">
    <?php include 'sort-tasks.php';
    $tasks = json_decode(file_get_contents("tasks.json"), true);
    $sorted_tasks = sort_tasks_by_status($tasks);

    // Print HTML for each status
    foreach ($sorted_tasks as $status => $status_tasks) {
      // Only show unsorted if a task accidentally lost its status value
      if ($status === "unsorted" && empty($status_tasks)) {
        echo "";
        break;
      }

      $status_heading = ucfirst(str_replace("_", " ", $status));

      // HTML
      echo "<section data-status='$status'>
        <h2>$status_heading</h2>
        <ul class='list-group my-3'>"; // Update status: store status name data for drag and drop

      // Tasks
      if (!empty($status_tasks)) {
        foreach ($status_tasks as $task) {
          $index = $task['index'];
          $name = $task['name'];
          $priority = $task['priority'];

          // Update status: store task index data for drag and drop
          echo "<li class='d-flex list-group-item my-1' draggable='true' data-index='$index'>
            <div class='container'>
              <p class=>$name</p>
              <div class='dropdown'>
                <button class='btn btn-secondary ' type='button' data-bs-toggle='dropdown' aria-expanded='false'>
                  $priority
                </button>
                <ul class='dropdown-menu'>
                  <li><a class='dropdown-item' href='#'>Immediate</a></li>
                  <li><a class='dropdown-item' href='#'>High</a></li>
                  <li><a class='dropdown-item' href='#'>Normal</a></li>
                  <li><a class='dropdown-item' href='#'>Low</a></li>
                </ul>
              </div>
            </div>
            <button onclick='deleteTask($index)'>
            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'>
              <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z'/>
              <path d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z'/>
            </svg>
            </button>
          </li>";
        }
      }

      // Create a task
      echo "</ul>
        <form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>
          <button type='submit' name='submit'>
          <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-plus' viewBox='0 0 16 16'>
            <path d='M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4'/>
          </svg>
          </button>

          <input type='text' name='task' placeholder='New task' required>
          <input type='hidden' name='status' value='$status'>

          <label for='priority'>Priority: </label>
          <select name='priority' required>
            <option value='Immediate'>Immediate</option>
            <option value='High'>High</option>
            <option value='Normal' selected>Normal</option> <!-- Default option -->
            <option value='Low'>Low</option>
          </select>
        </form>
      </section>";
    }
    ?>
  </main>

  <script src="assets/scripts/script.js"></script>
</body>

</html>