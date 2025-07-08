<?php
$tasksPath = '../json/tasks.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv_file'])) {
    $file = $_FILES['csv_file']['tmp_name'];

    if (!file_exists($file) || filesize($file) === 0) {
        die('CSV file is empty.');
    }

    $rows = array_map('str_getcsv', file($file));
    $newTasks = [];

    foreach ($rows as $row) {
        if (count($row) >= 2 && is_numeric($row[1])) {
            $newTasks[] = [
                'task_name' => trim($row[0]),
                'points' => (int) trim($row[1])
            ];
        }
    }

    // Load existing tasks
    $existingData = file_exists($tasksPath) ? json_decode(file_get_contents($tasksPath), true) : [];
    $existingTasks = $existingData['tasks'] ?? [];

    // Append new tasks to existing ones
    $taskNames = array_column($existingTasks, 'task_name');

    foreach ($newTasks as $task) {
        if (!in_array($task['task_name'], $taskNames)) {
            $existingTasks[] = $task;
        }
    }

    $allTasks = $existingTasks;

    // Save back to file
    file_put_contents($tasksPath, json_encode(['tasks' => $allTasks], JSON_PRETTY_PRINT));

    header('Location: ../pages/mark_task_completion.php');
    exit;
}
