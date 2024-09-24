<style>
    .nav-link:hover {
        background-color: gray;
        font-weight: bold;
        color: white;
        border-radius: 5px;
    }

    .nav-link {
        padding-top: 4px !important;
        padding-bottom: 4px !important;
    }
</style>
<link rel="stylesheet" href="style.css">
<div class="d-flex bg-body-tertiary justify-content-between px-1 pt-1">
    <div class="ps-2">
        <a class="fw-bold text-decoration-none" style="color: rgb(7, 32, 105);" href="index">Home</a>
    </div>
    <div class="btn btn-danger py-1">
        <a class="text-decoration-none text-white" href="logout">Logout</a>
    </div>
</div>
<nav class="navbar navbar-expand-lg bg-body-tertiary d-print-none py-0">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav gap-3">
                <li class="nav-item">
                    <a class="nav-link" href="partyList">Add Customer</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="invoiceCreate">Create Invoice</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="invoicesAll">Invoice Report</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="payment">Payment Received</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="dueAmount">Due Amount</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="addOptions">Add Options</a>
                </li>
            </ul>

        </div>
    </div>
</nav>