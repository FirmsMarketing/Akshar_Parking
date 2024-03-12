<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
require "conn.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $TruckNumber = $_POST["TruckNumber"];
    $DriverName = $_POST["DriverName"];
    $PhoneNumber = $_POST["PhoneNumber"];
    $EntryDateTime = $_POST["EntryDateTime"];

    // Insert data into database
    $sql = "INSERT INTO AddTruckDetails (TruckNumber, DriverName, PhoneNumber, EntryDateTime) VALUES ('$TruckNumber', '$DriverName', '$PhoneNumber', '$EntryDateTime')";

    if ($conn->query($sql) === true) {
        // Display success message
        // echo '<script>alert("Data Inserted"); window.location = "view-details.php";</script>';
        $d = date('Y-m-d', strtotime($EntryDateTime));
        $t = date('H:i', strtotime($EntryDateTime));
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
            size: 48mm 100mm;
            margin: 0;
        }
        @media print {
            body {
                margin: 0;
            }
            .container {
                width: 48mm;
                height: 100mm;
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
        <h3>Truck Entry Receipt</h3>
    </div>
    
    <div class="receipt_body">
        <div class="tit"><strong>Parking Date & Time: </strong></div>
        <div class="tit"><strong>Date : <?php echo $d; ?></strong></div>
        <div class="tit"><strong>Time : <?php echo $t; ?></strong></div>
        <hr style="border: none; border-top: 3px solid red;">
        <div class="tit"><strong>Vehicle No : </br><?php echo $TruckNumber; ?></strong></div>
        <hr style="border: none; border-top: 3px solid red;">
        <div class="tit"><strong>Phone Number :</br> <?php echo $PhoneNumber; ?></strong></div>
        <hr style="border: none; border-top: 3px solid red;">
        <div class="tit"><strong>Driver Name: <br><?php echo $DriverName;; ?></strong></div>
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

        // Redirect to index.php after printing
        window.location.href = 'index.php';

        // Show body and html elements
        document.body.style.display = 'block';
        document.documentElement.style.display = 'block';
    }
</script>
<?php
}
else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
}
?>
</body>
</html>
