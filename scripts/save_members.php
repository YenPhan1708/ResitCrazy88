<?php
$groupName = $_POST['group'] ?? null;
$memberName = $_POST['member_name'] ?? null;

if (!$groupName || !$memberName) {
    die("Missing group or member name.");
}

$dataPath = '../json/data.json';
$data = json_decode(file_get_contents($dataPath), true);

// Find group
foreach ($data['groups'] as &$group) {
    if ($group['name'] === $groupName) {
        if (!in_array($memberName, $group['members'])) {
            $group['members'][] = $memberName;
        }
        break;
    }
}
unset($group);

file_put_contents($dataPath, json_encode($data, JSON_PRETTY_PRINT));

// Redirect back
header("Location: ../pages/add_group_member.php");
exit;
