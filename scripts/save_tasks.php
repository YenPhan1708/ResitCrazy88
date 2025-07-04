<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $group = $_POST['group'] ?? null;
    $tasks = $_POST['tasks'] ?? [];

    if (!$group) {
        die("Group is missing.");
    }

    // Load current data
    $dataPath = '../json/data.json';
    $data = json_decode(file_get_contents($dataPath), true);

    // Find and update the group
    foreach ($data['groups'] as &$entry) {
        if ($entry['name'] === $group) {
            $entry['tasksCompleted'] = $tasks;
            break;
        }
    }

    // Save back
    file_put_contents($dataPath, json_encode($data, JSON_PRETTY_PRINT));
    header("Location: ../pages/leaderboard.php");
    exit;
}
?>
