<?php
include "db.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $invoiceNo = $_POST['invoiceNo'];
    if ($_POST['submit'] == 'Update') {
        $conn->execute_query("DELETE FROM `invoice` WHERE `invoiceNo` = '$invoiceNo'");
    }

    $partyId = $_POST['partyId'];
    $partyName = $_POST['partyName'];
    $number = $_POST['number'];
    $date = $_POST['date'];
    $TotalAmount = $_POST['total_amt'];
    $amountWord = $_POST['total_amt_words'];
    $count = 1;
    while (isset($_POST["sno" . $count])) {
        $sno = $_POST["sno" . $count];
        $description = $_POST["description" . $count];
        $quantity = $_POST["qty" . $count];
        $rate = $_POST["rate" . $count];
        $amount = $_POST["amount_rs" . $count];
        $conn->execute_query("INSERT INTO `invoice` (`invoiceNo`, `partyId`, `partyName`, `date`, `SNo`, `description`, `qty`, `rate`, `amount`) VALUES 
        ('$invoiceNo', '$partyId', '$partyName', '$date', '$sno', '$description', '$quantity', '$rate', '$amount');");
        $count++;
    }
    if ($_POST['submit'] == 'Save') {
        $conn->execute_query("INSERT INTO `invoicetotal`
        (`invoiceNo`, `partyId`, `partyName`, `number`, `date`, `amount`, `amountWord`, `paymentStatus`, `paymentMode`, `discount`) VALUES 
        ('$invoiceNo','$partyId', '$partyName', '$number','$date','$TotalAmount', '$amountWord', 'Due','','NIL')");
        echo "<script>alert('Invoice Created Successfully');</script>";
        echo "<script>window.location.href='invoiceCreate';</script>";
    } else if ($_POST['submit'] == 'Print') {
        $conn->execute_query("INSERT INTO `invoicetotal`
        (`invoiceNo`, `partyId`, `partyName`, `number`, `date`, `amount`, `amountWord`, `paymentStatus`, `paymentMode`, `discount`) VALUES 
        ('$invoiceNo','$partyId', '$partyName', '$number','$date','$TotalAmount', '$amountWord', 'Due','','NIL')");
        
        header("Location: invoiceView?invoiceNo=$invoiceNo");
    } else if ($_POST['submit'] == 'Update') {
        $conn->execute_query("UPDATE `invoicetotal` SET `partyId` = '$partyId', `partyName` = '$partyName', `number` = '$number', `date` = '$date', `amount` = '$TotalAmount', `amountWord` = '$amountWord' WHERE `invoiceNo` = '$invoiceNo';");
        echo "<script>alert('Invoice Updated Successfully');</script>";
        echo "<script>window.location.href='invoiceView?invoiceNo=$invoiceNo';</script>";
    }
}
