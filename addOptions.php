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
                <table class="table table-bordered">
                    <?php
                    $sql = "SELECT * FROM invoiceitem";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr><td>{$row['value']}</td>";
                    ?>
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
                    ?>
                </table>
            </div>
            <div class="col-12 col-md-6">
                <div class="text-center h5">Payment Mode</div>
                <table class="table table-bordered border-warning">
                    <?php
                    $sql = "SELECT * FROM paymentmode";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr><td>{$row['value']}</td>";
                    ?>
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
                    ?>
                </table>
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
</body>

</html>