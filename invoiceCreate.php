<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Create</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <style>
        #Options {
            position: absolute;
            width: 30%;
            z-index: 999;
        }
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div class="container my-5" id="forPrint">
        <form action="invoiceSave" method="post">
            <table class="table table-bordered" id="invoiceTable">
                <tr>
                    <td>PAN No.: ABCED1234E</td>
                    <th class="text-center" colspan="3"><u>Cash/Credit Memo</u></th>
                    <td class="text-end">Mob: 9887111141<br>9414060621</td>
                </tr>
                <tr>
                    <td class="text-center text-danger h2" colspan="5">DEEPAK PRINTERS</td>
                </tr>
                <tr>
                    <td colspan="5">
                        <div class="text-center">Deals in : Offset, Screen, Multi Colour Printing & Computer Design Works</div>
                        <div class="text-center">OPP. SBI BANK, JAGATPURA, JAIPUR-302017</div>
                        <div class="text-center">Email : deepakprinters.jpr@gmail.com</div>
                    </td>
                </tr>
                <tr>
                    <td class="text-end"><label for="invoiceNo">Invoice No.</label></td>
                    <?php
                    $result = $conn->execute_query("SELECT count(`invoiceNo`) FROM `invoicetotal`");
                    $maxInvoiceID = $result->fetch_assoc()['count(`invoiceNo`)'];
                    ?>
                    <td colspan="2"><input class="form-control" value="DP/INVOICE/<?php echo $maxInvoiceID + 1; ?>" type="text" name="invoiceNo" id="invoiceNo"></td>
                    <td class="text-end"><label for="date">Date</label></td>
                    <td><input class="form-control" type="date" name="date" id="date" value="<?php echo date("Y-m-d"); ?>"></td>
                </tr>
                <tr>

                    <td class="text-end"><label for="partyName">Name of Party</label></td>

                    <td colspan="2">
                        <input type="hidden" name="partyName" id="partyName">
                        <input type="text" id="searchInput" autocomplete="off" onclick="displayOptions()" class="form-control" placeholder="Search...">
                        <div id="Options" style="display: none;">
                            <div id="optionsContainer" class="form-control bg-light">
                                <div onclick="setValue(this)" class="option mb-1">Select</div>
                                <?php
                                $query = "SELECT * FROM `party` WHERE status='ACTIVE';";
                                $result = $conn->execute_query($query);
                                $data = [];
                                while ($row = $result->fetch_assoc()) {
                                    $data[] = $row;
                                    echo '<div onclick="setValue(this)" class="option mb-1">' . $row['name'] . '</div>';
                                }
                                ?>
                            </div>
                        </div>
                        <script>
                            let partyData = <?php echo json_encode($data); ?>;

                            function findIndexById(id) {
                                return partyData.findIndex(item => item.name === id);
                            }
                        </script>
                        </select>
                    </td>
                    <input type="hidden" name="partyId" id="partyId">
                    <td class="text-end"><label for="GST_PAN">GST/PAN</label></td>
                    <td><input class="form-control" type="text" name="GST_PAN" id="GST_PAN"></td>
                </tr>
                <tr>
                    <td class="text-end"><label for="address">Address</label></td>
                    <td colspan="2"><input class="form-control" type="text" name="address" id="address"></td>
                    <td class="text-end"><label for="number">Mobile No.</label></td>
                    <td><input class="form-control" type="text" name="number" id="number"></td>
                </tr>
                <tr class="text-center">
                    <td class="fw-bold bg-light">S. No.</td>
                    <td class="fw-bold bg-light">Description</td>
                    <td class="fw-bold bg-light">Qty.</td>
                    <td class="fw-bold bg-light">Rate</td>
                    <td class="fw-bold bg-light">Amount Rs.</td>
                </tr>
                <tr>
                    <td><input type="text" class="form-control" id="sno1" name="sno1" value="1" required></td>
                    <td><input type="text" class="form-control" id="description1" name="description1" required></td>
                    <td><input type="text" class="form-control" id="qty1" name="qty1" required></td>
                    <td><input type="text" class="form-control" id="rate1" name="rate1" required></td>
                    <td><input type="text" class="form-control" id="amount_rs1" name="amount_rs1" readonly></td>
                </tr>
                <tr>
                    <td colspan="4" class="text-end">Total Amount</td>
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
                <button class="btn btn-warning fw-bold" name="submit" value="Save">Save</button>
                <button class="btn btn-primary fw-bold" name="submit" value="Print">Print</button>
            </div>
        </form>
    </div>
    <script>
        function fillData() {
            let name = document.getElementById("partyName").value;
            let index = findIndexById(name);
            if (index >= 0) {
                document.getElementById("GST_PAN").value = partyData[index].GST_PAN;
                document.getElementById("address").value = partyData[index].address;
                document.getElementById("number").value = partyData[index].number;
                document.getElementById("partyId").value = partyData[index].ID;
            } else {
                alert("Party Not Registered")
            }
        }
        let count = 1;

        // Attach event listeners to the new quantity and rate inputs
        document.getElementById('qty' + count).addEventListener('input', function() {
            calculateAmount(count);
        });
        document.getElementById('rate' + count).addEventListener('input', function() {
            calculateAmount(count);
        });

        function addRow() {
            if (isCurrentRowFilled()) {
                count++;
                let table = document.getElementById("invoiceTable");
                // Insert the new row before the last row (total amount row)
                let row = table.insertRow(table.rows.length - 7);
                let cell1 = row.insertCell(0);
                cell1.innerHTML = '<input type="text" value="' + count + '" class="form-control" id="sno' + count + '" name="sno' + count + '" required>';
                let cell2 = row.insertCell(1);
                cell2.innerHTML = '<input type="text" class="form-control" id="description' + count + '" name="description' + count + '" required>';
                let cell3 = row.insertCell(2);
                cell3.innerHTML = '<input type="text" class="form-control" id="qty' + count + '" name="qty' + count + '" required>';
                let cell4 = row.insertCell(3);
                cell4.innerHTML = '<input type="text" class="form-control" id="rate' + count + '" name="rate' + count + '" required>';
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
            } else if (!confirmation) {
            } else {
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

        // Filter options based on search input
        document.getElementById("searchInput").addEventListener("input", function() {
            var searchValue = this.value.toLowerCase();
            var options = document.getElementsByClassName("option");
            for (var i = 0; i < options.length; i++) {
                var optionText = options[i].textContent.toLowerCase();
                if (optionText.indexOf(searchValue) > -1) {
                    options[i].style.display = "";
                } else {
                    options[i].style.display = "none";
                }
            }
        });

        function setValue(option) {
            var value = option.textContent;
            document.getElementById("partyName").value = value;
            document.getElementById("Options").style.display = "none";
            document.getElementById("searchInput").value = value;
            fillData();
        }
    </script>

</body>

</html>