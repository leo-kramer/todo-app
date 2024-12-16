<?php include "config/database.php" ?>
<?php include "add-task.php" ?>
<?php include "sort-tasks.php";
// $tasks = json_decode(file_get_contents("tasks.json"), true);
// $sorted_tasks = sort_tasks_by_status($tasks);

$result = mysqli_query($conn, 'SELECT * FROM tasks');
$tasks = mysqli_fetch_all($result, MYSQLI_ASSOC); // Transform object data to an associative array
$sorted_tasks = sort_tasks_by_status($tasks);
?>

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
  <?php if (!empty($sorted_tasks)): ?>
    <h1 class="text-center mt-5">My to-do list</h1>

    <!-- Kanban board -->
    <main class="d-lg-flex justify-content-around m-5">
      <!-- Print HTML for each status -->
      <?php foreach ($sorted_tasks as $status => $status_tasks): ?>
        <?php
        // Only show unsorted if a task accidentally lost its status value
        if ($status === "unsorted" && empty($status_tasks)) {
          break;
        }
        // Format status value for heading
        $status_heading = ucfirst(str_replace("_", " ", $status));
        ?>

        <section data-status="<?= $status ?>"> <!-- Store status name data for drag and drop -->
          <h2 class="h3"><?= $status_heading ?></h2>

          <ul class="list-group my-3">
            <?php if (!empty($status_tasks)): ?>
              <?php foreach ($status_tasks as $task): ?>
                <li class="d-flex list-group-item my-1 p-2 rounded" draggable="true" data-index="<?= $task['index'] ?>"> <!-- Store task index data for drag and drop -->
                  <div class="container">
                    <p class="lead mb-2"><?= $task['name'] ?></p>
                    <div class="dropdown">
                      <button class="btn btn-secondary btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?= $task['priority'] ?>
                      </button>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Immediate</a></li>
                        <li><a class="dropdown-item" href="#">High</a></li>
                        <li><a class="dropdown-item" href="#">Normal</a></li>
                        <li><a class="dropdown-item" href="#">Low</a></li>
                      </ul>
                    </div>
                  </div>
                  <button class="btn p-2" onclick="deleteTask(<?= $task['index'] ?>)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                      <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                      <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                    </svg>
                  </button>
                </li>
              <?php endforeach; ?>
            <?php endif; ?>
          </ul>


          <!-- // Create a task -->
          <form class="d-flex flex-column justify-content-center" method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
            <div class="d-flex mb-2 p-2 rounded">
              <button class="btn text-bg-dark p-0 d-flex align-items-center" type="submit" name="submit">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                  <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                </svg>
              </button>

              <input class="form-control  flex-fill  d-flex flex-column bg-dark
              <?= $task_err !== "New task" ? "is-invalid" : null ?>"
                type="text" name="task" placeholder="<?= $task_err ?>">
            </div>

            <input type="hidden" name="status" value="<?= $status ?>">
            <div class="btn-group">
              <select class="form-select-sm dropdown-toggle" name="priority" required>
                <option value="Immediate">Immediate</option>
                <option value="High">High</option>
                <option value="Normal" selected>Normal</option>
                <option value="Low">Low</option>
              </select>
            </div>
          </form>
        </section>
      <?php endforeach; ?>
    <?php else: ?>
      <h1 class="text-center mt-5">Please log in or create an account</h1>
      <p class="text-center lead mt-3">That is if such a feature was coded in. Oops!</p>
    <?php endif; ?>

    </main>
    <script src="assets/scripts/script.js"></script>
</body>

</html>