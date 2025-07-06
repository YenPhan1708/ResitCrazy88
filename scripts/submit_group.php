<?php

// Get submitted group name
$groupName = $_POST['group_name'] ?? null;

// Validate input
if (!$groupName || trim($groupName) === '') {
    die("Please provide a group name.");
}

// Load existing data
$dataPath = '../json/data.json';
if (!file_exists($dataPath)) {
    // Initialize file if it doesn't exist
    $data = ['groups' => []];
} else {
    $data = json_decode(file_get_contents($dataPath), true);
}

// Check for duplicate group
$exists = false;
foreach ($data['groups'] as $group) {
    if (strcasecmp($group['name'], $groupName) === 0) {
        $exists = true;
        break;
    }
}

// Add new group if it doesn't already exist
if (!$exists) {
    $data['groups'][] = [
        'name' => $groupName,
        'members' => [],
        'tasksCompleted' => []
    ];
    file_put_contents($dataPath, json_encode($data, JSON_PRETTY_PRINT));
}

// Redirect to the add group members page
header('Location: ../pages/add_group_member.php');
exit;
