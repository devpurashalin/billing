<?php
include 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $invoiceNo = $_GET['invoiceNo'];
} else {
    exit;
}
$sql = "SELECT * FROM invoicetotal WHERE invoiceNo = '$invoiceNo'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $invoiceNo = $row['invoiceNo'];
    $partyId = $row['partyId'];
    $partyName = $row['partyName'];
    $number = $row['number'];
    $date = $row['date'];
    $amountWord = $row['amountWord'];
    $TotalAmount = $row['amount'];
    $sql1 = "SELECT * FROM party WHERE ID = '$partyId'";
    $result1 = $conn->query($sql1);
    $row1 = $result1->fetch_assoc();
    $address = $row1['address'];
    $GST_PAN = $row1['GST_PAN'];
} else {
    echo "No Record Found";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Print</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <style>
        .table th,
        .table td {
            border: none;
        }

        .heading {
            border: 1px solid black;
        }

        .forBorder td {
            border-left: 1px solid black;
            border-right: 1px solid black;
        }

        @media print {
            .container {
                width: 100%;
                max-width: none;
                padding: 0 50px;
            }

            #footer {
                page-break-inside: avoid;
            }
        }

        #completeHeight {
            height: 45vh;
        }

        #completeHeight tr {
            height: 4vh;
        }
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div class="my-5 container h-100" id="forPrint">
        <div class="d-flex gap-5 my-5 d-print-none">
            <button class="btn btn-primary" onclick="window.print()">Print</button>
            <a class="text-decoration-none btn btn-success" target="_blank" href="pdf?invoiceNo=<?php echo $invoiceNo; ?>">Save as PDF</a>
            <form action="./invoiceEdit" method="post">
                <input type="hidden" name="invoiceNo" value="<?php echo $invoiceNo; ?>">
                <button type="submit" class="btn btn-warning">Edit</button>
            </form>
        </div>
        <table class="table" id="invoiceTable">
            <tr>
                <td class="py-0">PAN No.: ABCED1234E</td>
                <th class="text-center py-0" colspan="3">
                    <img src="./ganesh.jpeg" width="35px" alt="">
                    <br>
                    <u>Cash/Credit Memo</u>
                </th>
                <td class="text-end py-0">Mob: 9887111141<br>9414060621</td>
            </tr>
            <tr>
                <td class="text-center text-danger h2 py-0" colspan="5">DEEPAK PRINTERS</td>
            </tr>
            <tr>
                <td colspan="5">
                    <div class="text-center fw-bold">Deals in : Offset, Screen, Multi Colour Printing & Computer Design Works</div>
                    <div class="text-center">OPP. SBI BANK, JAGATPURA, JAIPUR-302017</div>
                    <div class="text-center">Email : deepakprinters.jpr@gmail.com</div>
                </td>
            </tr>
            <tr>
                <td class=""><label for="invoiceNo">Invoice No.</label></td>
                <td colspan="2"><?php echo $invoiceNo; ?></td>
                <td class=""><label for="date">Date</label></td>
                <td><?php echo date("d-M-Y", strtotime($date)); ?></td>
            </tr>
            <tr>
                <td class=""><label for="partyName">Name of Party</label></td>
                <td colspan="2"><?php echo $partyName; ?></td>
                <td class=""><label for="GST_PAN">GST/PAN</label></td>
                <td><?php echo $GST_PAN; ?></td>
            </tr>
            <tr>
                <td class=""><label for="address">Address</label></td>
                <td colspan="2"><?php echo $address; ?></td>
                <td class=""><label for="number">Mobile No.</label></td>
                <td><?php echo $number; ?></td>
            </tr>
        </table>
        <table class="table" id="completeHeight">
            <tr class="forBorder heading">
                <td class="fw-bold bg-warning">S. No.</td>
                <td class="fw-bold bg-warning">Description</td>
                <td class="fw-bold bg-warning">Qty.</td>
                <td class="fw-bold bg-warning">Rate</td>
                <td class="fw-bold bg-warning">Amount Rs.</td>
            </tr>
            <?php
            $sql2 = "SELECT * FROM invoice WHERE invoiceNo = '$invoiceNo'";
            $result2 = $conn->query($sql2);
            if ($result2->num_rows > 0) {
                while ($row2 = $result2->fetch_assoc()) {
                    echo "<tr class='forBorder'>";
                    echo "<td class='text-center'>" . $row2['SNo'] . "</td>";
                    echo "<td>" . $row2['description'] . "</td>";
                    echo "<td class='text-center'>" . $row2['qty'] . "</td>";
                    echo "<td class='text-center'>" . $row2['rate'] . "</td>";
                    echo "<td>" . $row2['amount'] . "</td>";
                    echo "</tr>";
                }
            }
            ?>
            <tr class="forBorder h-100">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr class="forBorder heading fw-bold">
                <td colspan="4" class="text-end">Total Amount</td>
                <td id="totalAmount"><?php echo $TotalAmount; ?></td>
            </tr>
        </table>
        <table class="table" id="footer">
            <tr>
                <td colspan="5" id="totalAmountWords">Rs. (in words): <?php echo $amountWord; ?></td>
            </tr>
            <tr><td></td></tr>
            <tr>
                <td class="py-0" colspan="4"><b>Terms and Conditions:</b></td>
                <td class="py-0 text-danger">For: <b>Deepak Printers</b></td>
            </tr>

            <tr>
                <td class="py-0" colspan="4">1. All subject to Jaipur jurisdiction only.</td>
                <td></td>
            </tr>

            <tr>
                <td class="py-0" colspan="4">2. Goods Sold will not be taken back.</td>
                <td></td>
            </tr>

            <tr>
                <td class="py-0" colspan="4">3. E. & O.E.</td>
                <td>Authorised Signature</td>
            </tr>
        </table>
    </div>
</body>

</html>