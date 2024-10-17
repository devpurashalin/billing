<?php
include "db.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $invoiceNo = $_POST['invoiceNo'];
    if ($_POST['submit'] == 'Update') {
        $conn->execute_query("DELETE FROM `invoice` WHERE `invoiceNo` = '$invoiceNo'");
    }

    $partyId = $_POST['partyId'];
    $partyName = $_POST['partyName'];
    $partyName = str_replace(" ($partyId)", "", $partyName);
    $address = $_POST['address'];
    $GST_PAN = $_POST['GST_PAN'];
    $date = $_POST['date'];
    $poOrder = $_POST['poOrder'];
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
        (`invoiceNo`, `partyId`, `partyName`, `address`, `gst`, `date`, `poOrder`, `amount`, `amountWord`, `paymentMode`) VALUES 
        ('$invoiceNo','$partyId', '$partyName', '$address', '$GST_PAN','$date', '$poOrder','$TotalAmount', '$amountWord', '')");
        $_SESSION['message'] = "Invoice Created Successfully";
        header('Location: invoiceCreate');
    } else if ($_POST['submit'] == 'Print') {
        $conn->execute_query("INSERT INTO `invoicetotal`
        (`invoiceNo`, `partyId`, `partyName`, `address`, `gst`, `date`, `poOrder`, `amount`, `amountWord`, `paymentMode`) VALUES 
        ('$invoiceNo','$partyId', '$partyName', '$address', '$GST_PAN','$date', '$poOrder','$TotalAmount', '$amountWord', '')");
        $_SESSION['message'] = "Invoice Created Successfully";
        header("Location: invoiceView?invoiceNo=$invoiceNo");
    } else if ($_POST['submit'] == 'Update') {
        $conn->execute_query("UPDATE `invoicetotal` SET `partyId` = '$partyId', `partyName` = '$partyName', `gst` = '$GST_PAN', `address` = '$address', `date` = '$date', `poOrder` = '$poOrder', `amount` = '$TotalAmount', `amountWord` = '$amountWord' WHERE `invoiceNo` = '$invoiceNo';");
        $_SESSION['message'] = "Invoice Updated Successfully";
        header("Location: invoiceView?invoiceNo=$invoiceNo");
    }
}
