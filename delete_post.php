<?php
session_start();
include 'db.php';

if(!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

/* ADMIN ONLY */

if($_SESSION['role'] != "admin") {

    die("Access Denied! Only admin can delete posts.");
}

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM posts WHERE id=?");

$stmt->bind_param("i", $id);

$stmt->execute();

header("Location: index.php");
?>