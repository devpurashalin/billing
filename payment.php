<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        function formSubmit() {
            if (document.getElementById('partyName').value == "" && document.getElementById('invoiceNo').value == "") {
                document.getElementById('formError').innerHTML = "*Please select any one field";
                return false;
            } else {
                document.querySelector('form').submit();
            }
        }
    </script>
    <style>
        input,
        select {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        td,
        th {
            padding-left: 3px !important;
            padding-right: 3px !important;
            font-size: medium;
        }

        th {
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <?php include "navbar.php"; ?>
    <div class="container my-5">
        <form action="payment" method="POST">
            <div class="row">
                <div class="col-md-3">
                    Party Name
                    <select onchange="document.getElementById('invoiceNo').value = ''" class="form-control" name="partyName" id="partyName">
                        <option disabled value="" selected>Select</option>
                        <?php
                        $sql = "SELECT * FROM party WHERE `status` <> 'DELETED'";
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
                    <select onchange="document.getElementById('partyName').value = ''" class="form-control" name="invoiceNo" id="invoiceNo">
                        <option disabled value="" selected>Select</option>
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
                <div class="col-md-3">
                    <br>
                    <button type="button" onclick="formSubmit()" class="btn btn-primary">Search</button>
                    <br>
                    <p id="formError" class="text-danger"></p>
                </div>
            </div>
        </form>
        <table class="table table-bordered my-5">
            <tr>
                <th style="width: 10%;">Invoice No</th>
                <th>Name</th>
                <th style="width: 10%;">Amount</th>
                <th style="width: 10%;">Payment Mode</th>
                <th style="width: 10%;">Amount Received</th>
                <th style="width: 8%;">Date of Payment</th>
                <th>Discount / Remark</th>
                <th style="width: 8%;">Action</th>
            </tr>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST['invoiceNo']) && $_POST['invoiceNo'] != "") {
                    $invoiceNo = $_POST['invoiceNo'];
                    $sql = "SELECT * FROM invoicetotal WHERE invoiceNo = '$invoiceNo'";
                } else if (isset($_POST['partyId']) && $_POST['partyId'] != "") {
                    $partyId = $_POST['partyId'];
                    $sql = "SELECT * FROM invoicetotal WHERE partyId = '$partyId'";
                } else if (isset($_POST['partyName']) && $_POST['partyName'] != "") {
                    $partyName = $_POST['partyName'];
                    $sql = "SELECT * FROM invoicetotal WHERE partyName = '$partyName'";
                } else {
                    exit;
                }
            } else {
                exit;
            }
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $count = 0;
                while ($row = $result->fetch_assoc()) {
                    $count++;
                    $invoiceNo = $row['invoiceNo'];
                    $partyName = $row['partyName'];
                    $date = $row['date'];
                    $TotalAmount = $row['amount'];
                    $dateOfPayment = $row['dateOfPayment'];
                    $remark = $row['remark'];
            ?>
                    <tr>
                        <td><a target="_blank" href="invoiceView.php?invoiceNo=<?php echo $invoiceNo; ?>"><?php echo $invoiceNo; ?></a></td>
                        <td><?php echo $partyName; ?></td>
                        <td id="totalAmount<?php echo $count; ?>"><?php echo $TotalAmount; ?></td>
                        <form action="invoiceUpdate" method="post">
                            <input type="hidden" name="invoiceNo" value="<?php echo $invoiceNo; ?>">
                            <input type="hidden" name="totalAmount" value="<?php echo $TotalAmount; ?>">
                            <td>
                                <select class="form-control" name="paymentMode" id="paymentMode<?php echo $count; ?>">
                                    <option value="" selected>Select</option>
                                    <?php
                                    $paymentMode = $row['paymentMode'];
                                    $tempsql = "SELECT * FROM `paymentmode`;";
                                    $tempresult = $conn->query($tempsql);
                                    if ($tempresult->num_rows > 0) {
                                        while ($temprow = $tempresult->fetch_assoc()) {
                                            $selected = "";
                                            if ($paymentMode == $temprow['value']) {
                                                $selected = "selected";
                                            }
                                            echo "<option value='" . $temprow['value'] . "' $selected>" . $temprow['value'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </td>
                            <td>
                                <input type="number" id="amountReceived<?php echo $count; ?>" name="amountReceived" class="form-control" value="<?php echo $row['amountReceived']; ?>">
                            </td>
                            <td><input type="date" class="form-control" name="dateOfPayment" id="dateOfPayment<?php echo $count; ?>" value="<?php echo $dateOfPayment; ?>"></td>
                            <td><input type="text" class="form-control" name="remark" id="reamrk<?php echo $count; ?>" value="<?php echo $remark; ?>"></td>
                            <td>
                                <button type="submit" class="btn btn-primary px-1">Update</button>
                            </td>
                        </form>
                    </tr>
            <?php
                }
            }
            ?>
    </div>
</body>

</html>