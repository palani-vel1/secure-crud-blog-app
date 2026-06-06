<?php
include 'db.php';

$limit = 3;

$page = isset($_GET['page']) ? $_GET['page'] : 1;

$start = ($page - 1) * $limit;

/* SEARCH */

$search = "";

if(isset($_GET['search'])) {

    $search = $_GET['search'];

    $sql = "SELECT * FROM posts
            WHERE title LIKE '%$search%'
            OR content LIKE '%$search%'
            LIMIT $start, $limit";

} else {

    $sql = "SELECT * FROM posts
            LIMIT $start, $limit";
}

$result = $conn->query($sql);
?>

<link rel="stylesheet" href="style.css">

<div class="sidebar">

<div class="logo">
    Blogify
</div>

<a href="dashboard.php">🏠 Dashboard</a>

<a href="add_post.php">➕ Add Post</a>

<a href="index.php">📚 All Posts</a>

<a href="logout.php">🚪 Logout</a>

</div>

<div class="main">

<div class="topbar">

<h1>All Blog Posts 📚</h1>

<p>Manage your content beautifully.</p>

</div>

<!-- SEARCH BAR -->

<div class="card">

<form method="GET">

<input type="text"
name="search"
placeholder="Search posts by title or content..."
value="<?php echo $search; ?>">

<button type="submit">
🔍 Search
</button>

</form>

</div>

<?php
if($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {
?>

<div class="post">

<h2><?php echo $row['title']; ?></h2>

<p><?php echo $row['content']; ?></p>

<div class="actions">

<a href="edit_post.php?id=<?php echo $row['id']; ?>">
✏️ Edit
</a>

<a href="delete_post.php?id=<?php echo $row['id']; ?>">
🗑 Delete
</a>

</div>

</div>

<?php
    }

} else {

    echo "<div class='card'><h3>No posts found 😔</h3></div>";
}

/* PAGINATION */

if(isset($_GET['search'])) {

    $total_query = "SELECT COUNT(*) AS total
                    FROM posts
                    WHERE title LIKE '%$search%'
                    OR content LIKE '%$search%'";

} else {

    $total_query = "SELECT COUNT(*) AS total
                    FROM posts";
}

$total_result = $conn->query($total_query);

$total_row = $total_result->fetch_assoc();

$total_posts = $total_row['total'];

$total_pages = ceil($total_posts / $limit);

echo "<div class='pagination'>";

for($i = 1; $i <= $total_pages; $i++) {

    if(isset($_GET['search'])) {

        echo "<a href='index.php?page=$i&search=$search'>$i</a>";

    } else {

        echo "<a href='index.php?page=$i'>$i</a>";
    }
}

echo "</div>";
?>

</div>