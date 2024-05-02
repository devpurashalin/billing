<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Invoices</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
    <?php include "navbar.php"; ?>
    <div class="container my-5">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Invoice No</th>
                    <th>Customer ID</th>
                    <th>Customer Name</th>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Payment Status</th>
                </tr>
            </thead>
            <?php
            $sql = "SELECT * FROM `invoicetotal`";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
            ?>

                <tbody>
                    <?php
                    while ($row = $result->fetch_assoc()) {
                    ?>
                        <tr>
                            <td><?php echo $row['invoiceNo']; ?></td>
                            <td><?php echo $row['partyId']; ?></td>
                            <td><?php echo $row['partyName']; ?></td>
                            <td><?php echo $row['date']; ?></td>
                            <td><?php echo $row['amount']; ?></td>
                            <td><?php echo $row['paymentStatus']; ?></td>
                        </tr>
                <?php
                    }
                }
                ?>
                </tbody>
        </table>
    </div>
</body>

</html>