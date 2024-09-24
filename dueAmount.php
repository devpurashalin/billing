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
        <div class="container mb-3 row">
            <div class="col-md col-0">
                <!-- <button class="btn btn-dark" onclick="CSVConvert()">Download as CSV</button> -->
                <button class="btn btn-dark" onclick="ExcelConvert()">Download as Excel</button>
            </div>
            <div class="col-md-4">
                <input class="form-control" onkeyup="search(this);" type="text" id="searchInput" placeholder="Search">
            </div>
        </div>
        <table id="DueAmount" class="table table-bordered">
            <thead>
                <tr>
                    <th class="bg-light">Customer ID</th>
                    <th class="bg-light">Customer Name</th>
                    <th class="bg-light">Mobile No</th>
                    <th class="bg-light">Due Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM party WHERE status != 'DELETED'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $partyId = $row['ID'];
                        $partyName = $row['name'];
                        $number = $row['number'];
                        $sql1 = "SELECT SUM(amount) AS total, SUM(amountReceived) AS amountReceived, SUM(discount) AS discount FROM invoicetotal WHERE partyId = '$partyId'";
                        $result1 = $conn->query($sql1);
                        $row1 = $result1->fetch_assoc();
                        $amountReceived = $row1['amountReceived'];
                        $total = $row1['total'];
                        $discount = $row1['discount'];
                        $dueAmount = $total - $amountReceived - $discount;
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
            </tbody>
        </table>
    </div>
    <script>
        function search(input) {
            let inputValue = input.value.toLowerCase();
            let rows = document.querySelectorAll("#DueAmount tbody tr");

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
            var table = document.getElementById('DueAmount');
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
                navigator.msSaveBlob(blob, 'DueAmount.csv');
            } else {
                var link = document.createElement('a');
                if (link.download !== undefined) {
                    var url = URL.createObjectURL(blob);
                    link.setAttribute('href', url);
                    link.setAttribute('download', 'DueAmount.csv');
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
            const table = document.getElementById('DueAmount');
            const wb = XLSX.utils.table_to_book(table);
            XLSX.writeFile(wb, 'Due Amount.xlsx');
        }
    </script>
</body>

</html>