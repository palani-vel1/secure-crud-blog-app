<?php
session_start();
include 'db.php';

if(!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM posts WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

$row = $result->fetch_assoc();

$message = "";

if(isset($_POST['update'])) {

    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if(empty($title) || empty($content)) {

        $message = "All fields required!";

    } else {

        $stmt = $conn->prepare("UPDATE posts SET title=?, content=? WHERE id=?");

        $stmt->bind_param("ssi", $title, $content, $id);

        if($stmt->execute()) {

            header("Location: index.php");
        }
    }
}
?>

<link rel="stylesheet" href="style.css">

<div class="main">

<div class="card">

<h1>✏️ Edit Post</h1>

<br>

<?php
if($message != "") {
    echo "<div class='success'>$message</div>";
}
?>

<form method="POST">

<input type="text"
name="title"
value="<?php echo $row['title']; ?>"
required
minlength="5"
maxlength="100">

<textarea
name="content"
required
minlength="20"><?php echo $row['content']; ?></textarea>

<button type="submit" name="update">
Update Post
</button>

</form>

</div>

</div>