<?php
session_start();
include 'db.php';

$message = "";

if(isset($_POST['login'])) {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if(empty($username) || empty($password)) {

        $message = "All fields are required!";

    } else {

        $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");

        $stmt->bind_param("s", $username);

        $stmt->execute();

        $result = $stmt->get_result();

        if($result->num_rows > 0) {

            $user = $result->fetch_assoc();

            if(password_verify($password, $user['password'])) {

                $_SESSION['username'] = $user['username'];

                $_SESSION['role'] = $user['role'];

                header("Location: dashboard.php");

                exit();

            } else {

                $message = "Wrong Password!";
            }

        } else {

            $message = "User not found!";
        }
    }
}
?>

<link rel="stylesheet" href="style.css">

<div class="main">

<div class="card">

<h1>🔐 Login</h1>

<br>

<?php
if($message != "") {
    echo "<div class='success'>$message</div>";
}
?>

<form method="POST">

<input type="text"
name="username"
placeholder="Enter Username"
required
minlength="3">

<input type="password"
name="password"
placeholder="Enter Password"
required
minlength="6">

<button type="submit" name="login">
Login
</button>

</form>

</div>

</div>