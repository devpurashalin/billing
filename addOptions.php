<?php
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['type'] == 'Adding') {
        $addingFor = $_POST['addingFor'];
        $content = $_POST['content'];
        $sql = "INSERT INTO $addingFor (value) VALUES ('$content')";
        try {
            $conn->query($sql);
            $_SESSION['message'] = "$content added successfully to $addingFor";
        } catch (Exception $e) {
            $_SESSION['error'] = "Error: " . $e->getMessage();
        }
    }
}
$sql = "SELECT * FROM `invoiceitem` ORDER BY `value` ASC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $InvoiceItemData = array();
    while ($row = $result->fetch_assoc()) {
        $InvoiceItemData[] = $row;
    }
    echo "<script>const InvoiceItemData = " . json_encode($InvoiceItemData) . ";</script>";
}
$sql = "SELECT * FROM `paymentmode` ORDER BY `value` ASC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $PaymentModeData = array();
    while ($row = $result->fetch_assoc()) {
        $PaymentModeData[] = $row;
    }
    echo "<script>const PaymentModeData = " . json_encode($PaymentModeData) . ";</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Options</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        th,
        td {
            border: 0px !important;
        }
    </style>
</head>

<body>
    <?php include "navbar.php"; ?>
    <div class="container my-5">
        <form class="addOptionForm" action="addOptions" method="post">
            <table class="table">
                <tr>
                    <th><label class="fw-normal" for="addingFor">Adding for</label></th>
                    <td>
                        <select class="form-control" name="addingFor" id="addingFor" required>
                            <option disabled selected value="">Select</option>
                            <option value="invoiceitem">Invoice Item</option>
                            <option value="paymentmode">Payment Mode</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label class="fw-normal" for="content">Content to be added</label></th>
                    <td><input class="form-control" type="text" name="content" id="content" placeholder="Write here"
                            required></td>
                </tr>
                <tr>
                    <td class="text-center" colspan="2"><button class="btn btn-primary" type="submit">Submit</button>
                    </td>
                </tr>
                <input type="hidden" name="type" value="Adding">
            </table>
        </form>

        <div class="row ">
            <div class="col-12 col-md-6">
                <div class="h5 text-center">Invoice Item</div>
                <table id="invoiceitem" class="table table-bordered">
                    <tbody></tbody>
                    <!-- <?php
                            $sql = "SELECT * FROM `invoiceitem` ORDER BY `value` ASC";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?php echo $row['value']; ?></td>
                                <td class="d-flex">
                                    <i class="fas fa-edit text-primary" onclick="edit('<?php echo $row['value']; ?>', 'invoiceitem')"></i>
                                </td>
                                <td>
                                    <a href="deleteOption.php?table=invoiceitem&id=<?php echo $row['value']; ?>">
                                        <i class="fas fa-trash text-danger"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php
                            }
                        ?> -->
                </table>

                <nav>
                    <ul class="pagination" id="paginationInvoiceItem"></ul>
                </nav>
            </div>
            <div class="col-12 col-md-6">
                <div class="text-center h5">Payment Mode</div>
                <table id="paymentmode" class="table table-bordered border-warning">
                    <tbody></tbody>
                    <!-- <?php
                            $sql = "SELECT * FROM `paymentmode` ORDER BY `value` ASC";
                            $result = $conn->query($sql);
                            while ($row = $result->fetch_assoc()) {
                            ?>
                        <tr>
                            <td><?php echo $row['value']; ?></td>
                            <td class="d-flex">
                                <i onclick="edit('<?php echo $row['value']; ?>', 'paymentmode')" class="fas fa-edit text-primary"></i>
                            </td>
                            <td>
                                <a href="deleteOption.php?table=paymentmode&id=<?php echo $row['value']; ?>">
                                    <i class="fas fa-trash text-danger"></i>
                                </a>
                            </td>
                        </tr>
                    <?php
                            }
                    ?> -->
                </table>
                <nav>
                    <ul class="pagination" id="paginationPaymentMode"></ul>
                </nav>
            </div>
        </div>

        <script>
            function edit(id, table) {
                let edit = prompt("Edit " + id + " to:");
                if (edit) {
                    window.location.href = `editOption.php?table=${table}&id=${id}&edit=${edit}`;
                } else {
                    alert("Please enter a valid value");
                }
            }
        </script>
    </div>

    <script>
        function matchStringInArray(array, searchString) {
            return array.filter(item => {
                return Object.values(item).some(value =>
                    value.toString().toLowerCase().includes(searchString.toLowerCase())
                );
            });
        }

        let matchedResultsInvoice = matchStringInArray(InvoiceItemData, ""); // Store the results in a variable

        // Pagination variables
        let currentPage = 1;
        const rowsPerPage = 10;

        // Function to display table rows based on the current page
        function displayTableRowsInvoice(page) {
            const tableBody = document.querySelector("#invoiceitem tbody");
            tableBody.innerHTML = "";

            const startIndex = (page - 1) * rowsPerPage;
            const endIndex = startIndex + rowsPerPage;

            const rows = matchedResultsInvoice.slice(startIndex, endIndex);
            rows.forEach(row => {
                const tr = document.createElement("tr");
                tr.innerHTML = `
                <td>${row.value}</td>
                <td class="d-flex">
                    <i class="fas fa-edit text-primary" onclick="edit('${row.value}', 'invoiceitem')"></i>
                </td>
                <td>
                    <a href="deleteOption.php?table=invoiceitem&id=${row.value}">
                        <i class="fas fa-trash text-danger"></i>
                    </a>
                </td>
            `;
                tableBody.appendChild(tr);
            });
        }

        // Function to set up pagination controls with "Next" and "Previous"
        function setupPaginationInvoice() {
            const pagination = document.getElementById("paginationInvoiceItem");
            pagination.innerHTML = "";

            const pageCount = Math.ceil(matchedResultsInvoice.length / rowsPerPage);

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
                    displayTableRowsInvoice(currentPage);
                    setupPaginationInvoice();
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
                    displayTableRowsInvoice(currentPage);
                    setupPaginationInvoice();
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
                    displayTableRowsInvoice(currentPage);
                    setupPaginationInvoice();
                }
            });
            pagination.appendChild(nextLi);
        }

        // Initial setup
        displayTableRowsInvoice(currentPage);
        setupPaginationInvoice();

        let matchedResultsPayment = matchStringInArray(PaymentModeData, ""); // Store the results in a variable
        // Function to display table rows based on the current page
        function displayTableRowsPayment(page) {
            const tableBody = document.querySelector("#paymentmode tbody");
            tableBody.innerHTML = "";

            const startIndex = (page - 1) * rowsPerPage;
            const endIndex = startIndex + rowsPerPage;

            const rows = matchedResultsPayment.slice(startIndex, endIndex);
            rows.forEach(row => {
                const tr = document.createElement("tr");
                tr.innerHTML = `
                <td>${row.value}</td>
                <td class="d-flex">
                    <i class="fas fa-edit text-primary" onclick="edit('${row.value}', 'paymentmode')"></i>
                </td>
                <td>
                    <a href="deleteOption.php?table=paymentmode&id=${row.value}">
                        <i class="fas fa-trash text-danger"></i>
                    </a>
                </td>
            `;
                tableBody.appendChild(tr);
            });
        }

        // Function to set up pagination controls with "Next" and "Previous"
        function setupPaginationPayment() {
            const pagination = document.getElementById("paginationPaymentMode");
            pagination.innerHTML = "";

            const pageCount = Math.ceil(matchedResultsPayment.length / rowsPerPage);

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
                    displayTableRowsPayment(currentPage);
                    setupPaginationPayment();
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
                    displayTableRowsPayment(currentPage);
                    setupPaginationPayment();
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
                    displayTableRowsPayment(currentPage);
                    setupPaginationPayment();
                }
            });
            pagination.appendChild(nextLi);
        }

        // Initial setup
        displayTableRowsPayment(currentPage);
        setupPaginationPayment();
    </script>
</body>

</html>