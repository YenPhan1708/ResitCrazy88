<?php
session_start();
$group = $_SESSION['selected_group'] ?? null;

if (!$group) {
    echo "Group not specified.";
    exit;
}

// Load group tasks
$tasksJson = file_get_contents('../json/group_tasks.json');
$groupTasks = json_decode($tasksJson, true);
$tasks = $groupTasks[$group] ?? [];

// Load existing data to check already completed tasks
$dataJson = file_get_contents('../json/data.json');
$data = json_decode($dataJson, true);

$completed = [];
foreach ($data['groups'] as $entry) {
    if ($entry['name'] === $group) {
        $completed = $entry['tasksCompleted'] ?? [];
        break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mark Task Completion</title>
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
            <h1>Mark Tasks for <?= htmlspecialchars($group) ?></h1>
            <div class="admin-info">
                <span>Kevin Penn</span>
                <span class="role">Admin</span>
            </div>
        </header>

        <div class="content_container">
            <div class="content">
                <div class="form-wrapper">
                    <form method="post" action="../scripts/save_tasks.php">
                        <input type="hidden" name="group" value="<?= htmlspecialchars($group) ?>"/>
                        
                        <?php if (empty($tasks)): ?>
                            <p>No tasks found for <?= htmlspecialchars($group) ?>.</p>
                        <?php else: ?>
                            <label>Select completed tasks:</label><br/>
                            <?php foreach ($tasks as $task): ?>
                                <div class="task-item">
                                    <input type="checkbox" name="tasks[]" value="<?= htmlspecialchars($task) ?>" 
                                           id="<?= htmlspecialchars($task) ?>"
                                           <?= in_array($task, $completed) ? 'checked' : '' ?>>
                                    <label class="task-label" for="<?= htmlspecialchars($task) ?>"><?= htmlspecialchars($task) ?></label>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <button type="submit" class="submit_button">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>
</body>
</html>
