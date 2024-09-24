<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        function formSubmit() {
            if (document.getElementById('partyName').value == "" && document.getElementById('invoiceNo').value == "") {
                document.getElementById('formError').innerHTML = "*Please select any one field";
                return false;
            } else {
                document.querySelector('form').submit();
            }
        }
    </script>
    <style>
        input,
        select {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        td,
        th {
            padding-left: 3px !important;
            padding-right: 3px !important;
            font-size: medium;
        }

        th {
            vertical-align: middle;
        }

        .autocompleteName {
            position: relative;
            display: inline-block;
        }

        .autocompleteName-items {
            position: absolute;
            border: 1px solid #d4d4d4;
            border-bottom: none;
            border-top: none;
            z-index: 99;
            /*position the autocompleteName items to be the same width as the container:*/
            top: 100%;
            left: 0;
            right: 0;
        }

        .autocompleteName-items div {
            padding: 10px;
            cursor: pointer;
            background-color: #fff;
            border-bottom: 1px solid #d4d4d4;
        }

        /*when hovering an item:*/
        .autocompleteName-items div:hover {
            background-color: #e9e9e9;
        }

        /*when navigating through the items using the arrow keys:*/
        .autocompleteName-active {
            background-color: DodgerBlue !important;
            color: #ffffff;
        }

        .autocompleteInvoice {
            position: relative;
            display: inline-block;
        }

        .autocompleteInvoice-items {
            position: absolute;
            border: 1px solid #d4d4d4;
            border-bottom: none;
            border-top: none;
            z-index: 99;
            top: 100%;
            left: 0;
            right: 0;
        }

        .autocompleteInvoice-items div {
            padding: 10px;
            cursor: pointer;
            background-color: #fff;
            border-bottom: 1px solid #d4d4d4;
        }

        .autocompleteInvoice-items div:hover {
            background-color: #e9e9e9;
        }

        .autocompleteInvoice-active {
            background-color: DodgerBlue !important;
            color: #ffffff;
        }
    </style>
</head>

<body>
    <?php include "navbar.php"; ?>
    <div class="container my-5">
        <form action="payment" method="POST">
            <div class="row">
                <div class="col-md-3">
                    Customer Name

                    <div class="autocompleteName" style="width:100%;">
                        <input oninput="document.getElementById('invoiceNo').value = ''" required class="form-control" id="partyName" autocomplete="off" type="text" name="partyName">
                    </div>
                    <?php
                    $query = "SELECT * FROM party WHERE `status` <> 'DELETED'";
                    $result = $conn->execute_query($query);
                    $data = [];
                    while ($row = $result->fetch_assoc()) {
                        $data[] = $row;
                    }
                    ?>
                    <script>
                        let partyData = <?php echo json_encode($data); ?>;
                        let partyName = partyData.map(item => item.name);
                    </script>
                </div>
                <div class="col-md-3">
                    <?php
                    $query = "SELECT invoiceNo FROM `invoicetotal`";
                    $stmt = $conn->prepare($query);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $dataInvoice = [];

                    while ($row = $result->fetch_assoc()) {
                        $dataInvoice[] = $row['invoiceNo'];
                    }
                    ?>
                    Invoice Number
                    <div class="autocompleteInvoice" style="width:100%;">
                        <input oninput="document.getElementById('partyName').value = ''" required class="form-control" id="invoiceNo" autocomplete="off" type="text" name="invoiceNo">
                    </div>
                    <script>
                        const invoiceData = <?php echo json_encode($dataInvoice); ?>;

                        function autocompleteInvoice(input, arr) {
                            let currentFocus;

                            input.addEventListener("input", function() {
                                let a, b, i, val = this.value;
                                closeAllLists();
                                if (!val) return false;

                                currentFocus = -1;
                                a = document.createElement("DIV");
                                a.setAttribute("id", this.id + "autocompleteInvoice-list");
                                a.setAttribute("class", "autocompleteInvoice-items");
                                this.parentNode.appendChild(a);

                                for (i = 0; i < arr.length; i++) {
                                    if (arr[i].toUpperCase().includes(val.toUpperCase())) {
                                        b = document.createElement("DIV");
                                        b.innerHTML = arr[i].replace(new RegExp(`(${val})`, 'i'), "<strong>$1</strong>");
                                        b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                                        b.addEventListener("click", function() {
                                            input.value = this.getElementsByTagName("input")[0].value;
                                            closeAllLists();
                                        });
                                        a.appendChild(b);
                                    }
                                }
                                const x = document.getElementById(this.id + "autocompleteInvoice-list");
                                const items = x.getElementsByTagName("div");
                                currentFocus++;
                                addActive(items);
                            });

                            input.addEventListener("keydown", function(e) {
                                const x = document.getElementById(this.id + "autocompleteInvoice-list");
                                if (x) {
                                    const items = x.getElementsByTagName("div");
                                    if (e.keyCode == 40) {
                                        currentFocus++;
                                        addActive(items);
                                    } else if (e.keyCode == 38) {
                                        currentFocus--;
                                        addActive(items);
                                    } else if (e.keyCode == 13) {
                                        e.preventDefault();
                                        if (currentFocus > -1 && items) items[currentFocus].click();
                                    }
                                }
                            });

                            function addActive(items) {
                                if (!items) return;
                                removeActive(items);
                                if (currentFocus >= items.length) currentFocus = 0;
                                if (currentFocus < 0) currentFocus = items.length - 1;
                                items[currentFocus].classList.add("autocompleteInvoice-active");
                            }

                            function removeActive(items) {
                                for (const item of items) {
                                    item.classList.remove("autocompleteInvoice-active");
                                }
                            }

                            function closeAllLists(elmnt) {
                                const items = document.getElementsByClassName("autocompleteInvoice-items");
                                for (let i = 0; i < items.length; i++) {
                                    if (elmnt != items[i] && elmnt != input) {
                                        items[i].parentNode.removeChild(items[i]);
                                    }
                                }
                            }

                            document.addEventListener("click", function(e) {
                                closeAllLists(e.target);
                            });
                        }

                        autocompleteInvoice(document.getElementById("invoiceNo"), invoiceData);
                    </script>
                </div>
                <div class="col-md-3">
                    <br>
                    <button type="button" onclick="formSubmit()" class="btn btn-primary">Search</button>
                    <br>
                    <p id="formError" class="text-danger"></p>
                </div>
            </div>
        </form>
        <script>
            function autocompleteName(inp, arr) {
                var currentFocus;
                inp.addEventListener("input", function(e) {
                    var a, b, i, val = this.value;
                    closeAllLists();
                    if (!val) {
                        return false;
                    }
                    currentFocus = -1;
                    a = document.createElement("DIV");
                    a.setAttribute("id", this.id + "autocompleteName-list");
                    a.setAttribute("class", "autocompleteName-items");
                    this.parentNode.appendChild(a);
                    for (i = 0; i < arr.length; i++) {
                        let index = arr[i].indexOf(val.toUpperCase());
                        if (index > -1) {
                            b = document.createElement("DIV");
                            b.innerHTML = arr[i].substr(0, index);
                            b.innerHTML += "<strong>" + arr[i].substr(index, val.length) + "</strong>";
                            b.innerHTML += arr[i].substr(index + val.length);
                            b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                            b.addEventListener("click", function(e) {
                                inp.value = this.getElementsByTagName("input")[0].value;
                                closeAllLists();
                            });
                            a.appendChild(b);
                        }
                    }
                    var x = document.getElementById(this.id + "autocompleteName-list");
                    if (x) x = x.getElementsByTagName("div");
                    currentFocus++;
                    addActive(x);
                });

                inp.addEventListener("keydown", function(e) {
                    var x = document.getElementById(this.id + "autocompleteName-list");
                    if (x) x = x.getElementsByTagName("div");
                    if (e.keyCode == 40) {
                        currentFocus++;
                        addActive(x);
                    } else if (e.keyCode == 38) { //up
                        currentFocus--;
                        addActive(x);
                    } else if (e.keyCode == 13) {
                        e.preventDefault();
                        if (currentFocus > -1) {
                            if (x) x[currentFocus].click();
                        }
                    }
                });

                function addActive(x) {
                    if (!x) return false;
                    removeActive(x);
                    if (currentFocus >= x.length) currentFocus = 0;
                    x[currentFocus].classList.add("autocompleteName-active");
                }

                function removeActive(x) {
                    for (var i = 0; i < x.length; i++) {
                        x[i].classList.remove("autocompleteName-active");
                    }
                }

                function closeAllLists(elmnt) {
                    var x = document.getElementsByClassName("autocompleteName-items");
                    for (var i = 0; i < x.length; i++) {
                        if (elmnt != x[i] && elmnt != inp) {
                            x[i].parentNode.removeChild(x[i]);
                        }
                    }
                }
                document.addEventListener("click", function(e) {
                    closeAllLists(e.target);
                });
            }
            autocompleteName(document.getElementById("partyName"), partyName);
        </script>
        <div class="table-responsive">
            <table class="table table-bordered my-5">
                <tr>
                    <!-- <th style="width: 10%;">Invoice No</th>
                <th>Name</th>
                <th style="width: 10%;">Amount</th>
                <th style="width: 10%;">Payment Mode</th>
                <th style="width: 10%;">Amount Received</th>
                <th style="width: 8%;">Date of Payment</th>
                <th>Discount</th>
                <th>Remark</th>
                <th style="width: 8%;">Action</th> -->
                    <th class="bg-light">Invoice No</th>
                    <th class="bg-light">Name</th>
                    <th class="bg-light">Amount</th>
                    <th class="bg-light">Payment Mode</th>
                    <th class="bg-light">Amount Received</th>
                    <th class="bg-light">Payment Date</th>
                    <th class="bg-light">Discount</th>
                    <th class="bg-light">Remark</th>
                    <th class="bg-light">Action</th>
                </tr>
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (isset($_POST['invoiceNo']) && $_POST['invoiceNo'] != "") {
                        $invoiceNo = $_POST['invoiceNo'];
                        $sql = "SELECT * FROM invoicetotal WHERE invoiceNo = '$invoiceNo'";
                    } else if (isset($_POST['partyId']) && $_POST['partyId'] != "") {
                        $partyId = $_POST['partyId'];
                        $sql = "SELECT * FROM invoicetotal WHERE partyId = '$partyId'";
                    } else if (isset($_POST['partyName']) && $_POST['partyName'] != "") {
                        $partyName = $_POST['partyName'];
                        $sql = "SELECT * FROM invoicetotal WHERE partyName = '$partyName'";
                    } else {
                        exit;
                    }
                } else {
                    exit;
                }
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $count = 0;
                    while ($row = $result->fetch_assoc()) {
                        $count++;
                        $invoiceNo = $row['invoiceNo'];
                        $partyName = $row['partyName'];
                        $date = $row['date'];
                        $TotalAmount = $row['amount'];
                        $dateOfPayment = $row['dateOfPayment'];
                        $discount = $row['discount'];
                        $remark = $row['remark'];
                ?>
                        <tr>
                            <td><a target="_blank" href="invoiceView.php?invoiceNo=<?php echo $invoiceNo; ?>"><?php echo $invoiceNo; ?></a></td>
                            <td><?php echo $partyName; ?></td>
                            <td id="totalAmount<?php echo $count; ?>"><?php echo $TotalAmount; ?></td>
                            <form action="invoiceUpdate" method="post">
                                <input type="hidden" name="invoiceNo" value="<?php echo $invoiceNo; ?>">
                                <input type="hidden" name="totalAmount" value="<?php echo $TotalAmount; ?>">
                                <td>
                                    <select class="form-control" name="paymentMode" id="paymentMode<?php echo $count; ?>">
                                        <option value="" selected>Select</option>
                                        <?php
                                        $paymentMode = $row['paymentMode'];
                                        $tempsql = "SELECT * FROM `paymentmode`;";
                                        $tempresult = $conn->query($tempsql);
                                        if ($tempresult->num_rows > 0) {
                                            while ($temprow = $tempresult->fetch_assoc()) {
                                                $selected = "";
                                                if ($paymentMode == $temprow['value']) {
                                                    $selected = "selected";
                                                }
                                                echo "<option value='" . $temprow['value'] . "' $selected>" . $temprow['value'] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td>
                                    <input type="number" id="amountReceived<?php echo $count; ?>" name="amountReceived" class="form-control" value="<?php echo $row['amountReceived']; ?>">
                                </td>
                                <td><input type="date" class="form-control" name="dateOfPayment" id="dateOfPayment<?php echo $count; ?>" value="<?php echo $dateOfPayment; ?>"></td>
                                <td><input type="text" class="form-control" name="discount" id="discount<?php echo $count; ?>" value="<?php echo $discount; ?>"></td>
                                <td><input type="text" class="form-control" name="remark" id="reamrk<?php echo $count; ?>" value="<?php echo $remark; ?>"></td>
                                <td>
                                    <button type="submit" class="btn btn-primary px-1">Update</button>
                                </td>
                            </form>
                        </tr>
                <?php
                    }
                }
                ?>
            </table>
        </div>
    </div>
</body>

</html>