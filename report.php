<?php
include 'db.php';
$datefrom = $_POST['datefrom'] ?? '';
$dateto = $_POST['dateto'] ?? '';
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $sql = "SELECT * FROM `invoicetotal` WHERE STR_TO_DATE(date, '%Y-%m-%d') BETWEEN '$datefrom' AND '$dateto';";
} else {
    $sql = "SELECT * FROM `invoicetotal`";
}
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo "<script>const data = " . json_encode($data) . ";</script>";
}
?>
<script>
    data.forEach(item => {
        Object.keys(item).forEach(key => {
            if (item[key] === null) {
                item[key] = "";
            }
        });
    });
</script>
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
            <script>
                document.getElementById('datefrom').value = "<?php echo htmlspecialchars($datefrom, ENT_QUOTES, 'UTF-8'); ?>";
                document.getElementById('dateto').value = "<?php echo htmlspecialchars($dateto, ENT_QUOTES, 'UTF-8'); ?>";
            </script>
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
                <tbody>
                </tbody>
            </table>
        </div>
        <nav>
            <ul class="pagination" id="pagination"></ul>
        </nav>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
    <script>
        function matchStringInArray(array, searchString) {
            return array.filter(item => {
                return Object.values(item).some(value =>
                    value.toString().toLowerCase().includes(searchString.toLowerCase())
                );
            });
        }

        let matchedResults = matchStringInArray(data, ""); // Store the results in a variable

        // Pagination variables
        let currentPage = 1;
        const rowsPerPage = 5;

        // Function to display table rows based on the current page
        function displayTableRows(page) {
            const tableBody = document.querySelector("#invoiceData tbody");
            tableBody.innerHTML = "";

            const startIndex = (page - 1) * rowsPerPage;
            const endIndex = startIndex + rowsPerPage;

            const rows = matchedResults.slice(startIndex, endIndex);
            rows.forEach(row => {
                const tr = document.createElement("tr");
                tr.innerHTML = `
                    <td>${row.invoiceNo}</td>
                    <td>${row.partyName}</td>
                    <td>${row.date}</td>
                    <td>${row.amount}</td>
                    <td>${row.amountReceived}</td>
                    <td>${row.paymentMode}</td>
                    <td>${row.dateOfPayment}</td>
                    <td>${row.discount}</td>
                    <td>${row.remark}</td>
        `;
                tableBody.appendChild(tr);
            });
        }

        // Function to set up pagination controls with "Next" and "Previous"
        function setupPagination() {
            const pagination = document.getElementById("pagination");
            pagination.innerHTML = "";

            const pageCount = Math.ceil(matchedResults.length / rowsPerPage);

            // Previous Button
            const prevLi = document.createElement("li");
            prevLi.classList.add("page-item");
            prevLi.innerHTML = `<div class="page-link">Previous</div>`;
            if (currentPage === 1) {
                prevLi.classList.add("disabled");
            }
            prevLi.addEventListener("click", () => {
                if (currentPage > 1) {
                    currentPage--;
                    displayTableRows(currentPage);
                    setupPagination();
                }
            });
            pagination.appendChild(prevLi);

            // Page Numbers
            for (let i = 1; i <= pageCount; i++) {
                const li = document.createElement("li");
                li.classList.add("page-item");
                li.innerHTML = `<div class="page-link">${i}</div>`;

                if (i === currentPage) {
                    li.classList.add("active");
                }

                li.addEventListener("click", () => {
                    currentPage = i;
                    displayTableRows(currentPage);
                    setupPagination();
                });

                pagination.appendChild(li);
            }

            // Next Button
            const nextLi = document.createElement("li");
            nextLi.classList.add("page-item");
            nextLi.innerHTML = `<div class="page-link">Next</div>`;
            if (currentPage === pageCount) {
                nextLi.classList.add("disabled");
            }
            nextLi.addEventListener("click", () => {
                if (currentPage < pageCount) {
                    currentPage++;
                    displayTableRows(currentPage);
                    setupPagination();
                }
            });
            pagination.appendChild(nextLi);
        }

        // Initial setup
        displayTableRows(currentPage);
        setupPagination();

        // Search function
        function search(input) {
            const inputValue = input.value.toLowerCase();
            matchedResults = matchStringInArray(data, inputValue);
            currentPage = 1;
            displayTableRows(currentPage);
            setupPagination();
        }

        function ExcelConvert() {
            const ws = XLSX.utils.json_to_sheet(matchedResults);
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "Report");
            XLSX.writeFile(wb, "Report.xlsx");
        }
    </script>
</body>

</html>