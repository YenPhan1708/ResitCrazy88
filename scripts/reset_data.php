<?php
$dataPath = '../json/data.json';
$tasksPath = '../json/tasks.json';

// Clear group data
file_put_contents($dataPath, json_encode(['groups' => []], JSON_PRETTY_PRINT));

// Clear tasks
file_put_contents($tasksPath, json_encode(['tasks' => []], JSON_PRETTY_PRINT));

// Redirect to leaderboard
header('Location: ../pages/leaderboard.php');
exit;
