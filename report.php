<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Invoices</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        th {
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <?php include "navbar.php"; ?>
    <div class="container my-5">

    </div>
    <div class="container my-5">
        <div class="container mb-3 row">
            <form class="form col-12 col-lg-7 row" action="report" method="post">
                <div class="col-12 col-md-4">
                    <label for="datefrom">Date from</label>
                    <input class="form-control" type="date" name="datefrom" id="datefrom">
                </div>
                <div class="col-12 col-md-4">
                    <label for="dateto">Date to</label>
                    <input class="form-control" type="date" name="dateto" id="dateto">
                </div>
                <div class="col-12 col-md-4">
                    <br>
                    <button class="btn btn-primary">Submit</button>
                </div>
            </form>
            <div class="col-12 col-lg-5 row">
                <div class="col-md-7">
                    <br>
                    <button class="btn btn-dark" onclick="ExcelConvert()">Download as Excel</button>
                </div>
                <div class="col-md-5">
                    <br>
                    <input class="form-control" onkeyup="search(this);" type="text" id="searchInput" placeholder="Search">
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered" id="invoiceData">
                <thead>
                    <tr>
                        <th class="bg-light">Invoice No</th>
                        <th class="bg-light">Customer Name</th>
                        <th class="bg-light">Invoice Date</th>
                        <th class="bg-light">Amount</th>
                        <th class="bg-light">Amount Received</th>
                        <th class="bg-light">Payment Mode</th>
                        <th class="bg-light">Payment Date</th>
                        <th class="bg-light">Discount</th>
                        <th class="bg-light">Remark</th>
                    </tr>
                </thead>
                <?php
                if ($_SERVER['REQUEST_METHOD'] == "POST") {
                    $datefrom = $_POST['datefrom'];
                    $dateto = $_POST['dateto'];
                    $sql = "SELECT * FROM `invoicetotal` WHERE STR_TO_DATE(date, '%Y-%m-%d') BETWEEN '$datefrom' AND '$dateto';";
                ?>
                    <script>
                        document.getElementById('datefrom').value = "<?php echo htmlspecialchars($datefrom, ENT_QUOTES, 'UTF-8'); ?>";
                        document.getElementById('dateto').value = "<?php echo htmlspecialchars($dateto, ENT_QUOTES, 'UTF-8'); ?>";
                    </script>
                <?php
                } else {
                    $sql = "SELECT * FROM `invoicetotal`";
                }
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                ?>

                    <tbody>
                        <?php
                        while ($row = $result->fetch_assoc()) {
                        ?>
                            <tr>
                                <td><a href="invoiceView?invoiceNo=<?php echo $row['invoiceNo']; ?>"><?php echo $row['invoiceNo']; ?></a></td>
                                <td><?php echo $row['partyName']; ?></td>
                                <td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
                                <td><?php echo $row['amount']; ?></td>
                                <td><?php echo $row['amountReceived']; ?></td>
                                <td><?php echo $row['paymentMode']; ?></td>
                                <td><?php echo isset($row['dateOfPayment']) && ($row['dateOfPayment'] != NULL || $row['dateOfPayment'] != "") ? date('d-m-Y', strtotime($row['dateOfPayment'])) : ""; ?></td>
                                <td><?php echo $row['discount']; ?></td>
                                <td><?php echo $row['remark']; ?></td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                    </tbody>
            </table>
        </div>
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

        function CSVConvert() {
            var table = document.getElementById('invoiceData');
            var rows = table.rows;
            var csvContent = '';

            for (var i = 0; i < rows.length; i++) {
                if (rows[i].style.display !== 'none') {
                    var cells = rows[i].cells;
                    for (var j = 0; j < cells.length; j++) {
                        csvContent += cells[j].innerText + (j < cells.length - 1 ? ',' : '');
                    }
                    csvContent += '\n';
                }
            }

            var blob = new Blob([csvContent], {
                type: 'text/csv;charset=utf-8;'
            });
            if (navigator.msSaveBlob) {
                navigator.msSaveBlob(blob, 'All Invoices.csv');
            } else {
                var link = document.createElement('a');
                if (link.download !== undefined) {
                    var url = URL.createObjectURL(blob);
                    link.setAttribute('href', url);
                    link.setAttribute('download', 'All Invoices.csv');
                    link.style.visibility = 'hidden';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                }
            }
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
    <script>
        function ExcelConvert() {
            const table = document.getElementById('invoiceData');
            const wb = XLSX.utils.table_to_book(table);
            XLSX.writeFile(wb, 'All Invoices.xlsx');
        }
    </script>
</body>

</html>