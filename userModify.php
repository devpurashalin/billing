<?php
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = hash('sha256', $_POST['password']);
    // $password = $_POST['password'];
    $sql = "INSERT INTO users (name, username, password) VALUES ('$name', '$username', '$password')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header('Location: users.php');
    } else {
        echo "Error";
    }
}
$username = $_GET['id'];
$action = $_GET['action'];
if ($action == 'INACTIVE') {
    $sql = "UPDATE users SET status = 'INACTIVE' WHERE username = '$username'";
} else {
    $sql = "UPDATE users SET status = 'ACTIVE' WHERE username = '$username'";
}

if ($action == 'delete') {
    $sql = "DELETE FROM users WHERE username = '$username'";
}

$result = mysqli_query($conn, $sql);
if ($result) {
    header('Location: users.php');
} else {
    echo "Error";
}
