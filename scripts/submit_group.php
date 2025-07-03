<?php
session_start();

$group = $_POST['group'] ?? null;

if (!$group) {
    die("No group selected.");
}

// Load current data
$dataPath = '../json/data.json';
$data = json_decode(file_get_contents($dataPath), true);

// Check if group already exists, if not add it
$groupExists = false;
foreach ($data['groups'] as $existingGroup) {
    if ($existingGroup['name'] === $group) {
        $groupExists = true;
        break;
    }
}

if (!$groupExists) {
    $data['groups'][] = [
        'name' => $group,
        'members' => [],
        'tasksCompleted' => []
    ];
    file_put_contents($dataPath, json_encode($data, JSON_PRETTY_PRINT));
}

// ✅ Store group in session for later pages
$_SESSION['selected_group'] = $group;

header('Location: ../pages/add_group.php');
exit;
