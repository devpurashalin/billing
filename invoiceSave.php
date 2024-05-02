<?php
include "db.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $invoiceNo = $_POST['invoiceNo'];
    $partyId = $_POST['partyId'];
    $partyName = $_POST['partyName'];
    $number = $_POST['number'];
    $date = $_POST['date'];
    $TotalAmount = $_POST['total_amt'];
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
    $conn->execute_query("INSERT INTO `invoicetotal`
        (`invoiceNo`, `partyId`, `partyName`, `number`, `date`, `amount`, `paymentStatus`, `paymentReceived`, `discount`) VALUES 
        ('$invoiceNo','$partyId', '$partyName', '$number','$date','$TotalAmount', 'NIL','NIL','NIL')");
    if($_POST['submit'] == 'Save')
        header("Location: invoiceCreate");
    else if($_POST['submit'] == 'Print')
        header("Location: invoiceView?invoiceNo=$invoiceNo");
}
