<?php
require "conn.php";
date_default_timezone_set('Asia/Kolkata');

// Check if form is submitted and the 'make_bill' button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['make_bill'])) {
    $id = $_POST["id"];

    // Update flag value to 1 for the specified id
    $updateSql = "UPDATE addtruckdetails SET Flag = 1 WHERE id = '$id'";
    if ($conn->query($updateSql) === TRUE) {
        // Display success message if the update is successful
       // echo '<script>alert("Flag value updated to 1");</script>';
    } else {
        // Display error message if the update fails
        echo "Error updating record: " . $conn->error;
    }
}

$id = isset($_POST['id']) ? mysqli_real_escape_string($conn, $_POST['id']) : '';
$fetchSql = "SELECT * FROM addtruckdetails WHERE id = '$id'";
$result = $conn->query($fetchSql);
$row = $result->fetch_assoc();
$entryDateTime = $_GET['EntryDateTime'];
$currentDateTime = date('Y-m-d H:i:s');

$entryDateTimeObj = new DateTime($entryDateTime);
$currentDateTimeObj = new DateTime($currentDateTime);
$interval = $entryDateTimeObj->diff($currentDateTimeObj);
$totalMinutes = $interval->days * 24 * 60 + $interval->h * 60 + $interval->i;
$totalHours = floor($totalMinutes / 60);
$remainingMinutes = $totalMinutes % 60;
$dtime = $totalHours + ($interval->i/60);

if ($dtime <= 12) {
    $parkingCharge = 50;
} elseif ($dtime <= 24) {
    $parkingCharge = 100;
} else {
    $additionalHours = $dtime - 24;
    $additionalCharge = ceil($additionalHours / 12) * 50;
    $parkingCharge = 100 + $additionalCharge;
}

$v_no = $_GET['TruckNumber'];
$d_no = $_GET['PhoneNumber'];
$totalCharges = $parkingCharge;
$hours = sprintf('%d hours %d minutes', $totalHours, $interval->i);

$d = date('Y-m-d', strtotime($currentDateTime));
$t = date('H:i', strtotime($currentDateTime));
$vd = date('Y-m-d', strtotime($entryDateTime));
$vt = date('H:i', strtotime($entryDateTime));

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt Sample</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        @page {
            size: 48mm 135mm;
            margin: 0;
        }
        @media print {
            body {
                margin: 0;
            }
            .container {
                width: 48mm;
                height: 135mm;
                margin: 0;
                padding: 0;
                background: #fff;
                box-shadow: none;
            }
            /* Add your custom print styles here */
            /* Adjust styles for specific elements as needed */
        }
        /* Add your custom styles here */
        /* These styles will be used for screen view */
        body {
            font-family: 'Source Sans Pro', sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            display: block;
            width: 100%;
            max-width: 350px;
            padding: 25px;
            margin: 50px auto 0;
            box-shadow: 0 3px 10px rgb(0 0 0 / 0.2);
        }
        /* Add your other styles here */
    </style>
</head>
<body>
    
<div id="container" class="container">
    
    <div class="receipt_header">
        <h3>Truck Parking Bill</h3>
    </div>
    
    <div class="receipt_body">
        <div class="tit"><strong>Parking Date & Time: </strong></div>
        <div class="tit"><strong>Date : <?php echo $vd; ?></strong></div>
        <div class="tit"><strong>Time : <?php echo $vt; ?></strong></div>
        <hr style="border: none; border-top: 3px solid red;">
        <div class="tit"><strong>Checkout Date & Time: </strong></div>
        <div class="tit"><strong>Date : <?php echo $d; ?></strong></div>
        <div class="tit"><strong>Time : <?php echo $t; ?></strong></div>
        <hr style="border: none; border-top: 3px solid red;">
        <div class="tit"><strong>Vehicle No : </br><?php echo $v_no; ?></strong></div>
        <hr style="border: none; border-top: 3px solid red;">
        <div class="tit"><strong>Phone Number :</br> <?php echo $d_no; ?></strong></div>
        <hr style="border: none; border-top: 3px solid red;">
        <div class="tit"><strong>Total Time: <br><?php echo $hours;; ?></strong></div>
        <hr style="border: none; border-top: 3px solid red;">
        <h3 class="tit"><strong>Bill Amount : <u><?php echo $totalCharges; ?></u></strong></h3>
    </div>
    <h3>Thank You!</h3>
    <i class="fa fa-barcode" style="font-size:48px;color:red"></i><i class="fa fa-barcode" style="font-size:48px;color:red"></i><i class="fa fa-barcode" style="font-size:48px;color:red"></i>

    

</div>

<!-- JavaScript to trigger print automatically -->
<script>
    window.onload = function() {
        // Hide body and html elements
        document.body.style.display = 'none';
        document.documentElement.style.display = 'none';

        // Show container
        document.getElementById('container').style.display = 'block';

        // Print
        window.print();

        // Show body and html elements
        document.body.style.display = 'block';
        document.documentElement.style.display = 'block';
    }
</script>

</body>
</html>
