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

        #partyForm {
            border: 1px solid rgba(0, 0, 0, 0.5);
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
                    <td><input type="text" oninput="capitalize()" name="name" id="name" class="form-control" required></td>
                </tr>
                <tr>
                    <td><label for="address">Address</label></td>
                    <td>:</td>
                    <td><input type="text" oninput="capitalize()" name="address" id="address" class="form-control" required></td>
                </tr>
                <tr>
                    <td><label for="number">Mobile Number</label></td>
                    <td>:</td>
                    <td><input type="text" name="number" id="number" class="form-control" pattern="[0-9]{10}" title="Please enter a 10-digit number" required></td>
                </tr>
                <tr>
                    <td><label for="email">Email</label></td>
                    <td>:</td>
                    <td><input type="email" name="email" id="email" class="form-control" required></td>
                </tr>
                <tr>
                    <td><label for="GST_PAN">GST/PAN</label></td>
                    <td>:</td>
                    <td><input type="text" oninput="capitalize()" name="GST_PAN" id="GST_PAN" class="form-control" required></td>
                </tr>
                <tr>
                    <td class="text-center" colspan="3"><button class="btn btn-primary" name="submit" value="add" type="submit">SUBMIT</button></td>
                </tr>
            </table>
        </form>
        <div class="h3 text-center">List of All Customers</div>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Customer ID</th>
                    <th>Name of Customer</th>
                    <th>Address</th>
                    <th>Mobile Number</th>
                    <th>Email</th>
                    <th>GST/PAN</th>
                    <th>Edit</th>
                    <th>Delete</th>
                    <th>Inactive/<br>Active</th>
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
                        echo "<td><a class='text-dark' href='partyModify.php?id=" . $row['ID'] . "&action=edit'><i class='fa fa-edit'></i></a>";
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
            var x = document.getElementById("name");
            x.value = x.value.toUpperCase();
            var y = document.getElementById("address");
            y.value = y.value.toUpperCase();
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
</body>

</html>