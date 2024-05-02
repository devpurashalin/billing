<?php
include "db.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $invoiceNo = $_POST['invoiceNo'];
    $paymentStatus = $_POST['paymentStatus'];
    $paymentReceived = $_POST['paymentReceived'];
    $discount = $_POST['discount'];
    $sql = "UPDATE invoicetotal SET paymentStatus = '$paymentStatus', paymentReceived = '$paymentReceived', discount = '$discount' WHERE invoiceNo = '$invoiceNo'";
    if ($conn->query($sql) === TRUE) {
        header("Location: invoiceSearchParty.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }
}