<?php
$data = json_decode(file_get_contents('../json/data.json'), true);
$selectedGroup = $_GET['group'] ?? null;
$existingMembers = [];

if ($selectedGroup) {
    foreach ($data['groups'] as $group) {
        if ($group['name'] === $selectedGroup) {
            $existingMembers = $group['members'] ?? [];
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Group Members</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/add_group_members.css"> <!-- Additional styling -->
</head>
<body>
<div class="container">
    <div class="sidebar">
        <img src="../img/nhlStendenLogo.png" alt="Logo" class="logo">
        <button class="finish-button" onclick="window.location.href='leaderboard.php'">Leader Board</button>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>Add Group Members</h1>
            <div class="admin-info">
                <span>Kevin Penn</span>
                <span>Admin</span>
            </div>
        </div>

        <div class="form-box">
            <!-- Group Selection Form -->
            <form method="GET" class="group-select-form">
                <label for="group">Select Group</label>
                <select name="group" id="group" onchange="this.form.submit()">
                    <option value="" disabled <?= is_null($selectedGroup) ? 'selected' : '' ?>>== Please Select Group ==</option>
                    <?php foreach ($data['groups'] as $group): ?>
                        <?php $groupName = $group['name']; ?>
                        <option value="<?= htmlspecialchars($groupName) ?>" <?= $groupName === $selectedGroup ? 'selected' : '' ?>>
                            <?= htmlspecialchars($groupName) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>

            <!-- Only show member form when group is selected -->
            <?php if ($selectedGroup): ?>
                <?php if (!empty($existingMembers)): ?>
                    <div class="member-list">
                        <h3>Current Members:</h3>
                        <ul>
                            <?php foreach ($existingMembers as $member): ?>
                                <li><?= htmlspecialchars($member) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Member Add Form -->
                <form method="POST" action="../scripts/save_members.php" class="member-add-form">
                    <input type="hidden" name="group" value="<?= htmlspecialchars($selectedGroup) ?>">

                    <label for="member_name">New Member Name</label>
                    <input type="text" name="member_name" id="member_name" required>

                    <button type="submit" class="submit-button">Add Member</button>
                </form>
                <!-- Next Button to go to Task Completion -->
                <form method="GET" action="mark_task_completion.php" style="margin-top: 16px;">
                    <input type="hidden" name="group" value="<?= htmlspecialchars($selectedGroup) ?>">
                    <button type="submit" class="next-button">Next</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>
