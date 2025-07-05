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

// Find the group index
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

// Mark task as completed if not already done
if (!in_array($taskId, $data['groups'][$groupIndex]['tasksCompleted'])) {
    $data['groups'][$groupIndex]['tasksCompleted'][] = $taskId;
}

//Recalculate the group score
$totalScore = 0;
foreach ($data['groups'][$groupIndex]['tasksCompleted'] as $completedId) {
    $taskIndex = $completedId - 1;
    if (isset($tasks[$taskIndex])) {
        $totalScore += $tasks[$taskIndex]['points'];
    }
}

// ✅ Store the score in the group data
$data['groups'][$groupIndex]['score'] = $totalScore;

// Save back to file
file_put_contents($dataPath, json_encode($data, JSON_PRETTY_PRINT));

// Redirect to checklist page
header('Location: ../pages/mark_task_completion.php?group=' . urlencode($group));
exit;
