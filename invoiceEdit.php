<?php
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $invoiceNo = $_POST['invoiceNo'];
    $sql = "SELECT * FROM `invoicetotal` WHERE invoiceNo='$invoiceNo'";
    $result = $conn->execute_query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $invoiceNo = $row['invoiceNo'];
        $date = $row['date'];
        $partyId = $row['partyId'];

        $query = "SELECT * FROM `party` WHERE ID='$partyId'";
        $result = $conn->execute_query($query);
        $party = $result->fetch_assoc();
        $partyName = $party['name'];
        $GST_PAN = $party['GST_PAN'];
        $address = $party['address'];
        $number = $party['number'];
    } else {
        echo "<script>alert('Invalid Request');</script>";
        echo "<script>window.location = 'invoicesAll';</script>";
    }
} else {
    echo "<script>alert('Invalid Request');</script>";
    echo "<script>window.location = 'invoicesAll';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Create</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <style>
        /*the container must be positioned relative:*/
        .autocomplete {
            position: relative;
            display: inline-block;
        }

        .autocomplete-items {
            position: absolute;
            border: 1px solid #d4d4d4;
            border-bottom: none;
            border-top: none;
            z-index: 99;
            /*position the autocomplete items to be the same width as the container:*/
            top: 100%;
            left: 0;
            right: 0;
        }

        .autocomplete-items div {
            padding: 10px;
            cursor: pointer;
            background-color: #fff;
            border-bottom: 1px solid #d4d4d4;
        }

        /*when hovering an item:*/
        .autocomplete-items div:hover {
            background-color: #e9e9e9;
        }

        /*when navigating through the items using the arrow keys:*/
        .autocomplete-active {
            background-color: DodgerBlue !important;
            color: #ffffff;
        }
    </style>

</head>

<body>
    <?php include 'navbar.php'; ?>
    <div class="container my-5" id="forPrint">
        <form action="invoiceSave" method="post">
            <table class="table table-bordered" id="invoiceTable">
                <tr>
                    <td colspan="5">
                        <div class="d-flex justify-content-between">
                            <div>GSTIN: 08AWGPD7728Q1ZV</div>
                            <div class="text-center" style="padding-right: 4rem;" colspan="3">
                                <img src="./ganesh.jpeg" width="50px">
                                <br>
                                <u>Bill of Supply</u>
                            </div>
                            <div class="text-end">Mob: 9887111141</div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="text-center text-danger h2" colspan="5">DEEPAK PRINTERS</td>
                </tr>
                <tr>
                    <td colspan="5">
                        <div class="text-center">Deals in: All Types of Printing Works and Digital Colour Printout</div>
                        <div class="text-center">OPP. SBI BANK, JAGATPURA, JAIPUR-302017</div>
                        <div class="text-center">Email : deepakprinters.jpr@gmail.com</div>
                    </td>
                </tr>
                <tr>
                    <td class="text-end"><label for="partyName">Name of Party</label></td>
                    <td colspan="2">
                        <div class="autocomplete" style="width: 100%;">
                            <input required class="form-control" oninput="fillData();" value="<?php echo $partyName . " (" . $partyId . ")"; ?>" id="partyName" autocomplete="off" type="text" name="partyName">
                        </div>
                        <?php
                        $query = "SELECT * FROM `party` WHERE status='ACTIVE';";
                        $result = $conn->execute_query($query);
                        $data = [];
                        while ($row = $result->fetch_assoc()) {
                            $data[] = $row;
                        }
                        ?>
                        <script>
                            let partyData = <?php echo json_encode($data); ?>;
                            let partyName = partyData.map(item => item.name + ' (' + item.ID + ')');

                            function findIndexById(id) {
                                return partyData.findIndex(item => (item.name + " (" + item.ID + ")") === id);
                            }
                        </script>
                        </select>
                    </td>
                    <input type="hidden" name="partyId" id="partyId">
                    <td class="text-end"><label for="invoiceNo">Invoice No.</label></td>
                    <td colspan="2"><input class="form-control" value="<?php echo $invoiceNo ?>" type="text" name="invoiceNo" id="invoiceNo" readonly></td>
                </tr>
                <tr>
                    <td class="text-end"><label for="address">Address</label></td>
                    <td colspan="2"><input required class="form-control" type="text" name="address" id="address"></td>
                    <td class="text-end">PO Order</td>
                    <td><input class="form-control" type="text" name="poOrder" id="poOrder"></td>
                </tr>
                <tr>
                    <td class="text-end"><label for="GST_PAN">GST/PAN</label></td>
                    <td colspan="2"><input class="form-control" type="text" name="GST_PAN" id="GST_PAN"></td>
                    <td class="text-end"><label for="date">Date</label></td>
                    <td><input class="form-control" type="date" name="date" id="date" value="<?php echo $date; ?>"></td>
                </tr>
                <tr class="text-center">
                    <td class="fw-bold bg-light">S. No.</td>
                    <td class="fw-bold bg-light">Description</td>
                    <td class="fw-bold bg-light">Qty.</td>
                    <td class="fw-bold bg-light">Rate</td>
                    <td class="fw-bold bg-light">Amount Rs.</td>
                </tr>
                <?php
                $query = "SELECT * FROM `invoice` WHERE invoiceNo='$invoiceNo'";
                $result = $conn->execute_query($query);
                $count = 1;
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td><input type="text" class="form-control" id="sno' . $count . '" name="sno' . $count . '" value="' . $count . '" required></td>';
                    echo '<td><select required class="form-control" name="description' . $count . '" id="description' . $count . '">';
                    echo '<option value="" selected disabled>Select</option>';
                    $tempsql = "SELECT * FROM `invoiceitem`";
                    $tempresult = $conn->execute_query($tempsql);
                    while ($temprow = $tempresult->fetch_assoc()) {
                        echo '<option value="' . $temprow['value'] . '"';
                        if ($temprow['value'] == $row['description']) {
                            echo ' selected';
                        }
                        echo '>' . $temprow['value'] . '</option>';
                    }
                    echo '</select></td>';
                    echo '<td>
                        <input type="text" oninput="splitAmount(' . $count . ')" class="form-control" id="qtyu' . $count . '" name="qty' . $count . '" required value="' . $row['qty'] . '">
                        <input type="hidden" id="qty' . $count . '">
                    </td>';
                    echo '<td><input type="text" oninput="updateAmount(' . $count . ')" class="form-control" id="rate' . $count . '" name="rate' . $count . '" value="' . $row['rate'] . '" required></td>';
                    echo '<td><input type="text" class="form-control" id="amount_rs' . $count . '" name="amount_rs' . $count . '" value="' . $row['amount'] . '" readonly></td>';
                    echo '</tr>';
                    $count++;
                }
                ?>
                <tr>
                    <td colspan="3">Registered under composition scheme of GST</td>
                    <td class="text-end">Total Amount</td>
                    <td><input type="text" class="form-control" id="total_amt" name="total_amt" readonly></td>
                </tr>
                <tr>
                    <td>Rs. (in words)</td>
                    <td colspan="4"><input type="text" class="form-control" id="total_amt_words" name="total_amt_words" readonly></td>
                </tr>
                <tr>
                    <td colspan="5">
                        <button class="btn btn-secondary" type="button" onclick="addRow()">Add Row</button>
                        <button class="btn btn-danger" type="button" onclick="deleteRow()">Delete Row</button>
                    </td>
                </tr>
                <tr>
                    <td colspan="4"><b>Terms and Conditions:</b></td>
                    <td class="text-danger">For: <b>Deepak Printers</b></td>
                </tr>

                <tr>
                    <td colspan="4">1. All subject to Jaipur jurisdiction only.</td>
                    <td></td>
                </tr>

                <tr>
                    <td colspan="4">2. Goods Sold will not be taken back.</td>
                    <td></td>
                </tr>

                <tr>
                    <td colspan="4">3. E. & O.E.</td>
                    <td>Authorised Signature</td>
                </tr>
            </table>
            <div class="d-flex justify-content-evenly">
                <button class="btn btn-warning fw-bold" name="submit" value="Update">Update</button>
                <!-- <button class="btn btn-primary fw-bold" name="submit" value="Print">Print</button> -->
            </div>
        </form>
    </div>
    <script>
        function fillData() {
            let name = document.getElementById("partyName");
            // name.value = name.value.toUpperCase();
            let index = findIndexById(name.value);
            if (index >= 0) {
                document.getElementById("GST_PAN").value = partyData[index].GST_PAN;
                document.getElementById("address").value = partyData[index].address;
                // document.getElementById("number").value = partyData[index].number;
                document.getElementById("partyId").value = partyData[index].ID;
            } else {
                document.getElementById("GST_PAN").value = "";
                document.getElementById("address").value = "";
                // document.getElementById("number").value = "";
                document.getElementById("partyId").value = "";
            }
        }

        function updateAmount(number) {
            let qty = document.getElementById("qty" + number).value;
            let rate = document.getElementById("rate" + number).value;
            let amount = qty * rate;
            document.getElementById("amount_rs" + number).value = amount.toFixed(2);
            updateTotalAmount();
        }

        function splitAmount(number) {
            let qty = document.getElementById("qty" + number);
            let qtyu = document.getElementById("qtyu" + number).value;

            let qtyN = qtyu.split(" ");
            qty.value = qtyN[0];
            updateAmount(number)
        }

        let count = <?php echo $count - 1; ?>;

        for (let index = 1; index <= count; index++) {
            splitAmount(index);
        }

        function addRow() {
            if (count == 10) {
                alert('Maximum 10 rows allowed');
                return;
            }
            if (isCurrentRowFilled()) {
                count++;
                let table = document.getElementById("invoiceTable");
                // Insert the new row before the last row (total amount row)
                let row = table.insertRow(table.rows.length - 7);
                let cell1 = row.insertCell(0);
                cell1.innerHTML = '<input type="text" value="' + count + '" class="form-control" id="sno' + count + '" name="sno' + count + '" required>';
                let cell2 = row.insertCell(1);
                cell2.innerHTML = '<select required class="form-control" name="description' + count + '" id="description' + count + '"><option value="" selected disabled>Select</option><?php $tempsql = "SELECT * FROM `invoiceitem`";
                                                                                                                                                                                            $tempresult = $conn->execute_query($tempsql);
                                                                                                                                                                                            while ($temprow = $tempresult->fetch_assoc()) {
                                                                                                                                                                                                echo '<option value="' . $temprow['value'] . '">' . $temprow['value'] . '</option>';
                                                                                                                                                                                            } ?></select>';
                let cell3 = row.insertCell(2);
                cell3.innerHTML = '<input type="text" oninput="splitAmount(' + count + ')" class="form-control" id="qtyu' + count + '" name="qty' + count + '" required><input type="hidden" id="qty' + count + '">';
                let cell4 = row.insertCell(3);
                cell4.innerHTML = '<input type="text" oninput="updateAmount(' + count + ')" class="form-control" id="rate' + count + '" name="rate' + count + '" required>';
                let cell5 = row.insertCell(4);
                cell5.innerHTML = '<input type="text" class="form-control" id="amount_rs' + count + '" name="amount_rs' + count + '" readonly>';

                // Attach event listeners to the new quantity and rate inputs
                document.getElementById('qty' + count).addEventListener('input', function() {
                    calculateAmount(count);
                });
                document.getElementById('rate' + count).addEventListener('input', function() {
                    calculateAmount(count);
                });
            } else
                alert('Please fill all fields of current row');
        }

        function deleteRow() {
            let table = document.getElementById("invoiceTable");
            // Insert the new row before the last row (total amount row)
            let row = table.rows.length;

            confirmation = confirm("Are you want to delete?");
            if (confirmation && count != 0) {
                table.deleteRow(row - 8);
                count--;
            } else if (!confirmation) {} else {
                alert('Empty');
            }
        }

        function isCurrentRowFilled() {
            let currRow = count;
            if (currRow === 0) return true;
            return (
                document.getElementById("sno" + currRow).value !== "" &&
                document.getElementById("description" + currRow).value !== "" &&
                document.getElementById("qty" + currRow).value !== "" &&
                document.getElementById("rate" + currRow).value !== ""
            );
        }

        function calculateAmount(rowNumber) {
            // Get references to the input fields
            const qtyInput = document.getElementById('qty' + rowNumber);
            const rateInput = document.getElementById('rate' + rowNumber);
            const amountInput = document.getElementById('amount_rs' + rowNumber);

            // Get values from quantity and rate inputs
            const qty = parseFloat(qtyInput.value);
            const rate = parseFloat(rateInput.value);

            // Calculate the amount
            const amount = qty * rate;

            // Update the amount input field
            amountInput.value = isNaN(amount) ? '' : amount.toFixed(2);

            // Update the total amount
            updateTotalAmount();
        }

        function updateTotalAmount() {
            let totalAmount = 0;
            // Loop through all amount fields and sum their values
            for (let i = 1; i <= count; i++) {
                let amountValue = document.getElementById('amount_rs' + i).value;
                totalAmount += parseFloat(amountValue) || 0;
            }
            // Update the total amount field
            document.getElementById('total_amt').value = totalAmount.toFixed(2);

            // Convert total amount to words and update the corresponding field
            let totalAmountInWords = numberToWordsInd(totalAmount);
            document.getElementById('total_amt_words').value = totalAmountInWords;
        }

        function numberToWordsInd(value) {
            var fraction = Math.round(frac(value) * 100);
            var f_text = "";

            if (fraction > 0) {
                f_text = "And " + convert_number(fraction) + " Paise";
            }

            return convert_number(value) + " Rupees " + f_text + "Only";
        }

        function frac(f) {
            return f % 1;
        }

        function convert_number(number) {
            if ((number < 0) || (number > 999999999)) {
                return "NUMBER OUT OF RANGE!";
            }
            var Gn = Math.floor(number / 10000000); /* Crore */
            number -= Gn * 10000000;
            var kn = Math.floor(number / 100000); /* lakhs */
            number -= kn * 100000;
            var Hn = Math.floor(number / 1000); /* thousand */
            number -= Hn * 1000;
            var Dn = Math.floor(number / 100); /* Tens (deca) */
            number = number % 100; /* Ones */
            var tn = Math.floor(number / 10);
            var one = Math.floor(number % 10);
            var res = "";

            if (Gn > 0) {
                res += (convert_number(Gn) + " Crore");
            }
            if (kn > 0) {
                res += (((res == "") ? "" : " ") +
                    convert_number(kn) + " Lakh");
            }
            if (Hn > 0) {
                res += (((res == "") ? "" : " ") +
                    convert_number(Hn) + " Thousand");
            }

            if (Dn) {
                res += (((res == "") ? "" : " ") +
                    convert_number(Dn) + " Hundred");
            }


            var ones = Array("", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eighteen", "Nineteen");
            var tens = Array("", "", "Twenty", "Thirty", "Forty", "Fifty", "Sixty", "Seventy", "Eighty", "Ninety");

            if (tn > 0 || one > 0) {
                if (!(res == "")) {
                    res += " And ";
                }
                if (tn < 2) {
                    res += ones[tn * 10 + one];
                } else {

                    res += tens[tn];
                    if (one > 0) {
                        res += ("-" + ones[one]);
                    }
                }
            }

            if (res == "") {
                res = "Zero";
            }
            return res;
        }

        function displayOptions() {
            var options = document.getElementById("Options");
            if (options.style.display === "none") {
                options.style.display = "block";
            } else {
                options.style.display = "none";
            }
        }

        function autocomplete(inp, arr) {
            var currentFocus;
            inp.addEventListener("input", function(e) {
                var a, b, i, val = this.value;
                closeAllLists();
                if (!val) {
                    return false;
                }
                currentFocus = -1;
                a = document.createElement("DIV");
                a.setAttribute("id", this.id + "autocomplete-list");
                a.setAttribute("class", "autocomplete-items");
                this.parentNode.appendChild(a);
                for (i = 0; i < arr.length; i++) {
                    let index = arr[i].toUpperCase().indexOf(val.toUpperCase());
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
            });
            inp.addEventListener("keydown", function(e) {
                var x = document.getElementById(this.id + "autocomplete-list");
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
                x[currentFocus].classList.add("autocomplete-active");
            }

            function removeActive(x) {
                for (var i = 0; i < x.length; i++) {
                    x[i].classList.remove("autocomplete-active");
                }
            }

            function closeAllLists(elmnt) {
                var x = document.getElementsByClassName("autocomplete-items");
                for (var i = 0; i < x.length; i++) {
                    if (elmnt != x[i] && elmnt != inp) {
                        x[i].parentNode.removeChild(x[i]);
                    }
                }
            }
            document.addEventListener("click", function(e) {
                closeAllLists(e.target);
                fillData();
            });
        }
        autocomplete(document.getElementById("partyName"), partyName);
    </script>
    <script>
        fillData();
    </script>
</body>

</html>