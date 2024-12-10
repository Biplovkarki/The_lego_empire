<?php
    session_start();
    include '../connect.php';

    if(!isset($_SESSION['adminname'])){
        header('location: adminauthentication.php');
    }

    $adminCount = $conn->query("SELECT COUNT(adminId) FROM admin_data") -> fetchColumn();
    $userCount = $conn->query("SELECT COUNT(userId) FROM user_data") -> fetchColumn();
    $legoCount = $conn->query("SELECT COUNT(legoId) FROM lego_data") -> fetchColumn();
    $orderCount = $conn->query("SELECT COUNT(orderId) FROM order_data") -> fetchColumn();
    $delieverCount = $conn->query("SELECT COUNT(delieverStatus) FROM order_data WHERE delieverStatus='Delivered'") -> fetchColumn();
    $pendingCount = $conn->query("SELECT COUNT(delieverStatus) FROM order_data WHERE delieverStatus='Pending'") -> fetchColumn();
    $earningCount = $conn->query("SELECT SUM(price) FROM order_data")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Lego Empire</title>
    <link rel="apple-touch-icon" sizes="180x180" href="../../favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../../favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../../favicon/favicon-16x16.png">
    <link rel="manifest" href="../../favicon/site.webmanifest">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link href="https://fonts.cdnfonts.com/css/louis-george-cafe" rel="stylesheet">
    <link rel="stylesheet" href="../../css/admin.css">

    <style>
        body{
            background-color: #f2f4f6;
        }
        .list-group-item.active:hover {
    /* Add your hover styles here */
    background-color: #e9ecef;
    color: #000;
}

    </style>
</head>
<body>
    
    <div class="container">
        <nav class="navbar navbar-expand-lg sticky-top">
            <div class="container">
                <a class="navbar-brand" href="adminpage.php">
                    <img src="../../images/logo.png" alt="The Lego Empire" width="175">
                </a>
            </div>
        </nav>

        <div class="mt-3">
            <div class="account-content p-3">
                <h4 class="fw-bold">Admin Panel</h4>

                <div class="row">
                    <div class="col-3">
                        <div class="list-group" id="list-tab" role="tablist">
                        <a href="adminpage.php" class="list-group-item list-group-item-action border-0 rounded-1 mb-1 fw-bold <?php if(!isset($_GET['section'])) echo 'active'; ?>" id="list-dashboard-list" role="tab" aria-controls="list-dashboard">Dashboard</a>
