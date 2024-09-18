<?php
session_start();
if (!isset($_SESSION['username'])) {
    if (isset($_COOKIE['username'])) {
        $_SESSION['username'] = $_COOKIE['username'];
    } else {
        header("Location: login");
    }
}

include "connection.php";
$tempsql = "SELECT * FROM users WHERE username = '" . $_SESSION['username'] . "' AND status = 'ACTIVE'";
$tempresult = $conn->query($tempsql);
if ($tempresult->num_rows == 0) {
    session_destroy();
    setcookie('username', '', time() - 3600, '/billing');
    header("Location: login");
}
