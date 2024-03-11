<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Reports Page</title>
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
                                <h4 class="page-title">All Data Reports</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->


                    <!-- Total Payment Till Date -->
                    <div class="row mb-12">
                        <div class="col-4">
                            <div class="card">
                                <div class="card-body">
                                    <?php
                                    require "conn.php";

                                    // Calculate total payment till date
                                    $sql_total_payment = "SELECT SUM(Payments) AS total_payment FROM AddTruckDetails";
                                    $result_total_payment = $conn->query($sql_total_payment);
                                    $row_total_payment = $result_total_payment->fetch_assoc();
                                    $total_payment = $row_total_payment['total_payment'];

                                    echo "Total Collection: $total_payment";

                                    $conn->close();
                                    ?>
                                </div>
                            </div>
                        </div>

                        <!-- Current Month's Total Collection -->
                        <div class="col-4">
                            <div class="card">
                                <div class="card-body">

                                    <?php
                                    require "conn.php";

                                    // Calculate current month's total collection
                                    $current_month = date('m');
                                    $current_year = date('Y');
                                    $sql_current_month_collection = "SELECT SUM(Payments) AS total_collection FROM AddTruckDetails WHERE MONTH(ExitDateTime) = $current_month AND YEAR(ExitDateTime) = $current_year";
                                    $result_current_month_collection = $conn->query($sql_current_month_collection);
                                    $row_current_month_collection = $result_current_month_collection->fetch_assoc();
                                    $total_collection = $row_current_month_collection['total_collection'];
                                    echo date('F') . " Collection: $total_collection";

                                    $conn->close();
                                    ?>
                                </div>
                            </div>
                        </div>


                        <!-- Total Truck Entry Number -->
                        <div class="col-4">
                            <div class="card">
                                <div class="card-body">

                                    <?php
                                    require "conn.php";

                                    // Calculate total truck entry number
                                    $sql_total_truck_entry = "SELECT COUNT(*) AS total_truck_entry FROM AddTruckDetails";
                                    $result_total_truck_entry = $conn->query($sql_total_truck_entry);
                                    $row_total_truck_entry = $result_total_truck_entry->fetch_assoc();
                                    $total_truck_entry = $row_total_truck_entry['total_truck_entry'];

                                    echo "Total Entry: $total_truck_entry";

                                    $conn->close();
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Search form -->
                    <form method="GET" action="">
                        <div class="row mb-3">
                            <div class="col-sm-2">
                                <label for="from_date">From Date:</label>
                                <input type="date" class="form-control" id="from_date" name="from_date">
                            </div>
                            <div class="col-sm-2">
                                <label for="to_date">To Date:</label>
                                <input type="date" class="form-control" id="to_date" name="to_date">
                            </div>
                            <div class="col-sm-2">
                                <label for="search_truck_number">Truck Number:</label>
                                <input type="text" class="form-control" placeholder="Truck Number" name="search_truck_number">
                            </div>
                            <div class="col-sm-2">
                                <label for="search_phone_number">Phone Number:</label>
                                <input type="text" class="form-control" placeholder="Phone Number" name="search_phone_number">
                            </div>
                            <div class="col-sm-2">
                                <label for="search_driver_name">Driver Name:</label>
                                <input type="text" class="form-control" placeholder="Driver Name" name="search_driver_name">
                            </div>
                            <div class="col-sm-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary mt-2">Search</button>
                            </div>
                        </div>
                    </form>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="dataTable" class="table table-centered mb-0 table-nowrap">
                                            <thead>
                                                <tr>
                                                    <th class="text-primary">Id</th>
                                                    <th class="text-secondary">Truck Number</th>
                                                    <th class="text-success">Driver Name</th>
                                                    <th class="text-danger">Phone Number</th>
                                                    <th class="text-info">Entry Date</th>
                                                    <th class="text-info">Exit Date</th>
                                                    <th class="text-info">Payments</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                require "conn.php";

                                                // Define the number of records per page
                                                $records_per_page = 5;

                                                // Calculate the offset based on the current page number
                                                $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                                                $offset = ($current_page - 1) * $records_per_page;

                                                // Modify the SQL query to include the LIMIT clause
                                                $sql = "SELECT * FROM AddTruckDetails WHERE 1=1";

                                                if (isset($_GET['from_date']) && !empty($_GET['from_date'])) {
                                                    $from_date = $_GET['from_date'];
                                                    $sql .= " AND DATE(EntryDateTime) >= '$from_date'";
                                                }

                                                if (isset($_GET['to_date']) && !empty($_GET['to_date'])) {
                                                    $to_date = $_GET['to_date'];
                                                    $sql .= " AND DATE(EntryDateTime) <= '$to_date'";
                                                }

                                                if (isset($_GET['search_truck_number']) && !empty($_GET['search_truck_number'])) {
                                                    $search_truck_number = $_GET['search_truck_number'];
                                                    $sql .= " AND TruckNumber LIKE '%$search_truck_number%'";
                                                }

                                                if (isset($_GET['search_phone_number']) && !empty($_GET['search_phone_number'])) {
                                                    $search_phone_number = $_GET['search_phone_number'];
                                                    $sql .= " AND PhoneNumber LIKE '%$search_phone_number%'";
                                                }

                                                if (isset($_GET['search_driver_name']) && !empty($_GET['search_driver_name'])) {
                                                    $search_driver_name = $_GET['search_driver_name'];
                                                    $sql .= " AND DriverName LIKE '%$search_driver_name%'";
                                                }

                                                $sql .= " ORDER BY id DESC";

                                                // Count total records
                                                $sql_count = "SELECT COUNT(*) AS total_records FROM AddTruckDetails";
                                                $result_count = $conn->query($sql_count);
                                                $row_count = $result_count->fetch_assoc();
                                                $total_records = $row_count['total_records'];

                                                // Calculate total number of pages
                                                $total_pages = ceil($total_records / $records_per_page);

                                                // Modify the SQL query to include the LIMIT clause
                                                $sql .= " LIMIT $offset, $records_per_page";

                                                $result = $conn->query($sql);
                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo "<tr>";
                                                        echo "<td>" . $row["id"] . "</td>";
                                                        echo "<td>" . $row["TruckNumber"] . "</td>";
                                                        echo "<td>" . $row["DriverName"] . "</td>";
                                                        echo "<td>" . $row["PhoneNumber"] . "</td>";
                                                        echo "<td>" . $row["EntryDateTime"] . "</td>";
                                                        echo "<td>" . $row["ExitDateTime"] . "</td>";
                                                        echo "<td>" . ($row["Payments"] ?? "Truck In Parking") . "</td>";
                                                        echo "</tr>";
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='7'>No records found. <a href='reports.php'>View All Data</a></td></tr>";
                                                }
                                                $conn->close();
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php
                                    // Display pagination links
                                echo "<div class='pagination'>";
                                for ($i = 1; $i <= $total_pages; $i++) {
                                    echo "<a href='?page=$i'>";
                                    if ($i == $current_page - 1) {
                                        echo "<span>&laquo;</span>"; // Previous page arrow
                                    }
                                    echo "<span class='mx-1'>$i</span>"; // Page number with space
                                    if ($i == $current_page + 1) {
                                        echo "<span>&raquo;</span>"; // Next page arrow
                                    }
                                    echo "</a>";
                                }
                                echo "</div>";
                                    ?>
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
<!-- jsPDF -->
<script>



function exportToExcel() {
    const wb = XLSX.utils.table_to_book(document.getElementById('dataTable'));
    XLSX.writeFile(wb, 'table_data.xlsx');
}

function exportToCsv() {
    const table = document.getElementById('dataTable');
    const rows = table.querySelectorAll('tr');
    const csv = [];
    for (let i = 0; i < rows.length; i++) {
        const row = [], cols = rows[i].querySelectorAll('td, th');
        for (let j = 0; j < cols.length; j++) {
            row.push(cols[j].innerText);
        }
        csv.push(row.join(','));
    }
    const csvContent = 'data:text/csv;charset=utf-8,' + csv.join('\n');
    const encodedUri = encodeURI(csvContent);
    const link = document.createElement('a');
    link.setAttribute('href', encodedUri);
    link.setAttribute('download', 'table_data.csv');
    document.body.appendChild(link);
    link.click();
}
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>


<!-- xlsx -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>


</body>

</html>
