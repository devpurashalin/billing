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
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-5">
        <form action="./partyModify.php" method="post">
            <table class="table table-bordered">
                <tr>
                    <td><label for="ID">Customer ID No</label></td>
                    <td>:</td>
                    <td><input type="text" name="ID" id="ID" class="form-control" required></td>
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
                    <td><label for="GST_PAN">GST/PAN</label></td>
                    <td>:</td>
                    <td><input type="text" name="GST_PAN" id="GST_PAN" class="form-control" required></td>
                </tr>
                <tr>
                    <td class="text-center" colspan="3"><button class="btn btn-primary" type="submit">SUBMIT</button></td>
                </tr>
            </table>
        </form>
        <div class="h3 text-center">List of All Customers</div>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Customer ID No.</th>
                    <th>Name of Customer</th>
                    <th>Address</th>
                    <th>Mobile Number</th>
                    <th>GST/PAN</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM party";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['ID'] . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['address'] . "</td>";
                        echo "<td>" . $row['number'] . "</td>";
                        echo "<td>" . $row['GST_PAN'] . "</td>";
                        echo "<td><a class='text-dark' href='partyModify.php?id=" . $row['ID'] . "'><i class='fa fa-trash'></i></a></td>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No Data Found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>