<?php
session_start();

$groupName = $_POST['group'] ?? null;
$selectedMembers = $_POST['members'] ?? [];

if (!$groupName) {
    die("Group name not provided.");
}

// Load current data
$dataPath = '../json/data.json';
$data = json_decode(file_get_contents($dataPath), true);

// Find the correct group and update its members
foreach ($data['groups'] as &$group) {
    if ($group['name'] === $groupName) {
        $group['members'] = $selectedMembers;
        break;
    }
}

file_put_contents($dataPath, json_encode($data, JSON_PRETTY_PRINT));

// Redirect back or forward
header('Location: ../pages/add_group_member.php');
exit;
