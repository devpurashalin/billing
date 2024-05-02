<?php
// include 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['submit'] == "Print") {
    include "invoiceSave.php";
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
        }
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div class="my-5 container" id="forPrint">
        <table class="table" id="invoiceTable">
            <tr>
                <td class="py-0">PAN No.: ABCED1234E</td>
                <th class="text-center py-0" colspan="3">
                    <img src="./ganesh.jpeg" width="50px" alt="">
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
                <td><?php echo $date; ?></td>
            </tr>
            <tr>
                <td class=""><label for="partyName">Name of Party</label></td>
                <td colspan="2"><?php echo $_POST['partyName']; ?></td>
                <td class=""><label for="GST_PAN">GST/PAN</label></td>
                <td><?php echo $_POST['GST_PAN']; ?></td>
            </tr>
            <tr>
                <td class=""><label for="address">Address</label></td>
                <td colspan="2"><?php echo $_POST['address']; ?></td>
                <td class=""><label for="number">Mobile No.</label></td>
                <td><?php echo $_POST['number']; ?></td>
            </tr>
            <tr class="forBorder heading">
                <td class="fw-bold bg-warning">S. No.</td>
                <td class="fw-bold bg-warning">Description</td>
                <td class="fw-bold bg-warning">Qty.</td>
                <td class="fw-bold bg-warning">Rate</td>
                <td class="fw-bold bg-warning">Amount Rs.</td>
            </tr>
            <?php
            $count = 1;
            while (isset($_POST["sno" . $count])) {
                echo '<tr class="forBorder"><td>' . $_POST["sno" . $count] . '</td>';
                echo '<td>' . $_POST["description" . $count] . '</td>';
                echo '<td>' . $_POST["qty" . $count] . '</td>';
                echo '<td>' . $_POST["rate" . $count] . '</td>';
                echo '<td>' . $_POST["amount_rs" . $count] . '</td></tr>';
                $count++;
            }
            while ($count < 17) {
                echo '<tr class="forBorder"><td></td><td></td><td></td><td></td><td></td></tr>';
                $count++;
                echo "<script>console.log('Debug Objects: " . $count . "' );</script>";
            }
            ?>
            <div>
                <tr class="forBorder heading fw-bold">
                    <td colspan="4" class="text-end">Total Amount</td>
                    <td><?php echo $TotalAmount; ?></td>
                </tr>
                <tr>
                    <td colspan="5">Rs. (in words): <?php echo $_POST['total_amt_words']; ?></td>
                </tr>
                <tr>
                    <td class="py-0" colspan="4"><b>Terms and Conditions:</b></td>
                    <td class="py-0" style="color: red;">For: <b>Deepak Printers</b></td>
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
            </div>
        </table>
    </div>
    <script>
        window.onload = function() {
            // window.print();
        }
    </script>
</body>

</html>