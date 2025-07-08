<?php
$tasksPath = '../json/tasks.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv_file'])) {
    $file = $_FILES['csv_file']['tmp_name'];
    $rows = array_map('str_getcsv', file($file));
    $tasks = [];

    foreach ($rows as $row) {
        if (count($row) >= 2) {
            $tasks[] = [
                'task_name' => trim($row[0]),
                'points' => (int) trim($row[1])
            ];
        }
    }

    file_put_contents($tasksPath, json_encode(['tasks' => $tasks], JSON_PRETTY_PRINT));
    header('Location: mark_task_completion.php');
    exit;
}
?>
