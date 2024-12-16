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
    foreach ($tasks as $task) {
      $index = ($task["id"]);
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

  // Sort task by priority before returning
  $not_started = sort_tasks_by_priority($not_started);
  $in_progress = sort_tasks_by_priority($in_progress);
  $done = sort_tasks_by_priority($done);
  $on_hold = sort_tasks_by_priority($on_hold);
  $unsorted = sort_tasks_by_priority($unsorted);

  return [
    'not_started' => $not_started,
    'in_progress' => $in_progress,
    'done' => $done,
    'on_hold' => $on_hold,
    'unsorted' => $unsorted
  ];
};

function sort_tasks_by_priority($tasks)
{
  $priority_order = array("Immediate" => 1, "High" => 2, "Normal" => 3, "Low" => 4);

  $sort = function ($a, $b) use ($priority_order) {
    return $priority_order[$a["priority"]] <=> $priority_order[$b["priority"]];
  };

  usort($tasks, $sort);
  return $tasks;
}
