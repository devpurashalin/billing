<?php
include "db.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $invoiceNo = $_POST['invoiceNo'];
    $paymentMode = $_POST['paymentMode'];
    $amountReceived = $_POST['amountReceived'];
    $dateOfPayment = $_POST['dateOfPayment'];
    $totalAmount = $_POST['totalAmount'];
    $discount = $_POST['discount'];
    $remark = $_POST['remark'];



    if (($amountReceived + $discount) > $totalAmount) {
?>
        <script>
            alert('Amount received & discount cannot be greater than total amount');
            window.history.back();
        </script>
<?php
        exit;
    }
    
    $sql = "UPDATE invoicetotal SET 
                paymentMode = '$paymentMode', 
                amountReceived = '$amountReceived',
                dateOfPayment = '$dateOfPayment',
                remark = '$remark',
                discount = '$discount'
            WHERE invoiceNo = '$invoiceNo'";
    if ($conn->query($sql) === TRUE) {
?>
        <script>
            alert('Record updated successfully');
            window.location.href = 'payment';
        </script>
<?php
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
