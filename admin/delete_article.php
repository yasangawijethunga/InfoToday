<?php
session_start();
if (!isset($_SESSION['admin'])) header('Location: login.php');
include '../db/config.php';
$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM articles WHERE id=$id");
header('Location: dashboard.php');
?>

