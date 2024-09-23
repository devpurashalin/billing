<?php
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $table = $_GET['table'];
    $id = $_GET['id'];
    $sql = "DELETE FROM $table WHERE value='$id'";
    $result = $conn->query($sql);
    if ($result) {
        echo '<script>alert("Deleted Successfully")</script>';
        echo '<script>window.location.href="addOptions.php"</script>';
    } else {
        echo "Error: " . $conn->error;
    }
}