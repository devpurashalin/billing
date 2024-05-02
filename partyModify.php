<?php
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ID = $_POST['ID'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $number = $_POST['number'];
    $GST_PAN = $_POST['GST_PAN'];
    $sql = "INSERT INTO party (ID, name, address, number, GST_PAN) VALUES ('$ID', '$name', '$address', '$number', '$GST_PAN')";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('New record created successfully');</script>";
        header("Location: partyList");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = $_GET['id'];
    $sql = "DELETE FROM party WHERE ID = '$id'";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Record deleted successfully');</script>";
        header("Location: partyList");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}