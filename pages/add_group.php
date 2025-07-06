<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Group</title>
    <link rel="stylesheet" href="../css/style.css"> <!-- your shared layout styles -->
    <link rel="stylesheet" href="../css/add_group.css"> <!-- additional form styles -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div class="container">
    <!-- Sidebar -->
    <div class="sidebar">
        <img src="../img/nhlStendenLogo.png" alt="NHL Stenden Logo" class="logo">
        <button class="finish-button" onclick="window.location.href='leaderboard.php'">Leader Board</button>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <h1>Add New Group</h1>
            <div class="admin-info">
                <span>Kevin Penn</span>
                <span>Admin</span>
            </div>
        </div>

        <!-- Centered Form -->
        <div class="center-wrapper">
            <form action="../scripts/submit_group.php" method="POST" class="add-group-form">
                <label for="group_name">Group Name</label>
                <input type="text" name="group_name" id="group_name" required>
                <button type="submit">Add Group</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
