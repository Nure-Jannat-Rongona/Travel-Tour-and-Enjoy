<?php
session_start();

/* 🔐 Protect against direct access */
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

/* ❗ Validate required fields */
if (
    !isset($_POST['destination_id']) || 
    !isset($_POST['date']) || 
    !isset($_POST['people']) ||
    empty($_POST['destination_id']) ||
    empty($_POST['date']) ||
    empty($_POST['people'])
) {
    header("Location: book.php?error=1");
    exit();
}

/* 📦 Save booking data into session */
$_SESSION['booking']['destination_id'] = (int) $_POST['destination_id'];
$_SESSION['booking']['date'] = $_POST['date'];
$_SESSION['booking']['people'] = (int) $_POST['people'];

/* 🚀 Go to next step */
header("Location: transport.php");
exit();
