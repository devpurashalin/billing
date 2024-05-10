<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Due Amount</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        @media print {
            .container {
                width: 100%;
                max-width: none;
                padding: 0;
            }
        }
    </style>
</head>

<body>
    <?php include "navbar.php"; ?>
    <div class="container my-5">
        <table class="table table-bordered">
            <tr>
                <th>Party ID</th>
                <th>Party Name</th>
                <th>Mobile No</th>
                <th>Due Amount</th>
            </tr>
            <?php
            $sql = "SELECT * FROM party WHERE status != 'DELETED'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $partyId = $row['ID'];
                    $partyName = $row['name'];
                    $number = $row['number'];
                    $sql1 = "SELECT SUM(amount) AS total, SUM(amountReceived) AS amountReceived FROM invoicetotal WHERE partyId = '$partyId' AND (paymentStatus = 'NIL' OR paymentStatus = 'Partial Received')";
                    $result1 = $conn->query($sql1);
                    $row1 = $result1->fetch_assoc();
                    $amountReceived = $row1['amountReceived'];
                    $total = $row1['total'];
                    $dueAmount = $total - $amountReceived;
                    if ($dueAmount == 0) {
                        continue;
                    }
            ?>
                    <tr>
                        <td><?php echo $partyId; ?></td>
                        <td><?php echo $partyName; ?></td>
                        <td><?php echo $number; ?></td>
                        <td><?php echo $dueAmount; ?></td>
                    </tr>
            <?php
                }
            }
            ?>
        </table>
    </div>
</body>

</html>