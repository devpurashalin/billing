<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
    <?php include "navbar.php"; ?>
    <div class="container my-5">
        <form action="search" method="POST">
            <div class="row">
                <div class="col-md-3">
                    Party ID
                    <select class="form-control" name="partyId" id="partyId">
                        <option disabled selected>Select</option>
                        <?php
                        $sql = "SELECT * FROM party";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['ID'] . "'>" . $row['ID'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-3">
                    Party Name
                    <select class="form-control" name="partyName" id="partyName">
                        <option disabled selected>Select</option>
                        <?php
                        $sql = "SELECT * FROM party";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-3">
                    Invoice Number
                    <select class="form-control" name="invoiceNo" id="invoiceNo">
                        <option disabled selected>Select</option>
                        <?php
                        $sql = "SELECT * FROM invoicetotal";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['invoiceNo'] . "'>" . $row['invoiceNo'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-1">
                    <br>
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </div>
        </form>
        <table class="table table-bordered my-5">
            <tr>
                <th>Invoice No</th>
                <th>Name</th>
                <th>Date</th>
                <th>Amount</th>
                <th>Payment Status</th>
                <th>Payment Mode</th>
                <th>Amount Received</th>
                <th>Discount, if any</th>
                <th>Action</th>
                <th>View</th>
            </tr>
            <?php

            $sql = "SELECT * FROM invoicetotal";
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST['invoiceNo'])) {
                    $invoiceNo = $_POST['invoiceNo'];
                    $sql = "SELECT * FROM invoicetotal WHERE invoiceNo = '$invoiceNo'";
                } else if (isset($_POST['partyId'])) {
                    $partyId = $_POST['partyId'];
                    $sql = "SELECT * FROM invoicetotal WHERE partyId = '$partyId'";
                } else if (isset($_POST['partyName'])) {
                    $partyName = $_POST['partyName'];
                    $sql = "SELECT * FROM invoicetotal WHERE partyName = '$partyName'";
                }
            }
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $invoiceNo = $row['invoiceNo'];
                    $partyName = $row['partyName'];
                    $date = $row['date'];
                    $TotalAmount = $row['amount'];
            ?>
                    <tr>
                        <td><?php echo $invoiceNo; ?></td>
                        <td><?php echo $partyName; ?></td>
                        <td><?php echo $date; ?></td>
                        <td><?php echo $TotalAmount; ?></td>
                        <form action="invoiceUpdate" method="post">
                            <td>
                                <input type="hidden" name="invoiceNo" value="<?php echo $invoiceNo; ?>">
                                <select class="form-control" name="paymentStatus" id="paymentStatus">
                                    <option value="Received" <?php if ($row['paymentStatus'] == "Received") echo "selected"; ?>>Received</option>
                                    <option value="Gift" <?php if ($row['paymentStatus'] == "Gift") echo "selected"; ?>>Gift</option>
                                    <option value="Partial Received" <?php if ($row['paymentStatus'] == "Partial Received") echo "selected"; ?>>Partial Received</option>
                                    <option value="NIL" <?php if ($row['paymentStatus'] == "NIL") echo "selected"; ?>>Due</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-control" name="paymentMode" id="paymentMode">
                                    <option value="">Select</option>
                                    <option value="Cash" <?php if ($row['paymentMode'] == "Cash") echo "selected"; ?>>Cash</option>
                                    <option value="SB Account" <?php if ($row['paymentMode'] == "SB Account") echo "selected"; ?>>SB Account</option>
                                    <option value="Cheque" <?php if ($row['paymentMode'] == "Cheque") echo "selected"; ?>>Cheque</option>
                                    <option value="Paytm" <?php if ($row['paymentMode'] == "Paytm") echo "selected"; ?>>Paytm</option>
                                    <option value="Phonepe" <?php if ($row['paymentMode'] == "Phonepe") echo "selected"; ?>>Phonepe</option>
                                    <option value="Current Account" <?php if ($row['paymentMode'] == "Current Account") echo "selected"; ?>>Current Account</option>

                                </select>
                            </td>
                            <td>
                                <input type="number" name="amountReceived" class="form-control" value="<?php echo $row['amountReceived']; ?>">
                            </td>
                            <td>
                                <input type="text" name="discount" class="form-control" value="<?php echo $row['discount']; ?>">
                            </td>
                            <td>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </td>
                        </form>
                        <td>
                            <a target="_blank" href="invoiceView.php?invoiceNo=<?php echo $invoiceNo; ?>" class="btn btn-primary">View</a>
                        </td>
                    </tr>
            <?php
                }
            }
            ?>
    </div>

</body>

</html>