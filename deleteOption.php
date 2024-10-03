<?php
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $table = $_GET['table'];
    $id = $_GET['id'];
    $sql = "DELETE FROM $table WHERE value='$id'";
    $result = $conn->query($sql);
    if ($result) {
        $_SESSION['message'] = "Option Deleted Successfully";
        header('Location: addOptions.php');
    } else {
        echo "Error: " . $conn->error;
    }
}