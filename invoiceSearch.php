<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Invoice</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
    <?php include "navbar.php"; ?>
    <div class="container my-5">
        <form action="invoiceSearch" method="POST">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="invoiceNo" class="form-control" placeholder="Enter Invoice No">
                    
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </div>
        </form>
        <table class="table table-bordered my-5">
            <tr>
                <th>Invoice No</th>
                <th>Party ID</th>
                <th>Party Name</th>
                <th>Number</th>
                <th>Date</th>
                <th>Total Amount</th>
                <th>Action</th>
            </tr>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $invoiceNo = $_POST['invoiceNo'];
                $sql = "SELECT * FROM invoicetotal WHERE invoiceNo = '$invoiceNo'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $invoiceNo = $row['invoiceNo'];
                        $partyId = $row['partyId'];
                        $partyName = $row['partyName'];
                        $number = $row['number'];
                        $date = $row['date'];
                        $TotalAmount = $row['amount'];
            ?>
                        <tr>
                            <td><?php echo $invoiceNo; ?></td>
                            <td><?php echo $partyId; ?></td>
                            <td><?php echo $partyName; ?></td>
                            <td><?php echo $number; ?></td>
                            <td><?php echo $date; ?></td>
                            <td><?php echo $TotalAmount; ?></td>
                            <td>
                                <a href="invoiceView.php?invoiceNo=<?php echo $invoiceNo; ?>" class="btn btn-primary">View</a>
                    </td>
                        </tr>
            <?php
                    }
                } else {
                    echo "No record found";
                }
            }
            ?>
        </table>
    </div>

</body>

</html>