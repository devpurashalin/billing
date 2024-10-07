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

        .page-link:hover {
            cursor: pointer;
            background-color: gray;
            font-weight: bold;
            color: white;
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

    </div>
    <div class="container my-5">
        <div class="container mb-3 row">
            <form class="form col-12 col-lg-8 row" action="report" method="post">
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
            <div class="col-12 col-lg-4 row">
                <div class="col-md-4">
                    <br>
                    <button class="btn excel" onclick="ExcelConvert()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 50 50">
                            <path
                                d="M 28.875 0 C 28.855469 0.0078125 28.832031 0.0195313 28.8125 0.03125 L 0.8125 5.34375 C 0.335938 5.433594 -0.0078125 5.855469 0 6.34375 L 0 43.65625 C -0.0078125 44.144531 0.335938 44.566406 0.8125 44.65625 L 28.8125 49.96875 C 29.101563 50.023438 29.402344 49.949219 29.632813 49.761719 C 29.859375 49.574219 29.996094 49.296875 30 49 L 30 44 L 47 44 C 48.09375 44 49 43.09375 49 42 L 49 8 C 49 6.90625 48.09375 6 47 6 L 30 6 L 30 1 C 30.003906 0.710938 29.878906 0.4375 29.664063 0.246094 C 29.449219 0.0546875 29.160156 -0.0351563 28.875 0 Z M 28 2.1875 L 28 6.53125 C 27.867188 6.808594 27.867188 7.128906 28 7.40625 L 28 42.8125 C 27.972656 42.945313 27.972656 43.085938 28 43.21875 L 28 47.8125 L 2 42.84375 L 2 7.15625 Z M 30 8 L 47 8 L 47 42 L 30 42 L 30 37 L 34 37 L 34 35 L 30 35 L 30 29 L 34 29 L 34 27 L 30 27 L 30 22 L 34 22 L 34 20 L 30 20 L 30 15 L 34 15 L 34 13 L 30 13 Z M 36 13 L 36 15 L 44 15 L 44 13 Z M 6.6875 15.6875 L 12.15625 25.03125 L 6.1875 34.375 L 11.1875 34.375 L 14.4375 28.34375 C 14.664063 27.761719 14.8125 27.316406 14.875 27.03125 L 14.90625 27.03125 C 15.035156 27.640625 15.160156 28.054688 15.28125 28.28125 L 18.53125 34.375 L 23.5 34.375 L 17.75 24.9375 L 23.34375 15.6875 L 18.65625 15.6875 L 15.6875 21.21875 C 15.402344 21.941406 15.199219 22.511719 15.09375 22.875 L 15.0625 22.875 C 14.898438 22.265625 14.710938 21.722656 14.5 21.28125 L 11.8125 15.6875 Z M 36 20 L 36 22 L 44 22 L 44 20 Z M 36 27 L 36 29 L 44 29 L 44 27 Z M 36 35 L 36 37 L 44 37 L 44 35 Z">
                            </path>
                        </svg>
                    </button>
                </div>
                <div class="col-md-8">
                    <br>
                    <input class="form-control" onkeyup="search(this);" type="text" id="searchInput" placeholder="Search">
                </div>
            </div>
        </div>
        <script>
            document.getElementById('datefrom').value = "<?php echo htmlspecialchars($datefrom, ENT_QUOTES, 'UTF-8'); ?>";
            document.getElementById('dateto').value = "<?php echo htmlspecialchars($dateto, ENT_QUOTES, 'UTF-8'); ?>";
        </script>
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
                    <td><a href="invoiceView?invoiceNo=${row.invoiceNo}">${row.invoiceNo}</a></td>
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