<?php
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ID = $_POST['ID'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $number = $_POST['number'];
    $GST_PAN = $_POST['GST_PAN'];
    $sql = "INSERT INTO party (ID, name, address, number, GST_PAN) VALUES ('$ID', '$name', '$address', '$number', '$GST_PAN')";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('New record created successfully');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-5">
        <form action="partyList" method="post">
            <table class="table table-bordered">
                <tr>
                    <td><label for="ID">Party ID No</label></td>
                    <td>:</td>
                    <td><input type="text" name="ID" id="ID" class="form-control" required></td>
                </tr>
                <tr>
                    <td><label for="name">Name of Party</label></td>
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
                    <th>Party ID No.</th>
                    <th>Name of Party</th>
                    <th>Address</th>
                    <th>Mobile Number</th>
                    <th>GST/PAN</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM party";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr><td>" . $row['ID'] . "</td><td>" . $row['name'] . "</td><td>" . $row['address'] . "</td><td>" . $row['number'] . "</td><td>" . $row['GST_PAN'] . "</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No Data Found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>