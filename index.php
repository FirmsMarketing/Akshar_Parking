<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
require "conn.php";

// Check the user's role
if ($_SESSION['role'] == 0) {
    // User role is 0, they can't access the reports section
    $showReports = false;
} else {
    // User can access the reports section
    $showReports = true;
}

// Count records where Flag is 0
$sql_count = "SELECT COUNT(*) as total FROM AddTruckDetails WHERE Flag = 0";
$result_count = $conn->query($sql_count);

if ($result_count->num_rows > 0) {
    $row_count = $result_count->fetch_assoc();
    $total_trucks_in_parking = $row_count['total'];
} else {
    $total_trucks_in_parking = 0;
}

// Get today's date in the format YYYY-MM-DD
$today_date = date("Y-m-d");

// Count total records for today's entry
$sql_count_today_entry = "SELECT COUNT(*) as total FROM AddTruckDetails WHERE DATE(EntryDateTime) = '$today_date'";
$result_count_today_entry = $conn->query($sql_count_today_entry);

if ($result_count_today_entry->num_rows > 0) {
    $row_count_today_entry = $result_count_today_entry->fetch_assoc();
    $total_today_entry = $row_count_today_entry['total'];
} else {
    $total_today_entry = 0;
}

// Calculate total payments for today's exit date
$sql_total_payments_today = "SELECT SUM(Payments) as total_payments FROM AddTruckDetails WHERE DATE(ExitDateTime) = '$today_date'";
$result_total_payments_today = $conn->query($sql_total_payments_today);

if ($result_total_payments_today->num_rows > 0) {
    $row_total_payments_today = $result_total_payments_today->fetch_assoc();
    $total_payments_today = $row_total_payments_today['total_payments'];
} else {
    $total_payments_today = 0;
}

$conn->close();
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
        <?php require "topbar.php" ?>
        <!-- ========== Topbar End ========== -->


        <!-- ========== Left Sidebar Start ========== -->
        <?php require "left-sidebar.php" ?>
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
                               
                                <h4 class="page-title">Welcome!</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                    <div class="col-xxl-3 col-sm-6">
                          <a href="truck_in_parking.php" style="text-decoration: none; color: inherit;">
                            <div class="card widget-flat text-bg-danger">
                              <div class="card-body">
                                <div class="float-end">
                                  <i class="ri-truck-line widget-icon"></i>
                                </div>
                                <h6 class="text-uppercase mt-0" title="Customers">Trucks In Parking</h6>
                                <h2 class="my-2"><?php echo $total_trucks_in_parking; ?></h2>
                              </div>
                            </div>
                          </a>
                        </div> <!-- end col-->

                        <div class="col-xxl-3 col-sm-6">
                        <a href="today_entry.php" style="text-decoration: none; color: inherit;">
                            <div class="card widget-flat text-bg-purple">
                                <div class="card-body">
                                    <div class="float-end">
                                        <i class="ri-bar-chart-line widget-icon"></i>
                                    </div>
                                    <h6 class="text-uppercase mt-0" title="Customers">Today Entry</h6>
                                    <h2 class="my-2"><?php echo $total_today_entry; ?></h2>
                                </div>
                            </div>
                            </a>
                        </div> <!-- end col-->

                        <div class="col-xxl-3 col-sm-6">
                            <div class="card widget-flat text-bg-info">
                                <div class="card-body">
                                    <div class="float-end">
                                        <i class="ri-wallet-3-line widget-icon"></i>
                                    </div>
                                    <h6 class="text-uppercase mt-0" title="Customers">Today Collection</h6>
                                    <h2 class="my-2"><?php echo $total_payments_today; ?> ₹</h2>
                                </div>
                            </div>
                        </div> <!-- end col-->

                        <?php if ($showReports): ?>
                        <div class="col-xxl-3 col-sm-6">
                        <a href="reports.php" style="text-decoration: none; color: inherit;">
                            <div class="card widget-flat text-bg-secondary">
                                <div class="card-body">
                                    <div class="float-end">
                                    <i class="ri-history-line widget-icon"></i>
                                    </div>
                                    <h6 class="text-uppercase mt-0" title="Customers">Reports</h6>
                                    <h2 class="my-2">Data</h2>
                                </div>
                            </div>
                            </a>
                        </div> <!-- end col-->
                        <?php endif; ?>

                    </div>
                    <!-- end row -->

                    <div class="row">            
                        <div class="col-xl-12">
                            <!-- Todo-->
                            <div class="card">
                                <div class="card-body p-0">
                                    <div class="p-3">
                                        <div class="card-widgets">
                                            <a href="javascript:;" data-bs-toggle="reload"><i
                                                    class="ri-refresh-line"></i></a>
                                        </div>
                                        <h5 class="header-title mb-0">Recent Entries</h5>
                                    </div>

                                    <div id="yearly-sales-collapse" class="collapse show">
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

                                                // Fetch last 5 entries
                                                $sql = "SELECT * FROM AddTruckDetails ORDER BY id DESC LIMIT 5";
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
                                                    echo "<tr><td colspan='6'>No records found</td></tr>";
                                                }
                                                $conn->close();
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    </div>
                                    <div class="text-center mt-3 mb-3">
                                        <a href="view-details.php" class="btn-link">View More Data</a>
                                    </div>

                                </div>
                            </div> <!-- end card-->
                        </div> <!-- end col-->
                    </div>
                    <!-- end row -->

                </div>
                <!-- container -->

            </div>
            <!-- content -->

            <!-- Footer Start -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 text-center">
                            <script>document.write(new Date().getFullYear())</script> ©  - Developed by
                            <b>Firms.Marketing</b>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end Footer -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->
<!-- END wrapper -->
<!-- Vendor js -->
<script src="assets/js/vendor.min.js"></script>
<!-- App js -->
<script src="assets/js/app.min.js"></script>
</body>

</html>
