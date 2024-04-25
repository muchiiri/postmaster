<?php
session_start(); // Ensure session is started
require_once './models/DatabaseConnection.php';
require_once './models/ParcelModel.php';
require_once './models/PointModel.php';
require_once './models/UserModel.php'; // Assuming you have a UserModel

$pdoConnection = DatabaseConnection::getPDOConnection();
$parcelModel = new ParcelModel($pdoConnection);
$pointModel = new PointModel($pdoConnection);
$userModel = new UserModel($pdoConnection); // Assuming UserModel follows similar structure

$username = $_SESSION['username']; // Assuming username is stored in session
$parcels = $parcelModel->getParcelsByDeliveryUser($username); // This is an array
$totalParcels = count($parcels); // Count the array to get the total number of parcels
$totalRecipients = $pointModel->getAllRecipients();
$totalUsers = $userModel->getAllUsers(); // This method needs to be defined in your UserModel

$deliveryUsersCount = count(array_filter($totalUsers, function ($user) {
    return $user['user_type'] === 'delivery_user';
}));

$locations = $pointModel->getAllRecipients(); // Fetch all recipients with their locations
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="./views/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="./views/assets/css/sb-admin-2.min.css" rel="stylesheet">

</head>


<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <!-- <i class="fas fa-laugh-wink"></i> -->
                </div>
                <div class="sidebar-brand-text mx-3"> </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="dashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Menus
            </div>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <li class="nav-item">
                <a class="nav-link" href="./controllers/AuthController.php?action=logout">
                    <i class="fas fa-fw fa-boxes"></i>
                    <span>Logout</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
                        

                        
                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"></span>
                                <img class="img-profile rounded-circle"
                                    src="./views/assets/img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="./controllers/AuthController.php?action=logout">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                       
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-12 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Parcels Assigned
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"> 
                                                        <?php echo $totalParcels; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-boxes fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">My Parcels</h1>
                   
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                           
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                        <th>Delivery User</th>
                                        <th>Recipient</th>
                                        <th>Status</th>
                                        <th>QR Code</th>
                                        <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                        <th>Delivery User</th>
                                        <th>Recipient</th>
                                        <th>Status</th>
                                        <th>QR Code</th>
                                        <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php foreach ($parcels as $parcel): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($parcel['delivery_user']); ?></td>
                                            <td><?php echo htmlspecialchars($parcel['recipient_name']); ?></td>
                                            <td><?php echo htmlspecialchars($parcel['parcel_status']); ?></td>
                                            <td>
                                                <div id="qrcode-<?php echo $parcel['parcel_id']; ?>" style="width: 128px; height: 128px;"></div>
                                            </td>
                                            <td>
                                                <a href="./views/parcels/update.php?parcel_id=<?php echo htmlspecialchars($parcel['parcel_id']); ?>" class="btn btn-info">Edit</a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                           Map
                        </div>
                        <div class="card-body">
                        <div id="map" style="width:100%; height:400px"></div>
                        </div>
                    </div>

                </div>

                    <!-- Content Row -->
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy;  2024</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="../../controllers/AuthController.php?action=logout">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/qrcodejs/qrcode.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php foreach ($parcels as $parcel): ?>
        var qrText = 'Parcel ID: ' + '<?php echo $parcel['parcel_id']; ?>' +
                     '\nDelivery User: ' + '<?php echo $parcel['delivery_user']; ?>' +
                     '\nRecipient: ' + '<?php echo $parcel['recipient_name']; ?>' +
                     '\nStatus: ' + '<?php echo $parcel['parcel_status']; ?>';
        new QRCode(document.getElementById('qrcode-<?php echo $parcel['parcel_id']; ?>'), {
            text: qrText,
            width: 128,
            height: 128
        });
        <?php endforeach; ?>
    });
    </script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBjVpB9eq5f51--XJJObhcATR8XCjJMkM8&callback=initMap"></script>
<script>
    function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
        center: new google.maps.LatLng(-1.2180603, 36.8766577),
        zoom: 10
    });

    var locations = <?php echo json_encode($locations); ?>;
    console.log("Parsed Locations:", locations);

    locations.forEach(function(location) {
        console.log("Attempting to create marker for:", location.recipient_name);
        console.log("Coordinates:", parseFloat(location.latitude_point.trim()), parseFloat(location.longitude_point.trim()));
        
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(parseFloat(location.longitude_point.trim()), parseFloat(location.latitude_point.trim())),
            map: map,
            title: location.recipient_name
        });

        console.log("Marker created:", marker);
    });
}
</script>

    <!-- Bootstrap core JavaScript-->
    <script src="./views/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    
    <!-- Custom scripts for all pages-->
    <script src="./views/assets/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="./views/assets/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="./views/assets/js/demo/chart-area-demo.js"></script>
    <script src="./views/assets/js/demo/chart-pie-demo.js"></script>

    


</body>
</html>
