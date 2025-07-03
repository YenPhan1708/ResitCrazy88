<?php
// Load group list from JSON
$groupJson = file_get_contents('../json/groups.json');
$groupList = json_decode($groupJson, true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Add Group</title>
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="../css/add_group.css"/>
</head>
<body>
<div class="container">
    <aside class="sidebar">
        <img src="../img/nhlStendenLogo.png" alt="NHL Stenden Logo" class="logo"/>
        <button class="finish-button">Leader Board</button>
    </aside>

    <main class="main-content">
        <header class="header">
            <h1>Add Group</h1>
            <div class="admin-info">
                <span>Kevin Penn</span>
                <span class="role">Admin</span>
            </div>
        </header>
        <div class="content_container">
                <div class="content">
                    <div class="form-wrapper">
                        <form class="group-form" method="post" action="../scripts/submit_group.php">
                            <label for="group">Choose a group:</label>
                            <select name="group" id="group" required>
                                <option value="">-- Select a Group --</option>
                                <?php
                                if (!empty($groupList['groups'])) {
                                    foreach ($groupList['groups'] as $group) {
                                        echo "<option value=\"" . htmlspecialchars($group) . "\">$group</option>";
                                    }
                                } else {
                                    echo "<option disabled>No groups found</option>";
                                }
                                ?>
                            </select>
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
