<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <main class="w-75 ms-auto me-4 my-4 ">
        <div class="header d-flex justify-content-between px-3 py-2">
            <div class="ms-3" style="color: #fff;">Create Invoice</div>
            <div class="d-flex">
                <a href="#">Dashboard /</a>
                <div>XYZ</div>
            </div>
        </div>

        <div class="d-flex justify-content-between m-3">
            <div class="m-1">PAN No.:</div>
            <div class="m-2"><u><b>Cash/Credit Memo</b></u></div>
            <div class="m-3">M:
                <div style="float: right;"> 9887111141<br>9414060621</div>
            </div>
        </div>

        <div class="h3 text-center text-danger">DEEPAK PRINTERS</div>
        <div class="p text-center">Deals in : Offset, Screen, Multi Colour Printing & Computer Design Works</div>
        <div class="p text-center"><b>OPP. SBI BANK, JAGATPURA, JAIPUR-302017</b></div>
        <div class="p text-center">Email : deepakprinters.jpr@gmail.com</div>

        <form class="ps-4 mt-4" action="#" autocomplete="on" method="post" target="self" id="form3">


            <table class="equalWidthTable" id="invoiceTable">

                <tr>
                    <td>Invoice No.</td>
                    <td colspan="2"></td>
                    <td><label for="date">Date</label></td>
                    <td><input type="Date" id="date" class="form-control" name="date"></td>
                </tr>

                <tr>
                    <td>Name of Party</td>
                    <td colspan="2"></td>
                    <td>GST/PAN</td>
                    <td></td>
                </tr>

                <tr>
                    <td>Address</td>
                    <td colspan="2"></td>
                    <td>Mobile No.</td>
                    <td></td>
                </tr>

                <tr style="background-color: orange;">
                    <th><label for="sno">S.No.</label></th>
                    <th><label for="description">Description</label></th>
                    <th><label for="qtty">Qtty.</label></th>
                    <th><label for="rate">Rate</label></th>
                    <th><label for="amount_rs">Amount Rs.</label></th>
                </tr>

                <tr>
                    <td><input type="text" class="form-control" id="sno1" name="sno1" required></td>
                    <td><input type="text" class="form-control" id="description1" name="description1" required></td>
                    <td><input type="text" class="form-control" id="qtty1" name="qtty1" required></td>
                    <td><input type="text" class="form-control" id="rate1" name="rate1" required></td>
                    <td><input type="text" class="form-control" id="amount_rs1" name="amount_rs1" readonly></td>
                </tr>

                <tr>
                    <td colspan="3"></td>
                    <td>Total Amount</td>
                    <td><input type="text" class="form-control" id="total_amt" name="total_amt"  readonly></td>
                </tr>

                <tr>
                    <td>Rs. (in words)</td>
                    <td colspan="4"><input type="text" class="form-control" id="total_amt_words" name="total_amt_words"  readonly></td>
                </tr>

            </table>
            <button class="btn btn-secondary" type="button" onclick="addRow()">Add Row</button>

            <table class="equalWidthTable" style="margin-top: 20px;">
                    <tr>
                        <td colspan="4"><b>Terms and Conditions:</b></td>
                        <td style="color: red;">For: <b>Deepak Printers</b></td>
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
            
			<div class="d-flex justify-content-evenly pb-4 mt-4">
                <input type="submit" name="action" value="Save" class="btn submit">
                <button onclick="" class="btn submit">PDF</button>
                <button onclick="window.print();" class="btn submit">Print</button>
			</div>
        </form>

    </main>

    <script>
        let count = 1;

        // Attach event listeners to the new quantity and rate inputs
        document.getElementById('qtty' + count).addEventListener('input', function() { calculateAmount(count); });
        document.getElementById('rate' + count).addEventListener('input', function() { calculateAmount(count); });

        function addRow() {
            if (isCurrentRowFilled()) {
                count++;
                let table = document.getElementById("invoiceTable");
                // Insert the new row before the last row (total amount row)
                let row = table.insertRow(table.rows.length - 2);
                let cell1 = row.insertCell(0);
                cell1.innerHTML = '<input type="text" class="form-control" id="sno' + count + '" name="sno' + count + '" required>';
                let cell2 = row.insertCell(1);
                cell2.innerHTML = '<input type="text" class="form-control" id="description' + count + '" name="description' + count + '" required>';
                let cell3 = row.insertCell(2);
                cell3.innerHTML = '<input type="text" class="form-control" id="qtty' + count + '" name="qtty' + count + '" required>';
                let cell4 = row.insertCell(3);
                cell4.innerHTML = '<input type="text" class="form-control" id="rate' + count + '" name="rate' + count + '" required>';
                let cell5 = row.insertCell(4);
                cell5.innerHTML = '<input type="text" class="form-control" id="amount_rs' + count + '" name="amount_rs' + count + '" readonly>';
            
                // Attach event listeners to the new quantity and rate inputs
                document.getElementById('qtty' + count).addEventListener('input', function() { calculateAmount(count); });
                document.getElementById('rate' + count).addEventListener('input', function() { calculateAmount(count); });
            }
            else
                alert('Please fill all fields of current row');
        }

        function isCurrentRowFilled() {
            let currRow = count;
            return (
                document.getElementById("sno" + currRow).value !== "" &&
                document.getElementById("description" + currRow).value !== "" &&
                document.getElementById("qtty" + currRow).value !== "" &&
                document.getElementById("rate" + currRow).value !== ""
            );
        }

        function calculateAmount(rowNumber) {
            // Get references to the input fields
            const qttyInput = document.getElementById('qtty' + rowNumber);
            const rateInput = document.getElementById('rate' + rowNumber);
            const amountInput = document.getElementById('amount_rs' + rowNumber);
        
            // Get values from quantity and rate inputs
            const qtty = parseFloat(qttyInput.value);
            const rate = parseFloat(rateInput.value);
        
            // Calculate the amount
            const amount = qtty * rate;
        
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
            var fraction = Math.round(frac(value)*100);
            var f_text  = "";

            if(fraction > 0) {
                f_text = "And "+convert_number(fraction)+" Paise";
            }

            return convert_number(value)+" Rupees "+f_text+" Only";
        }

        function frac(f) {
            return f % 1;
        }

        function convert_number(number)
        {
            if ((number < 0) || (number > 999999999)) 
            { 
                return "NUMBER OUT OF RANGE!";
            }
            var Gn = Math.floor(number / 10000000);  /* Crore */ 
            number -= Gn * 10000000; 
            var kn = Math.floor(number / 100000);     /* lakhs */ 
            number -= kn * 100000; 
            var Hn = Math.floor(number / 1000);      /* thousand */ 
            number -= Hn * 1000; 
            var Dn = Math.floor(number / 100);       /* Tens (deca) */ 
            number = number % 100;               /* Ones */ 
            var tn= Math.floor(number / 10); 
            var one=Math.floor(number % 10); 
            var res = ""; 
        
            if (Gn>0) 
            { 
                res += (convert_number(Gn) + " Crore"); 
            } 
            if (kn>0) 
            { 
                    res += (((res=="") ? "" : " ") + 
                    convert_number(kn) + " Lakh"); 
            } 
            if (Hn>0) 
            { 
                res += (((res=="") ? "" : " ") +
                    convert_number(Hn) + " Thousand"); 
            } 
        
            if (Dn) 
            { 
                res += (((res=="") ? "" : " ") + 
                    convert_number(Dn) + " Hundred"); 
            } 
        
        
            var ones = Array("", "One", "Two", "Three", "Four", "Five", "Six","Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen","Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eighteen","Nineteen"); 
            var tens = Array("", "", "Twenty", "Thirty", "Forty", "Fifty", "Sixty","Seventy", "Eighty", "Ninety"); 
        
            if (tn>0 || one>0) 
            { 
                if (!(res=="")) 
                { 
                    res += " And "; 
                } 
                if (tn < 2) 
                { 
                    res += ones[tn * 10 + one]; 
                } 
                else 
                { 
                
                    res += tens[tn];
                    if (one>0) 
                    { 
                        res += ("-" + ones[one]); 
                    } 
                } 
            }
        
            if (res=="")
            { 
                res = "Zero"; 
            } 
            return res;
        }


    </script>

</body>

</html>
