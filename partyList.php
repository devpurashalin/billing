<?php
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Party List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        #partyForm tr,
        #partyForm td {
            border: 0px !important;
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
    <?php include 'navbar.php'; ?>
    <div class="container mt-5">
        <form id="partyForm" action="./partyModify" method="post">
            <table class="table table-bordered">
                <tr>
                    <td><label for="ID">Customer ID</label></td>
                    <td>:</td>
                    <?php
                    $sql = "SELECT count(ID) as ID FROM party";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $id = date("Y") . "/" . $row['ID'] + 1;
                    ?>
                    <td><input type="text" name="ID" id="ID" class="form-control" required value="DP/<?php echo $id; ?>"></td>
                </tr>
                <tr>
                    <td><label for="name">Name of Customer</label></td>
                    <td>:</td>
                    <td><input type="text" name="name" id="name" class="form-control" required></td>
                </tr>
                <tr>
                    <td><label for="address">Address</label></td>
                    <td>:</td>
                    <td><input type="text" name="address" id="address" class="form-control" required></td>
                </tr>
                <tr>
                    <td><label for="number">Mobile Number</label></td>
                    <td>:</td>
                    <td><input type="text" name="number" id="number" class="form-control" pattern="[0-9]{10}" title="Please enter a 10-digit number" required></td>
                </tr>
                <tr>
                    <td><label for="email">Email ID</label></td>
                    <td>:</td>
                    <td><input type="email" name="email" id="email" class="form-control"></td>
                </tr>
                <tr>
                    <td><label for="GST_PAN">GSTIN/PAN</label></td>
                    <td>:</td>
                    <td><input type="text" oninput="capitalize()" name="GST_PAN" id="GST_PAN" class="form-control"></td>
                </tr>
                <tr>
                    <td class="text-center" colspan="3"><button class="btn btn-primary" name="submit" value="add" type="submit">SUBMIT</button></td>
                </tr>
            </table>
        </form>
        <div class="h3 text-center">List of All Customers</div>
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
                <input class="form-control" oninput="search(this);" type="text" id="searchInput" placeholder="Search">
            </div>
        </div>
        <table id="partyData" class="table table-bordered table-striped mb-5">
            <thead>
                <tr>
                    <th>Customer ID</th>
                    <th>Name of Customer</th>
                    <th>Address</th>
                    <th>Mobile</th>
                    <th>Email ID</th>
                    <th>GSTIN/PAN</th>
                    <th colspan="3">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM party WHERE status != 'DELETED'";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['ID'] . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['address'] . "</td>";
                        echo "<td>" . $row['number'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['GST_PAN'] . "</td>";
                        echo "<td><a class='text-primary' href='partyModify.php?id=" . $row['ID'] . "&action=edit'><i class='fa fa-edit'></i></a>";
                        echo '<td><i style="cursor: pointer;" class="fa fa-trash text-danger" onclick="deleteConfirm(\'' . $row['ID'] . '\')"></i>';
                        if ($row['status'] == 'ACTIVE') {
                            echo '<td><a class="text-success" href="partyModify.php?id=' . $row['ID'] . '&action=INACTIVE"><i class="fa fa-toggle-on"></i></a></td>';
                        } else {
                            echo '<td><a class="text-danger" href="partyModify.php?id=' . $row['ID'] . '&action=ACTIVE"><i class="fa fa-toggle-off"></i></a></td>';
                        }
                    }
                } else {
                    echo "<tr><td colspan='9'>No Data Found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script>
        function capitalize() {
            var z = document.getElementById("GST_PAN");
            z.value = z.value.toUpperCase();
        }

        function deleteConfirm(id) {
            let confirmation = confirm("Are you sure you want to delete this record?");
            if (confirmation) {
                window.location.href = "partyModify.php?id=" + id + "&action=delete";
            }
        }
    </script>

    <script>
        function search(input) {
            let inputValue = input.value.toLowerCase();
            let rows = document.querySelectorAll("#partyData tbody tr");

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
    <script>
        function ExcelConvert() {
            const table = document.getElementById('partyData');
            const wb = XLSX.utils.table_to_book(table);
            XLSX.writeFile(wb, 'Customers.xlsx');
        }
    </script>
</body>

</html>