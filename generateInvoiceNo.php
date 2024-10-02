<?php
include 'db.php';
// Set the timezone
date_default_timezone_set('Asia/Kolkata');

function getFinancialYear($date)
{
    $currentYear = date('y', strtotime($date));
    $currentMonth = date('n', strtotime($date));
    // If current month is April or later, financial year starts from the current year
    if ($currentMonth >= 4) {
        $nextYear = $currentYear + 1;
        return $currentYear . '-' . $nextYear;
    } else {
        // If before April, financial year starts from the previous year
        $previousYear = $currentYear - 1;
        return $previousYear . '-' . $currentYear;
    }
}

// Generate the serial number
function generateInvoiceNumber($conn, $date)
{
    $financialYear = getFinancialYear($date);

    // Prepare and execute the SQL query to get the max serial number
    $query = "SELECT MAX(CAST(SUBSTRING_INDEX(invoiceNo, '/', -1) AS UNSIGNED)) as max_serial
              FROM invoicetotal
              WHERE invoiceNo LIKE ?";

    $stmt = $conn->prepare($query);
    $likePattern = "DP/$financialYear/%";
    $stmt->bind_param('s', $likePattern);
    $stmt->execute();
    $stmt->bind_result($maxSerial);
    $stmt->fetch();
    $stmt->close();

    // If no invoices exist for the current financial year, start from 1
    $newSerial = $maxSerial ? $maxSerial + 1 : 1;

    // Generate the new invoice number
    $invoiceNo = "DP/$financialYear/$newSerial";

    return $invoiceNo;
}

// Generate the invoice number
$date = $_POST['date'];
$invoiceNo = generateInvoiceNumber($conn, $date);

// Return the invoice number
echo $invoiceNo;