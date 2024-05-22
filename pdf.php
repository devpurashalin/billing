<?php
// Include mPDF library
require_once './vendor/autoload.php'; // Adjust the path as needed
require_once './connection.php'; // Adjust the path as needed
// Create mPDF object
$mpdf = new \Mpdf\Mpdf();
$mpdf->SetMargins(0, 0, 5);
if (isset($_GET['invoiceNo'])) {
    $invoiceNo = $_GET['invoiceNo'];
} else {
    header("Location: ./invoicesAll.php");
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
    $TotalAmount = $row['amount'];
    $amountWord = $row['amountWord'];
    $sql1 = "SELECT * FROM party WHERE ID = '$partyId'";
    $result1 = $conn->query($sql1);
    $row1 = $result1->fetch_assoc();
    $address = $row1['address'];
    $GST_PAN = $row1['GST_PAN'];
} else {
    echo "No Record Found";
    exit;
}
$date = date("d-M-Y", strtotime($date));

// Render HTML content
ob_start();
// include 'invoicesAll.php'; // Include the PHP page you want to convert to PDF
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?php echo $invoiceNo; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            padding: 5px;
        }

        #completeHeight {
            border: 1px solid black;
        }

        #completeHeight td {
            border-left: 1px solid black;
        }

        #completeHeight th {
            border: 1px solid black;
            background-color: yellow;
        }

        #lastRow td {
            border-top: 1px solid black;
        }

        .text-end {
            text-align: right;
        }
        table, td, th {
            border: 0px solid black;
        }
        .text-center {
            text-align: center;
        }
        .vertical-align {
            /* vertical-align: top; */
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <td colspan="2" style="padding-top: 0;" class="vertical-align">PAN No.: ABCED1234E</td>
            <th colspan="3" style="padding: 10 140 10 80;">
                <img src="./ganesh.jpeg" width="35px">
                <br>
                <u>Cash/Credit Memo</u>
            </th>
            <td class="text-end vertical-align">Mob: 9887111141
                <br> 9414060621
            </td>
        </tr>
        <tr>
            <th colspan="6">
                <h1 style="color: #dc3545;">DEEPAK PRINTERS</h1>
            </th>
        </tr>
        <tr>
            <th colspan="6">Deals in : Offset, Screen, Multi Colour Printing & Computer Design Works</th>
        </tr>
        <tr>
            <td class="text-center" colspan="6">OPP. SBI BANK, JAGATPURA, JAIPUR-302017</td>
        </tr>
        <tr>
            <td style='padding-bottom: 25x;' class="text-center" colspan="6">Email : deepakprinters.jpr@gmail.com</td>
        </tr>
        <tr>
            <td><label for="invoiceNo">Invoice No.</label></td>
            <td colspan="3"><?php echo $invoiceNo; ?></td>
            <td><label for="date">Date</label></td>
            <td><?php echo $date; ?></td>
        </tr>
        <tr>
            <td><label for="partyName">Name of Party</label></td>
            <td colspan="3"><?php echo $partyName; ?></td>
            <td><label for="GST_PAN">GST/PAN</label></td>
            <td><?php echo $GST_PAN; ?></td>
        </tr>
        <tr>
            <td><label for="address">Address</label></td>
            <td colspan="3"><?php echo $address; ?></td>
            <td><label for="number">Mobile No.</label></td>
            <td><?php echo $number; ?></td>
        </tr>
    </table>
    <br>
    <table id="completeHeight">
        <tr>
            <th>S. No.</th>
            <th>Description</th>
            <th>Qty.</th>
            <th>Rate</th>
            <th>Amount Rs.</th>
        </tr>
        <?php
        $sql2 = "SELECT * FROM invoice WHERE invoiceNo = '$invoiceNo'";
        $result2 = $conn->query($sql2);
        if ($result2->num_rows > 0) {
            $count = 0;
            while ($row2 = $result2->fetch_assoc()) {
                $count++;
                echo "<tr>";
                echo "<td class='text-center'>" . $row2['SNo'] . "</td>";
                echo "<td>" . $row2['description'] . "</td>";
                echo "<td class='text-center'>" . $row2['qty'] . "</td>";
                echo "<td class='text-center'>" . $row2['rate'] . "</td>";
                echo "<td class='text-end' style='padding-right: 20px'>" . $row2['amount'] . "</td>";
                echo "</tr>";
            }
        }
        while ($count < 15) {
            $count++;
            echo "<tr>";
            echo "<td style='padding-top: 13px; padding-bottom: 14x;'></td>";
            echo "<td></td>";
            echo "<td></td>";
            echo "<td></td>";
            echo "<td></td>";
            echo "</tr>";
        }
        ?>

        <tr id="lastRow">
            <td colspan="4" class="text-end">Total Amount</td>
            <td id="totalAmount"><?php echo $TotalAmount; ?></td>
        </tr>
    </table>
    <br>
    <table id="footer">
        <tr>
            <td style="padding-bottom: 25px;" colspan="5" id="totalAmountWords">Rs. (in words): <?php echo $amountWord; ?></td>
        </tr>
        <tr></tr>
        <tr>
            <td colspan="4"><b>Terms and Conditions:</b></td>
            <td class="text-end" style="color: #dc3545;">For: <b>Deepak Printers</b></td>
        </tr>

        <tr>
            <td colspan="4">1. All subject to Jaipur jurisdiction only.</td>
            <td></td>
        </tr>

        <tr>
            <td colspan="4">2. Goods once sold will not be taken back.</td>
            <td></td>
        </tr>

        <tr>
            <td colspan="4">3. E. & O.E.</td>
            <td class="text-end">Authorised Signature</td>
        </tr>
        <tr>
            <td colspan="5" class="text-center">This Invoice is computer generated, no signature required</td>
        </tr>
    </table>
</body>

</html>
<?php
$html = ob_get_clean();
$mpdf->WriteHTML($html);
$mpdf->Output($invoiceNo . '.pdf', 'I');
?>