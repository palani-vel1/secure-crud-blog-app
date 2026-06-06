<?php
session_start();
include 'db.php';

if(!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$message = "";

if(isset($_POST['submit'])) {

    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if(empty($title) || empty($content)) {

        $message = "All fields are required!";

    } else {

        $stmt = $conn->prepare("INSERT INTO posts(title, content) VALUES (?, ?)");

        $stmt->bind_param("ss", $title, $content);

        if($stmt->execute()) {

            $message = "Post Added Successfully!";
        }
    }
}
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

<div class="card">

<h1>➕ Add New Post</h1>

<br>

<?php
if($message != "") {
    echo "<div class='success'>$message</div>";
}
?>

<form method="POST">

<input type="text"
name="title"
placeholder="Enter Post Title"
required
minlength="5"
maxlength="100">

<textarea
name="content"
placeholder="Write content..."
required
minlength="20"></textarea>

<button type="submit" name="submit">
Add Post
</button>

</form>

</div>

</div>