<a href="?section=vieworder" class="list-group-item list-group-item-action border-0 rounded-1 mb-1 fw-bold <?php if(isset($_GET['section']) && $_GET['section'] == 'vieworder') echo 'active'; ?>" id="list-view-list" role="tab" aria-controls="list-view">Orders</a>
<a href="?section=product" class="list-group-item list-group-item-action border-0 rounded-1 mb-1 fw-bold <?php if(isset($_GET['section']) && $_GET['section'] == 'product') echo 'active'; ?>" id="list-product-list" role="tab" aria-controls="list-product">Products</a>
<a href="?section=viewproduct" class="list-group-item list-group-item-action border-0 rounded-1 mb-1 fw-bold <?php if(isset($_GET['section']) && $_GET['section'] == 'viewproduct') echo 'active'; ?>" id="list-view-list" role="tab" aria-controls="list-view">Edit Products</a>
<a href="?section=access" class="list-group-item list-group-item-action border-0 rounded-1 mb-1 fw-bold <?php if(isset($_GET['section']) && $_GET['section'] == 'access') echo 'active'; ?>" id="list-access-list" role="tab" aria-controls="list-access">Authorized Access</a>
<a href="?section=account" class="list-group-item list-group-item-action border-0 rounded-1 mb-1 fw-bold <?php if(isset($_GET['section']) && $_GET['section'] == 'account') echo 'active'; ?>" id="list-profile-list" role="tab" aria-controls="list-profile">Edit Profile</a>
<a href="?section=changepassword" class="list-group-item list-group-item-action border-0 rounded-1 mb-1 fw-bold <?php if(isset($_GET['section']) && $_GET['section'] == 'changepassword') echo 'active'; ?>" id="list-profile-list" role="tab" aria-controls="list-profile">Change Password</a>
<a class="list-group-item list-group-item-action border-0 rounded-1 mb-1 fw-bold <?php if(isset($_GET['section']) && $_GET['section'] == 'logout') echo 'active'; ?>" data-bs-toggle="modal" data-bs-target="#logoutConfirmationModal" style="cursor: pointer;">Logout</a>

                        </div>
                    </div>
                    <div class="col border-start border-2 ps-4">
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" role="tabpanel">
                            <?php
                                if(isset($_GET['section'])){
                                    $section = $_GET['section'];

                                    switch ($section){
                                        case 'vieworder':
                                            include('vieworder.php');
                                            break;
                                        case 'product':
                                            include('product.php');
                                            break;
                                        case 'viewproduct':
                                            include('viewproduct.php');
                                            break;
                                        case 'access':
                                            include('access.php');
                                            break;
                                        case 'account':
                                            include('account.php');
                                            break;
                                        case 'changepassword':
                                            include('changepassword.php');
                                            break;
                                        default:
                                            echo "Unknown page";
                                            break;
                                    }
                                }else{
                            ?>
                                    <div class="row row-gap-4">  
                                        <div class="col">
                                            <div class="card" style="width: 13.37rem; min-height: 19vh;">
                                                <div class="card-body">
                                                    <div class="row pt-3">
                                                        <div class="col">
                                                            <div class="mt-2 pt-1 ps-1"><i class="fa-solid fa-user-tie" style="color: #000000; font-size: 3.5rem"></i></div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="card-title"><span style="font-size: 2rem;"><?php echo $adminCount ?></span> <br> Admins</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="card" style="width: 13.37rem; min-height: 19vh;">
                                                <div class="card-body">
                                                    <div class="row pt-3">
                                                        <div class="col">
                                                            <div class="mt-2 pt-1 ps-1"><i class="fa-regular fa-circle-user" style="color: #000000; font-size: 3.7rem"></i></div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="card-title"><span style="font-size: 2rem;"><?php echo $userCount ?></span> <br> Users</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="card" style="width: 13.37rem; min-height: 19vh;">
                                                <div class="card-body">
                                                    <div class="row pt-3">
                                                        <div class="col">
                                                            <div class="mt-2 pt-1 ps-1"><i class="fa-solid fa-cubes-stacked" style="color: #000000; font-size: 3.7rem"></i></div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="card-title"><span style="font-size: 2rem;"><?php echo $legoCount ?></span> <br> Products</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="card" style="width: 13.37rem; min-height: 19vh;">
                                                <div class="card-body">
                                                    <div class="row pt-3">
                                                        <div class="col">
                                                            <div class="mt-2 pt-1 ps-1"><i class="fa-solid fa-dolly" style="color: #000000; font-size: 3.5rem"></i></div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="card-title"><span style="font-size: 2rem;"><?php echo $orderCount ?></span> <br> Orders</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="card" style="width: 13.37rem; min-height: 19vh;">
                                                <div class="card-body">
                                                    <div class="row pt-3">
                                                        <div class="col">
                                                            <div class="mt-2 ps-1"><i class="fa-solid fa-check" style="color: #000000; font-size: 3.85rem"></i></div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="card-title"><span style="font-size: 2rem;"><?php echo $delieverCount ?></span> <br> Delieverd</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="card" style="width: 13.37rem; min-height: 19vh;">
                                                <div class="card-body">
                                                    <div class="row pt-3">
                                                        <div class="col">
                                                            <div class="mt-2 pt-1 ps-1"><i class="fa-solid fa-spinner" style="color: #000000; font-size: 3.7rem"></i></div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="card-title"><span style="font-size: 2rem;"><?php echo $pendingCount ?></span> <br> Pending</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card" style="min-width: 13.37rem; min-height: 19vh;">
                                                <div class="card-body">
                                                    <div class="row pt-3">
                                                        <div class="col">
                                                            <div class="mt-2 pt-1 text-center"><i class="fa-solid fa-sack-dollar" style="color: #000000; font-size: 3.5rem"></i></div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="card-title"><span style="font-size: 2rem;">NRs. <?php echo $earningCount ?></span> <br> Earnings</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <?php } ?>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-end fixed-top-container" id="top-container">
        <a href="" id="scroll-to-top">
            <i class="fa-solid fa-angle-up" style="background-color: black; color: #ffffff; padding: 13px; font-size: larger;"></i>
        </a>
    </div>

    <!-- Logout Confirmation Modal -->
    
    <div class="modal fade" id="logoutConfirmationModal" tabindex="-1" aria-labelledby="logoutConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                Are you sure you want to log out?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary pt-1" data-bs-dismiss="modal">Cancel</button>
                <a href="logout.php" class="btn btn-primary pt-1">Logout</a>
            </div>
        </div>
    </div>
    </div>

    <script>
        if( window.history.replaceState ){
            window.history.replaceState( null, null, window.location.href );
        }
    </script>
    
    <script src="../../js/adminscript.js"></script>
    <script src="https://kit.fontawesome.com/296ff2fa8f.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

</body>
</html>