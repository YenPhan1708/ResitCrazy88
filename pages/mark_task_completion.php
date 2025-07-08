<?php
$dataPath = '../json/data.json';
$tasksPath = '../json/tasks.json';

$data = json_decode(file_get_contents($dataPath), true);
$tasksData = json_decode(file_get_contents($tasksPath), true);

$tasks = $tasksData['tasks'] ?? [];

$selectedGroup = $_GET['group'] ?? '';
$groupNames = array_column($data['groups'], 'name');
$completedTasks = [];

foreach ($data['groups'] as $group) {
    if ($group['name'] === $selectedGroup) {
        $completedTasks = $group['tasksCompleted'] ?? [];
        break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Task Checklist</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/task_list.css">
</head>
<body>
<div class="container">
    <div class="sidebar">
        <img src="../img/nhlStendenLogo.png" alt="Logo" class="logo">
        <button class="finish-button" onclick="window.location.href='leaderboard.php'">Leader Board</button>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>Task Checklist</h1>
            <div class="admin-info">
                <span>Kevin Penn</span>
                <span>Admin</span>
            </div>
        </div>

        <div class="form-box">
    <form method="GET" class="group-select-form">
        <label for="group">Select Group</label>
        <select name="group" id="group" onchange="this.form.submit()" required>
            <option value="" disabled <?= $selectedGroup === '' ? 'selected' : '' ?>>== Please Select Group ==</option>
            <?php foreach ($groupNames as $name): ?>
                <option value="<?= htmlspecialchars($name) ?>" <?= $selectedGroup === $name ? 'selected' : '' ?>>
                    <?= htmlspecialchars($name) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>
    <form action="../scripts/import_csv.php" method="POST" enctype="multipart/form-data" class="import-csv-form" >
        <label for="csv_file">Import Tasks (CSV)</label>
        <input type="file" name="csv_file" id="csv_file" accept=".csv" required>
        <button type="submit">Upload</button>
    </form>

    <?php if ($selectedGroup): ?>
        <div class="task-list">
            <?php foreach ($tasks as $index => $task): ?>
                <?php
                $taskId = $index + 1;
                $isCompleted = in_array($taskId, $completedTasks);
                $statusClass = $isCompleted ? 'completed' : 'not-completed';
                ?>
                <form method="POST" action="../scripts/mark_task.php">
                    <input type="hidden" name="group" value="<?= htmlspecialchars($selectedGroup) ?>">
                    <input type="hidden" name="task_id" value="<?= $taskId ?>">
                    <button type="submit" class="task-button <?= $statusClass ?>">
                        <?= htmlspecialchars($task['task_name']) ?> (<?= $task['points'] ?> pts)
                    </button>
                </form>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>

    </div>
</div>
</body>
</html>
