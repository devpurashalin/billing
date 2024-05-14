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
        <div class="container mb-3 row">
            <div class="col-md col-0"></div>
            <div class="col-md-4">
                <input class="form-control" onkeyup="search(this);" type="text" id="searchInput" placeholder="Search">
            </div>
        </div>
        <table class="table table-bordered" id="invoiceData">
            <thead>
                <tr>
                    <th>Invoice No</th>
                    <th>Customer ID</th>
                    <th>Customer Name</th>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Payment Status</th>
                    <th>Amount Received</th>
                    <th>Payment Mode</th>
                    <th>Discount, if any</th>
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
                            <td><a href="invoiceView?invoiceNo=<?php echo $row['invoiceNo']; ?>"><?php echo $row['invoiceNo']; ?></a></td>
                            <td><?php echo $row['partyId']; ?></td>
                            <td><?php echo $row['partyName']; ?></td>
                            <td><?php echo $row['date']; ?></td>
                            <td><?php echo $row['amount']; ?></td>
                            <td><?php echo $row['paymentStatus']; ?></td>
                            <td><?php echo $row['amountReceived']; ?></td>
                            <td><?php echo $row['paymentMode']; ?></td>
                            <td><?php echo $row['discount']; ?></td>

                        </tr>
                <?php
                    }
                }
                ?>
                </tbody>
        </table>
    </div>
    <script>
        function search(input) {
            let inputValue = input.value.toLowerCase();
            let rows = document.querySelectorAll("#invoiceData tbody tr");

            rows.forEach(row => {
                let rowData = row.textContent.toLowerCase();
                if (rowData.includes(inputValue)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        }
    </script>
</body>

</html>