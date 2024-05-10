<?php
include "db.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $invoiceNo = $_POST['invoiceNo'];
    $paymentStatus = $_POST['paymentStatus'];
    $paymentMode = $_POST['paymentMode'];
    $amountReceived = $_POST['amountReceived'];
    $discount = $_POST['discount'];
    $sql = "UPDATE invoicetotal SET 
                paymentStatus = '$paymentStatus', 
                paymentMode = '$paymentMode', 
                amountReceived = '$amountReceived',
                discount = '$discount' 
            WHERE invoiceNo = '$invoiceNo'";
    if ($conn->query($sql) === TRUE) {
        header("Location: search");
    } else {
        echo "Error updating record: " . $conn->error;
    }
}