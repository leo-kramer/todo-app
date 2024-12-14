<?php
function sort_tasks_by_status($tasks)
{
  $not_started = [];
  $in_progress = [];
  $done = [];
  $on_hold = [];
  $unsorted = [];

  if (!empty($tasks)) {
    foreach ($tasks as $index => $task) {
      $name = $task[0];
      $status = $task[1];
      $priority = $task[2];

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
