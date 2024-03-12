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
    <title>Trucks Details</title>
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
                                <h4 class="page-title">Trucks Details</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
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
                                                <?php
                                                require "conn.php";
                                                $sql = "SELECT * FROM AddTruckDetails ORDER BY id DESC";
                                                $result = $conn->query($sql);
                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        if ($row["Flag"] == 1) {
                                                            $action = "";
                                                        } else {
                                                            $action = "<form action='checkout.php' method='POST'>
                                                                        <input type='hidden' name='id' value='" . $row["id"] . "'>
                                                                        <input type='hidden' name='TruckNumber' value='" . $row["TruckNumber"] . "'>
                                                                        <input type='hidden' name='DriverName' value='" . $row["DriverName"] . "'>
                                                                        <input type='hidden' name='PhoneNumber' value='" . $row["PhoneNumber"] . "'>
                                                                        <input type='hidden' name='Date&time' value='" . $row["EntryDateTime"] . "'>
                                                                        <button class='btn btn-primary' type='submit'>Checkout</button>
                                                                    </form>";
                                                        }

                                                        echo "<tr>";
                                                        echo "<td>" . $row["id"] . "</td>";
                                                        echo "<td>" . $row["TruckNumber"] . "</td>";
                                                        echo "<td>" . $row["DriverName"] . "</td>";
                                                        echo "<td>" . $row["PhoneNumber"] . "</td>";
                                                        echo "<td>" . $row["EntryDateTime"] . "</td>";
                                                        echo "<td>$action</td>";
                                                        echo "</tr>";
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='7'>No records found</td></tr>";
                                                }
                                                $conn->close();
                                                ?>
                                            </tbody>
                                        </table>
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
