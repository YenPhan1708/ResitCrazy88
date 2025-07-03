<?php
session_start();

$group = $_SESSION['selected_group'] ?? null;

if (!$group) {
    echo "Group not specified.";
    exit;
}

// Load group members
$membersJson = file_get_contents('../json/group_members.json');
$groupMembers = json_decode($membersJson, true);

// Load main data file
$dataJson = file_get_contents('../json/data.json');
$data = json_decode($dataJson, true);

// Get members for this group
$members = $groupMembers[$group] ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Group Member</title>
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="../css/add_group.css" />
</head>
<body>
<div class="container">
    <aside class="sidebar">
        <img src="../img/nhlStendenLogo.png" alt="NHL Stenden Logo" class="logo" />
        <button class="finish-button">Leader Board</button>
    </aside>

    <main class="main-content">
        <header class="header">
            <h1>Add Members to <?= htmlspecialchars($group) ?></h1>
            <div class="admin-info">
                <span>Kevin Penn</span>
                <span class="role">Admin</span>
            </div>
        </header>

        <div class="content_container">
            <div class="content">
                <div class="form-wrapper">
                    <form class="group-form" method="post" action="../scripts/save_members.php">
                        <input type="hidden" name="group" value="<?= htmlspecialchars($group) ?>"/>
                        
                        <?php if (empty($members)): ?>
                            <p>No members found for <?= htmlspecialchars($group) ?>.</p>
                        <?php else: ?>
                            <label>Select group members:</label><br/>
                            <?php foreach ($members as $member): ?>
                                <div>
                                    <input type="checkbox" name="members[]" value="<?= htmlspecialchars($member) ?>" id="<?= htmlspecialchars($member) ?>">
                                    <label for="<?= htmlspecialchars($member) ?>"><?= htmlspecialchars($member) ?></label>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        
                        <button type="submit">Submit</button>
                    </form>
                </div>
                <div class="button-container">
                        <a href="add_group_member.php" class="finish-button next-button">Next →</a>
                    </div> 
            </div>
        </div>
    </main>
</div>
</body>
</html>
