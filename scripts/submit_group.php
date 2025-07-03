<?php
$dataFile = '../json/data.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedGroup = $_POST['group'] ?? '';

    if ($selectedGroup === '') {
        die('No group selected.');
    }

    // Read current JSON data
    $data = [];
    if (file_exists($dataFile)) {
        $json = file_get_contents($dataFile);
        $data = json_decode($json, true);
    }

    // Prevent duplicate group entries
    $groupExists = false;
    if (isset($data['groups'])) {
        foreach ($data['groups'] as $group) {
            if ($group['name'] === $selectedGroup) {
                $groupExists = true;
                break;
            }
        }
    } else {
        $data['groups'] = [];
    }

    // If group doesn't exist, add it
    if (!$groupExists) {
        $data['groups'][] = [
            'name' => $selectedGroup,
            'members' => [],
            'tasksCompleted' => []
        ];
    }

    // Save back to JSON
    file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT));

    // Redirect or confirmation
    header('Location: ../pages/add_group.php?success=1');
    exit;
}
?>
