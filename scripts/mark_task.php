<?php
// Load data
$dataPath = '../json/data.json';
$tasksPath = '../json/tasks.json';

$data = json_decode(file_get_contents($dataPath), true);
$tasks = json_decode(file_get_contents($tasksPath), true);

$group = $_POST['group'] ?? null;
$taskId = $_POST['task_id'] ?? null;

// Validate input
if ($group === null || $taskId === null) {
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

// Convert string task ID to integer
$taskIndex = (int)$taskId - 1;  // Convert to 0-based index

// Check if it's a valid task ID
if (!isset($tasks['tasks'][$taskIndex])) {
    die("Invalid task ID.");
}

$taskKey = "Task " . $taskId;
$completed = &$data['groups'][$groupIndex]['tasksCompleted'];

// Toggle task completion
if (in_array($taskKey, $completed)) {
    // Unmark (remove)
    $completed = array_values(array_filter($completed, fn($t) => $t !== $taskKey));
} else {
    // Mark as completed
    $completed[] = $taskKey;
}

file_put_contents($dataPath, json_encode($data, JSON_PRETTY_PRINT));

// Redirect back to checklist
header('Location: ../pages/mark_task_completion.php?group=' . urlencode($group));
exit;
