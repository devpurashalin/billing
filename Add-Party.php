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
            <div class="ms-3" style="color: #fff;">Create Party</div>
            <div class="d-flex">
                <a href="#">Dashboard /</a>
                <div>XYZ</div>
            </div>
        </div>
		
		<form class="ps-4 mt-4" action="#" autocomplete="on" method="post" target="self" id="form1">
		
            <table>
                <tr>
		        	<td><label for="party_id">Party ID No.</label></td>
		        	<td>:</td>
		        	<td><input type="text" id="party_id" name="party_id" class="form-control" required></td>
		        <tr>
                <tr>
		        	<td><label for="party_name">Name of Party</label></td>
		        	<td>:</td>
		        	<td><input type="text" id="party_name" name="party_name" class="form-control" required></td>
		        <tr>
                <tr>
		        	<td><label for="address">Address</label></td>
		        	<td>:</td>
		        	<td><input type="text" id="address" name="address" class="form-control" required></td>
		        <tr>
                <tr>
					<td><label for="mob_no">Mobile Number</label></td>
					<td>:</td>
					<td><input type="text" id="mob_no" name="mob_no" pattern="[6-9]{1}[0-9]{9}" class="form-control" required></td>
		        <tr>
                <tr>
		        	<td><label for="gst_pan">GST/PAN</label></td>
		        	<td>:</td>
		        	<td><input type="text" id="gst_pan" name="gst_pan" class="form-control" required></td>
		        <tr>
            </table>
		
			<div class="d-flex justify-content-evenly pb-4 mt-4">
                
                <button class="btn submit" formmethod="post" formaction="#" type="submit">Submit</button>
            </div>
		</form>

        <div class="h3 text-center">List of All Customers</div>
            <table id="usersData" class="w-100 mb-3 table-success table table-bordered text-center table-striped ">
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

                </tbody>
            </table>

	</main>
</body>
</html>						