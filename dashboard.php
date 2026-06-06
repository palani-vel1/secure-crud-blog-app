<?php
session_start();
include 'db.php';

if(!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

/* TOTAL POSTS */

$post_query = "SELECT COUNT(*) AS total_posts FROM posts";
$post_result = $conn->query($post_query);
$post_data = $post_result->fetch_assoc();

$total_posts = $post_data['total_posts'];

/* TOTAL USERS */

$user_query = "SELECT COUNT(*) AS total_users FROM users";
$user_result = $conn->query($user_query);
$user_data = $user_result->fetch_assoc();

$total_users = $user_data['total_users'];
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Dashboard</title>

<link rel="stylesheet" href="style.css">

</head>

<body>

<!-- SIDEBAR -->

<div class="sidebar">

    <div class="logo">
        Blogify
    </div>

    <a href="dashboard.php">🏠 Dashboard</a>

    <a href="add_post.php">➕ Add Post</a>

    <a href="index.php">📚 All Posts</a>

    <a href="logout.php">🚪 Logout</a>

</div>

<!-- MAIN -->

<div class="main">

    <!-- TOPBAR -->

    <div class="topbar">

        <h1>
            Welcome,
            <?php echo $_SESSION['username']; ?>
            (<?php echo $_SESSION['role']; ?>) 👋
        </h1>

        <p>
            Manage your blog professionally with secure features.
        </p>

    </div>

    <!-- DASHBOARD GRID -->

    <div class="dashboard-grid">

        <div class="stat-card">

            <h1>📝</h1>

            <h2><?php echo $total_posts; ?></h2>

            <p>Total Blog Posts</p>

        </div>

        <div class="stat-card">

            <h1>👥</h1>

            <h2><?php echo $total_users; ?></h2>

            <p>Registered Users</p>

        </div>

        <div class="stat-card">

            <h1>👤</h1>

            <h2><?php echo $_SESSION['role']; ?></h2>

            <p>Your Role</p>

        </div>

        <div class="stat-card">

            <h1>🛡️</h1>

            <h2>Secure</h2>

            <p>Validation & SQL Protection</p>

        </div>

    </div>

    <!-- QUICK ACTIONS -->

    <div class="card">

        <h2>⚡ Quick Actions</h2>

        <br>

        <div class="quick-buttons">

            <a href="add_post.php" class="quick-btn">
                ➕ Add New Post
            </a>

            <a href="index.php" class="quick-btn">
                📚 View Posts
            </a>

            <a href="logout.php" class="quick-btn logout-btn">
                🚪 Logout
            </a>

        </div>

    </div>

</div>

</body>

</html>