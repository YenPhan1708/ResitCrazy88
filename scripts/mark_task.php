<?php
// Load data
$dataPath = '../json/data.json';
$tasksPath = '../json/tasks.json';

$data = json_decode(file_get_contents($dataPath), true);
$tasksData = json_decode(file_get_contents($tasksPath), true);
$tasks = $tasksData['tasks'] ?? [];

$group = $_POST['group'] ?? null;
$taskId = isset($_POST['task_id']) ? (int) $_POST['task_id'] : null;

// Validate input
if (!$group || !$taskId) {
    die("Missing group or task ID.");
}

// Make sure group exists
$groupIndex = null;
foreach ($data['groups'] as $index => $g) {
    if ($g['name'] === $group) {
        $groupIndex = $index;
        break;
    }
}

if ($groupIndex === null) {
    die("Group not found.");
}

// Ensure tasksCompleted exists
if (!isset($data['groups'][$groupIndex]['tasksCompleted'])) {
    $data['groups'][$groupIndex]['tasksCompleted'] = [];
}

// Validate and mark task as completed
if (!array_key_exists($taskId - 1, $tasks)) {
    die("Invalid task ID.");
}

if (!in_array($taskId, $data['groups'][$groupIndex]['tasksCompleted'])) {
    $data['groups'][$groupIndex]['tasksCompleted'][] = $taskId;
    file_put_contents($dataPath, json_encode($data, JSON_PRETTY_PRINT));
}

// Redirect back to the checklist
header('Location: ../pages/mark_task_completion.php');
exit;
