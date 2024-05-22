<?php
include "db.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $invoiceNo = $_POST['invoiceNo'];
    $paymentStatus = $_POST['paymentStatus'];
    $paymentMode = $_POST['paymentMode'];
    $amountReceived = $_POST['amountReceived'];
    $discount = $_POST['discount'];
    $dateOfPayment = $_POST['dateOfPayment'];
    $remark = $_POST['remark'];
    $sql = "UPDATE invoicetotal SET 
                paymentStatus = '$paymentStatus', 
                paymentMode = '$paymentMode', 
                amountReceived = '$amountReceived',
                discount = '$discount',
                dateOfPayment = '$dateOfPayment',
                remark = '$remark'
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
