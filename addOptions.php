<?php
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $addingFor = $_POST['addingFor'];
    $content = $_POST['content'];
    $sql = "INSERT INTO $addingFor (value) VALUES ('$content')";
    try {
        $conn->query($sql);
        echo "<script>alert('$content added successfully to $addingFor')</script>";
    } catch (Exception $e) {
        echo '<script>alert("Error: ' . $e->getMessage() . '");</script>';
    }


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
</head>

<body>
    <?php include "navbar.php"; ?>
    <div class="container my-5">
        <form action="addOptions" method="post">
            <table class="table table-bordered">
                <tr>
                    <th><label for="addingFor">Adding For</label></th>
                    <td>
                        <select class="form-control" name="addingFor" id="addingFor" required>
                            <option disabled selected value="">Select</option>
                            <option value="invoiceitem">Invoice Item</option>
                            <option value="paymentstatus">Payment Status</option>
                            <option value="paymentmode">Payment Mode</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="content">Content To be Added</label></th>
                    <td><input class="form-control" type="text" name="content" id="content" placeholder="Write here"
                            required></td>
                </tr>
                <tr>
                    <td class="text-center" colspan="2"><button class="btn btn-primary" type="submit">Submit</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>

</html>