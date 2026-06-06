<?php
include 'db.php';

$message = "";

if(isset($_POST['register'])) {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if(empty($username) || empty($password)) {

        $message = "All fields are required!";

    } elseif(strlen($password) < 6) {

        $message = "Password must be at least 6 characters.";

    } else {

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $role = "user";

        $stmt = $conn->prepare("INSERT INTO users(username, password, role) VALUES (?, ?, ?)");

        $stmt->bind_param("sss", $username, $hashed_password, $role);

        if($stmt->execute()) {

            $message = "Registration Successful!";

        } else {

            $message = "Username already exists!";
        }
    }
}
?>

<link rel="stylesheet" href="style.css">

<div class="main">

<div class="card">

<h1>🚀 Register</h1>

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
minlength="3"
maxlength="20">

<input type="password"
name="password"
placeholder="Enter Password"
required
minlength="6"
maxlength="20">

<button type="submit" name="register">
Register
</button>

</form>

</div>

</div>