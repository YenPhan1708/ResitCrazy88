<?php
// Load data
$dataPath = '../json/data.json';
$tasksPath = '../json/tasks.json';

$data = json_decode(file_get_contents($dataPath), true);
$tasks = json_decode(file_get_contents($tasksPath), true);

$group = $_POST['group'] ?? null;
$taskId = $_POST['task_id'] ?? null;

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

// Only mark task if it's a valid task ID
if (!array_key_exists($taskId, $tasks)) {
    die("Invalid task ID.");
}

// Mark as completed if not already
if (!in_array($taskId, $data['groups'][$groupIndex]['tasksCompleted'])) {
    $data['groups'][$groupIndex]['tasksCompleted'][] = $taskId;
    file_put_contents($dataPath, json_encode($data, JSON_PRETTY_PRINT));
}

// Redirect back to the checklist
header('Location: task_checklist.php?group=' . urlencode($group));
exit;
