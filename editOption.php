<?php
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $table = $_GET['table'];
    $id = $_GET['id'];
    $edit = $_GET['edit'];
    $sql = "UPDATE $table SET value='$edit' WHERE value='$id'";
    $result = $conn->query($sql);
    if ($result) {
        echo '<script>alert("Edited Successfully")</script>';
        echo '<script>window.location.href="addOptions.php"</script>';
    } else {
        echo "Error: " . $conn->error;
    }
}
