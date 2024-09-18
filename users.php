<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        #UserForm {
            border: 1px solid rgba(0, 0, 0, 0.1) !important;
        }
        #UserForm tr,
        #UserForm td {
            border: 0px !important;
        }
    </style>
</head>

<body>
    <?php include "navbar.php"; ?>
    <div class="container mt-4">
        <form action="./userModify" method="post">
            <table id="UserForm" class="table">
                <tr>
                    <td colspan="3" class="text-center h2">Add User</td>
                </tr>
                <tr>
                    <td><label for="name">Name</label></td>
                    <td>:</td>
                    <td><input class="form-control" type="text" name="name" id="name"></td>
                </tr>
                <tr>
                    <td><label for="username">Username</label></td>
                    <td>:</td>
                    <td><input class="form-control" type="text" name="username" id="username"></td>
                </tr>
                <tr>
                    <td><label for="password">Password</label></td>
                    <td>:</td>
                    <td><input class="form-control" type="text" name="password" id="password"></td>
                </tr>
                <tr>
                    <td colspan="3" class="text-center"><input class="btn btn-primary" type="submit" value="Add User"></td>
                </tr>
            </table>
        </form>
        <h1 class="text-center">Users</h1>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Action</th>
                    <th>Inactive/<br>Active</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM users";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['username'] . "</td>";
                        echo "<td><button class='btn btn-danger' onclick='deleteUser(\"" . $row['username'] . "\")'>Delete</button></td>";
                        if ($row['status'] == 'ACTIVE') {
                            echo '<td><a class="text-success" href="userModify.php?id=' . $row['username'] . '&action=INACTIVE"><i class="fa fa-toggle-on"></i></a></td>';
                        } else {
                            echo '<td><a class="text-danger" href="userModify.php?id=' . $row['username'] . '&action=ACTIVE"><i class="fa fa-toggle-off"></i></a></td>';
                        }
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No users found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script>
        function deleteUser(id) {
            if (confirm("Are you sure you want to delete this user?")) {
                window.location.href = "userModify.php?id=" + id + "&action=delete";
            }
        }
    </script>
</body>

</html>