<?php
$serverName = "localhost";
$userName = "billing";
$password = "billing@1234";
$dbName = "billing";
$conn = mysqli_connect($serverName, $userName, $password, $dbName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}