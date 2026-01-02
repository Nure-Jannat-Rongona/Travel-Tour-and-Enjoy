<?php
session_start();

$_SESSION['booking']['transport_id'] = $_POST['transport_id'];

header("Location: payment.php");
exit();
