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

        .excel:hover {
            cursor: pointer;
            background-color: grey;
        }

        .excel:hover svg {
            fill: white;
        }
    </style>
</head>

<body>
    <?php include "navbar.php"; ?>
    <div class="container my-5">
        <div class="container mb-3 row">
            <div class="col-md col-0">
                <button class="btn excel" onclick="ExcelConvert()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 50 50">
                        <path
                            d="M 28.875 0 C 28.855469 0.0078125 28.832031 0.0195313 28.8125 0.03125 L 0.8125 5.34375 C 0.335938 5.433594 -0.0078125 5.855469 0 6.34375 L 0 43.65625 C -0.0078125 44.144531 0.335938 44.566406 0.8125 44.65625 L 28.8125 49.96875 C 29.101563 50.023438 29.402344 49.949219 29.632813 49.761719 C 29.859375 49.574219 29.996094 49.296875 30 49 L 30 44 L 47 44 C 48.09375 44 49 43.09375 49 42 L 49 8 C 49 6.90625 48.09375 6 47 6 L 30 6 L 30 1 C 30.003906 0.710938 29.878906 0.4375 29.664063 0.246094 C 29.449219 0.0546875 29.160156 -0.0351563 28.875 0 Z M 28 2.1875 L 28 6.53125 C 27.867188 6.808594 27.867188 7.128906 28 7.40625 L 28 42.8125 C 27.972656 42.945313 27.972656 43.085938 28 43.21875 L 28 47.8125 L 2 42.84375 L 2 7.15625 Z M 30 8 L 47 8 L 47 42 L 30 42 L 30 37 L 34 37 L 34 35 L 30 35 L 30 29 L 34 29 L 34 27 L 30 27 L 30 22 L 34 22 L 34 20 L 30 20 L 30 15 L 34 15 L 34 13 L 30 13 Z M 36 13 L 36 15 L 44 15 L 44 13 Z M 6.6875 15.6875 L 12.15625 25.03125 L 6.1875 34.375 L 11.1875 34.375 L 14.4375 28.34375 C 14.664063 27.761719 14.8125 27.316406 14.875 27.03125 L 14.90625 27.03125 C 15.035156 27.640625 15.160156 28.054688 15.28125 28.28125 L 18.53125 34.375 L 23.5 34.375 L 17.75 24.9375 L 23.34375 15.6875 L 18.65625 15.6875 L 15.6875 21.21875 C 15.402344 21.941406 15.199219 22.511719 15.09375 22.875 L 15.0625 22.875 C 14.898438 22.265625 14.710938 21.722656 14.5 21.28125 L 11.8125 15.6875 Z M 36 20 L 36 22 L 44 22 L 44 20 Z M 36 27 L 36 29 L 44 29 L 44 27 Z M 36 35 L 36 37 L 44 37 L 44 35 Z">
                        </path>
                    </svg>
                </button>
            </div>
            <div class="col-md-4">
                <input class="form-control" onkeyup="search(this);" type="text" id="searchInput" placeholder="Search">
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