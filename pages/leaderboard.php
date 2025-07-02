<?php
include '../scripts/renderRanking.php';

$teamScores = [
    ['team' => 'Team Delta', 'score' => 1950],
    ['team' => 'Team Alpha', 'score' => 1500],
    ['team' => 'Team Beta', 'score' => 1200],
    ['team' => 'Team Gamma', 'score' => 800],
    ['team' => 'Team Omega', 'score' => 700],
];
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
        <button class="finish-button">Finish Form</button>
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
