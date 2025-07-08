<?php
require_once '../scripts/renderRanking.php';
$teamScores = getActualTeamScores('../json/data.json');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Leaderboard</title>
    <link rel="stylesheet" href="../css/style.css" />
</head>
<body>
<div class="container">
    <aside class="sidebar">
        <img src="../img/nhlStendenLogo.png" alt="NHL Stenden Logo" class="logo"/>
         <nav class="nav-links">
            <a href="add_group.php">Add Group</a>
            <a href="add_group_member.php">Add Members</a>
            <a href="mark_task_completion.php">Task Checklist</a>
        </nav>
    </aside>

    <main class="main-content">
        <header class="header">
            <h1>Leader Board</h1>
            <div class="admin-info">
                <span>Kevin Penn</span>
                <span class="role">Admin</span>
            </div>
        </header>

        <section class="leaderboard">
            <?php renderRanking($teamScores); ?>
        </section>
    </main>
</div>
</body>
</html>
