<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
require "conn.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Add Truck Details</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <!-- Theme Config Js -->
    <script src="assets/js/config.js"></script>
    <!-- App css -->
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />
    <!-- Icons css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
</head>
<body>
<!-- Begin page -->
<div class="wrapper">

    <!-- ========== Topbar Start ========== -->
    <?php require "topbar.php"; ?>
    <!-- ========== Topbar End ========== -->


    <!-- ========== Left Sidebar Start ========== -->
    <?php require "left-sidebar.php"; ?>
    <!-- ========== Left Sidebar End ========== -->

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
    <div class="content-page">
        <div class="content">
            <!-- Start Content-->
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <h4 class="page-title">Add Truck Details</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row">
                    <div class="col-lg-10">
                        <div class="card">

                            <div class="card-body">
                                <form class="needs-validation"  action="checkin_bill.php" method="POST">
                                <div class="mb-3">
    <label class="form-label" for="validationCustom01">Truck Number</label>
    <input type="text" class="form-control" name="TruckNumber" id="validationCustom01" placeholder="Enter Truck Number" required oninput="this.value = this.value.toUpperCase(); validateTruckNumber(this)">
    <div class="valid-feedback"> Looks good! </div>
    <div class="invalid-feedback">Truck number should be between 4 and 10 letters.</div>
</div>

<script>
function validateTruckNumber(input) {
  if (input.value.length < 4 || input.value.length > 10) {
        input.setCustomValidity("Truck number should be between 4 and 10 letters.");
    } else {
        input.setCustomValidity("");
    }
}
</script>


<div class="mb-3">
    <label class="form-label" for="validationCustom02">Driver name</label>
    <input type="text" class="form-control" name="DriverName" id="validationCustom02" placeholder="Driver Name" required oninput="this.value = this.value.toUpperCase(); validateDriverName(this)">
    <div class="valid-feedback"> Looks good! </div>
    <div class="invalid-feedback">Driver name should be between 4 and 20 letters.</div>
</div>

<script>
function validateDriverName(input) {
    if (input.value.length < 4 || input.value.length > 20) {
        input.setCustomValidity("Driver name should be between 4 and 20 letters.");
    } else {
        input.setCustomValidity("");
    }
}
</script>


                                    <div class="mb-3">
    <label class="form-label" for="validationCustomUsername">Phone Number</label>
    <div class="input-group">
        <span class="input-group-text" id="inputGroupPrepend">+91</span>
        <input type="text" class="form-control" name="PhoneNumber" id="validationCustomUsername" placeholder="Enter Driver Number" aria-describedby="inputGroupPrepend" pattern="[0-9]{10}" required>
        <div class="invalid-feedback">Please enter a 10-digit number.</div>
    </div>
</div>

<div class="mb-3">
    <label class="form-label" for="validationCustom03">Date and Time</label>
    <?php
    date_default_timezone_set('Asia/Kolkata');
    $EntryDateTime = date('Y-m-d\TH:i');
    ?>
    <input type="datetime-local" class="form-control" name="EntryDateTime" id="validationCustom03" value="<?php echo $EntryDateTime; ?>" required readonly>
</div>



<?php
date_default_timezone_set("Asia/Kolkata");
$currentTime = date("H:i");
?>



                                    <button class="btn btn-primary" type="submit">Add Truck Details</button>
                                </form>
                            </div>
                            <!-- end card-body-->
                        </div>
                        <!-- end card-->
                    </div>
                    <!-- end col-->
                </div>
                <!-- end row -->
            </div>
            <!-- container -->
        </div>
        <!-- content -->
    </div>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->
</div>
<!-- END wrapper -->
<!-- Vendor js -->
<script src="assets/js/vendor.min.js"></script>
<!-- App js -->
<script src="assets/js/app.min.js"></script>
</body>
</html>