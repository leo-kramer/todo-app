<?php
function sort_tasks_by_status($tasks)
{
  // Initialise status categories
  $not_started = [];
  $in_progress = [];
  $done = [];
  $on_hold = [];
  $unsorted = [];

  if (!empty($tasks)) {
    foreach ($tasks as $index => $task) {
      $name = $task["name"];
      $status = $task["status"];
      $priority = $task["priority"];

      // Append task data according to matching status
      switch ($status) {
        case "not_started":
          $not_started[] = ['index' => $index, 'name' => $name, 'status' => $status, 'priority' => $priority];
          break;
        case "in_progress":
          $in_progress[] = ['index' => $index, 'name' => $name, 'status' => $status, 'priority' => $priority];
          break;
        case "done":
          $done[] = ['index' => $index, 'name' => $name, 'status' => $status, 'priority' => $priority];
          break;
        case "on_hold":
          $on_hold[] = ['index' => $index, 'name' => $name, 'status' => $status, 'priority' => $priority];
          break;
          // Handle tasks that have an invalid status
        default:
          $unsorted[] = ['index' => $index, 'name' => $name, 'status' => $status, 'priority' => $priority];
          break;
      }
    }
  }

  return [
    'not_started' => $not_started,
    'in_progress' => $in_progress,
    'done' => $done,
    'on_hold' => $on_hold,
    'unsorted' => $unsorted
  ];
}
