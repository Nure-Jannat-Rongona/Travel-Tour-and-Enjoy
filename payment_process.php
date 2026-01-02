<?php
session_start();

if (empty($_POST['method'])) {
    header("Location: payment.php");
    exit();
}

$_SESSION['booking']['payment_done'] = true;
$_SESSION['booking']['payment_method'] = $_POST['method'];

header("Location: booking_confirm.php");
exit();
