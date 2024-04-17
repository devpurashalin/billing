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
            <div class="ms-3" style="color: #fff;">Search Invoice</div>
            <div class="d-flex">
                <a href="#">Dashboard /</a>
                <div>XYZ</div>
            </div>
        </div>
		
        <div class="d-flex justify-content-between m-3">
            <div class="m-1">Name of Party or Invoice No.</div>
            <div class="m-2">
                <input class="form-control" onkeyup="search(this);" type="text" id="searchInput" placeholder="Search">
            </div>
        </div>

        <div class="h3 text-center">Invoice Statement of.........(Name of Customer)</div>
		<form class="ps-4 mt-4" action="#" autocomplete="on" method="post" target="self" id="form2">
		
            
        <table class="equalWidthTable">

            <tr>
                <td><label for="invoice_num">Invoice No.</label></td>
                <td><label for="dated">Dated</label></td>
                <td><label for="amount_rs">Amount Rs.</label></td>
                <td><label for="payment_status">Payment Status</label></td>
                <td><label for="payment_recieved">Payment Recieved</label></td>
                <td><label for="discount">Discount if Any</label></td>
            </tr>

            <tr>
                <td><input type="text" id="invoice_num" name="invoice_num" class="form-control" required></td>
                <td><input type="Date" id="dated" name="dated" class="form-control" required></td>
                <td><input type="text" id="amount_rs" name="amount_rs" class="form-control" required></td>
                <td><select id="payment_status" name="payment_status" class="form-control" required>
                        <option selected value > --select-- </option>
						<option value="Due">Due</option>
						<option value="Paid">Paid</option>
					</select></td>
                <td><select id="payment_recieved" name="payment_recieved" class="form-control" required>
                        <option selected value > --select-- </option>
						<option value="Cash">Cash</option>
						<option value="SB Account">SB Account</option>
						<option value="Cheque">Cheque</option>
						<option value="Paytm">Paytm</option>
						<option value="Phone Pe">Phone Pe</option>
						<option value="Current Account">Current Account</option>
					</select></td>
                <td><input type="text" id="discount" name="discount" class="form-control" required></td>
            </tr>

        </table>
		</form>

	</main>
</body>
</html>						