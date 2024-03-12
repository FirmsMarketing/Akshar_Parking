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
    <title>In The Parking</title>
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
                                <h4 class="page-title">Trucks In The Parking</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <?php
                                        require "conn.php";
                                        $sql = "SELECT * FROM AddTruckDetails ORDER BY id DESC";
                                        $result = $conn->query($sql);
                                        ?>
                                        <?php if ($result->num_rows > 0): ?>
                                            <table class="table table-centered mb-0 table-nowrap">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Truck Number</th>
                                                        <th>Driver Name</th>
                                                        <th>Phone Number</th>
                                                        <th>Date & Time</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php while ($row = $result->fetch_assoc()): ?>
                                                        <?php if ($row["Flag"] == 0): ?>
                                                            <tr>
                                                                <td><?= $row["id"] ?></td>
                                                                <td><?= $row["TruckNumber"] ?></td>
                                                                <td><?= $row["DriverName"] ?></td>
                                                                <td><?= $row["PhoneNumber"] ?></td>
                                                                <td><?= $row["EntryDateTime"] ?></td>
                                                                <td>
                                                                    <form action='checkout.php' method='POST'>
                                                                        <input type='hidden' name='id' value='<?= $row["id"] ?>'>
                                                                        <input type='hidden' name='TruckNumber' value='<?= $row["TruckNumber"] ?>'>
                                                                        <input type='hidden' name='DriverName' value='<?= $row["DriverName"] ?>'>
                                                                        <input type='hidden' name='PhoneNumber' value='<?= $row["PhoneNumber"] ?>'>
                                                                        <button class='btn btn-success' type='submit'>Checkout</button>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        <?php endif; ?>
                                                    <?php endwhile; ?>
                                                </tbody>
                                            </table>
                                        <?php else: ?>
                                            <p>No data found</p>
                                        <?php endif; ?>
                                        <?php $conn->close(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
