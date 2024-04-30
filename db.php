<?php
session_start();
if (!isset($_SESSION['username'])) {
    if (isset($_COOKIE['username'])) {
        $_SESSION['username'] = $_COOKIE['username'];
    } else {
        header("Location: login");
    }
}
$serverName = "localhost";
$userName = "root";
$password = "";
$dbName = "invoice";
$conn = mysqli_connect($serverName, $userName, $password, $dbName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
