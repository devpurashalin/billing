<?php
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ID = $_POST['ID'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $GST_PAN = $_POST['GST_PAN'];
    if ($_POST['submit'] == "add") {
        $sql = "INSERT INTO party (ID, name, address, number, email, GST_PAN, status) VALUES ('$ID', '$name', '$address', '$number', '$email', '$GST_PAN', 'ACTIVE')";
    } else if ($_POST['submit'] == "edit") {
        $sql = "UPDATE party SET name = '$name', address = '$address', number = '$number', email = '$email', GST_PAN = '$GST_PAN' WHERE ID = '$ID'";
    }
    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('New record created successfully');
                window.location.href = 'partyList';
              </script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = $_GET['id'];
    $action = $_GET['action'];
    echo $id . "<br>";
    echo $action;
    if ($action == "delete") {
        $sql = "UPDATE party SET status = 'DELETED' WHERE ID = '$id'";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Record deleted successfully');window.location.href = 'partyList';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else if ($action == "ACTIVE" || $action == "INACTIVE") {
        if ($action == "ACTIVE") {
            $sql = "UPDATE party SET status = 'ACTIVE' WHERE ID = '$id'";
        } else {
            $sql = "UPDATE party SET status = 'INACTIVE' WHERE ID = '$id'";
        }
        if (mysqli_query($conn, $sql)) {
            echo "<script>
                    alert('Record " . $action . "D successfully');
                    window.location.href = 'partyList';
                  </script>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else if ($action == "edit") {
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Party Modify</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        </head>

        <body>
            <?php include 'navbar.php'; ?>
            <div class="container mt-5">
                <form action="./partyModify" method="post">
                    <table class="table table-bordered">
                        <?php
                        $sql = "SELECT * FROM party WHERE ID = '$id'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        ?>
                        <input type="hidden" name="ID" value="<?php echo $id; ?>">
                        <tr>
                            <td><label for="name">Name of Customer</label></td>
                            <td>:</td>
                            <td><input type="text" name="name" id="name" class="form-control" value="<?php echo $row['name'] ?>" required></td>
                        </tr>
                        <tr>
                            <td><label for="address">Address</label></td>
                            <td>:</td>
                            <td><input type="text" name="address" id="address" class="form-control" value="<?php echo $row['address'] ?>" required></td>
                        </tr>
                        <tr>
                            <td><label for="number">Mobile Number</label></td>
                            <td>:</td>
                            <td><input type="text" name="number" id="number" class="form-control" pattern="[0-9]{10}" title="Please enter a 10-digit number" value="<?php echo $row['number'] ?>" required></td>
                        </tr>
                        <tr>
                            <td><label for="email">Email</label></td>
                            <td>:</td>
                            <td><input type="email" name="email" id="email" class="form-control" value="<?php echo $row['email'] ?>" required></td>
                        </tr>
                        <tr>
                            <td><label for="GST_PAN">GST/PAN</label></td>
                            <td>:</td>
                            <td><input type="text" name="GST_PAN" id="GST_PAN" class="form-control" value="<?php echo $row['GST_PAN'] ?>" required></td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="3"><button class="btn btn-primary" name="submit" value="edit" type="submit">SUBMIT</button></td>
                        </tr>
                    </table>
        </body>
<?php
    }
}
