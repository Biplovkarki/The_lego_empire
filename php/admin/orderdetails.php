<?php
session_start();
include '../connect.php';

if(!isset($_SESSION['adminname'])){
    header('location: adminauthentication.php');
    exit();
}

if(isset($_GET['userId']) && isset($_GET['legoId']) && isset($_GET['transactionId'])){
    $userId = $_GET['userId'];
    $legoId = $_GET['legoId'];
    $transactionId = $_GET['transactionId'];
} else {
    // Redirect if required parameters are not set
    header('location: adminpage.php?section=vieworder');
    exit();
}

$sql = "SELECT * FROM profile_data WHERE userId = :userId";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':userId', $userId);
$stmt->execute();
$userdata = $stmt->fetchAll(PDO::FETCH_ASSOC);

if(isset($_POST['delieverStatus'])){
    $delieverStatus = $_POST['delieverStatus'];

    $stmt = $conn->prepare("UPDATE order_data SET delieverStatus = :delieverStatus WHERE userId = :userId AND legoId = :legoId AND transactionId = :transactionId");
    $stmt->bindParam(':delieverStatus', $delieverStatus);
    $stmt->bindParam(':userId', $userId);
    $stmt->bindParam(':legoId', $legoId);
    $stmt->bindParam(':transactionId', $transactionId);
    $stmt->execute();

    header('location: adminpage.php?section=vieworder');
    exit();
}
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
    <link rel="stylesheet" href="../../css/user.css">
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
                <h4 class="fw-bold">Order & Customer Information</h4>

                <div class="update-content-container mt-3" id="update">
                    
                <?php
                    $stmt = $conn->prepare("SELECT * FROM order_data WHERE userId = :userId AND legoId = :legoId AND transactionId = :transactionId");
                    $stmt->bindParam(':userId', $userId);
                    $stmt->bindParam(':legoId', $legoId);
                    $stmt->bindParam(':transactionId', $transactionId);
                    $stmt->execute();
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if($result && $result[0]['delieverStatus'] === "Delivered"){
                ?>
                        <form action="" method="POST" class="form">
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="transactionId" class="form-label fw-bold">Transaction ID</label>
                                        <input type="text" class="form-control" name="transactionId" id="transactionId" value="<?php echo $result[0]['transactionId']; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="title" class="form-label fw-bold">Product</label>
                                        <input type="text" class="form-control" name="title" id="title" value="<?php echo $result[0]['title']; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="price" class="form-label fw-bold">Price</label>
                                        <input type="text" class="form-control" name="price" id="price" value="NRs. <?php echo $result[0]['price']; ?>" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="mb-4">
                                        <label for="name" class="form-label fw-bold">Customer Name</label>
                                        <input type="text" class="form-control" name="name" id="name" value="<?php echo $userdata[0]['name']; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-4">
                                        <label for="phone" class="form-label fw-bold">Phone Number</label>
                                        <input type="text" class="form-control" name="phone" id="phone" value="<?php echo $userdata[0]['phone']; ?>" readonly>
                                    </div>
                                </div>  
                                <div class="col">
                                    <div class="mb-4">
                                        <label for="email" class="form-label fw-bold">Email Address</label>
                                        <input type="text" class="form-control" name="email" id="email" value="<?php echo $userdata[0]['email']; ?>" readonly>
                                    </div>
                                </div>  
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="province" class="form-label fw-bold">Province</label>
                                        <input type="text" class="form-control" name="province" id="province" value="<?php echo $userdata[0]['province']; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-4">
                                        <label for="city" class="form-label fw-bold">City</label>
                                        <input type="text" class="form-control" name="city" id="city" value="<?php echo $userdata[0]['city']; ?>" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="mb-4">
                                        <label for="area" class="form-label fw-bold">Area</label>
                                        <input type="text" class="form-control" name="area" id="area" value="<?php echo $userdata[0]['area']; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="address" class="form-label fw-bold">Address</label>
                                        <input type="text" class="form-control" name="address" id="address" value="<?php echo $userdata[0]['address']; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-4">
                                        <label for="landmark" class="form-label fw-bold">Landmark</label>
                                        <input type="text" class="form-control" name="landmark" id="landmark" value="<?php echo $userdata[0]['landmark']; ?>" readonly>
                                    </div>
                                </div>
                            </div>
                        </form>

                <?php
                    } else if($result && $result[0]['delieverStatus'] === "Pending"){
                ?>
                        <form action="" method="POST" class="form">
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="transactionId" class="form-label fw-bold">Transaction ID</label>
                                        <input type="text" class="form-control" name="transactionId" id="transactionId" value="<?php echo $result[0]['transactionId']; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="title" class="form-label fw-bold">Product</label>
                                        <input type="text" class="form-control" name="title" id="title" value="<?php echo $result[0]['title']; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="price" class="form-label fw-bold">Price</label>
                                        <input type="text" class="form-control" name="price" id="price" value="NRs. <?php echo $result[0]['price']; ?>" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="mb-4">
                                        <label for="name" class="form-label fw-bold">Customer Name</label>
                                        <input type="text" class="form-control" name="name" id="name" value="<?php echo $userdata[0]['name']; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-4">
                                        <label for="phone" class="form-label fw-bold">Phone Number</label>
                                        <input type="text" class="form-control" name="phone" id="phone" value="<?php echo $userdata[0]['phone']; ?>" readonly>
                                    </div>
                                </div>  
                                <div class="col">
                                    <div class="mb-4">
                                        <label for="email" class="form-label fw-bold">Email Address</label>
                                        <input type="text" class="form-control" name="email" id="email" value="<?php echo $userdata[0]['email']; ?>" readonly>
                                    </div>
                                </div>  
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="province" class="form-label fw-bold">Province</label>
                                        <input type="text" class="form-control" name="province" id="province" value="<?php echo $userdata[0]['province']; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-4">
                                        <label for="city" class="form-label fw-bold">City</label>
                                        <input type="text" class="form-control" name="city" id="city" value="<?php echo $userdata[0]['city']; ?>" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="mb-4">
                                        <label for="area" class="form-label fw-bold">Area</label>
                                        <input type="text" class="form-control" name="area" id="area" value="<?php echo $userdata[0]['area']; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="address" class="form-label fw-bold">Address</label>
                                        <input type="text" class="form-control" name="address" id="address" value="<?php echo $userdata[0]['address']; ?>" readonly>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-4">
                                        <label for="landmark" class="form-label fw-bold">Landmark</label>
                                        <input type="text" class="form-control" name="landmark" id="landmark" value="<?php echo $userdata[0]['landmark']; ?>" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn cart-btn pt-1 px-5 fw-bold" name="delieverStatus" id="delieverStatus" value="Delivered" style="border: none; background-color: black; color: white;">Order Delivered</button>
                            </div>
                        </form>
                <?php } else { ?>
                    <p>No order data found or order status is not 'Pending' or 'Delivered'.</p>
                <?php } ?>
                
                </div>
            </div>
        </div>
    </div>

    <div class="text-end fixed-top-container" id="top-container">
        <a href="" id="scroll-to-top">
            <i class="fa-solid fa-angle-up" style="background-color: black; color: #ffffff; padding: 13px; font-size: larger;"></i>
        </a>
    </div>

    <script>
        if( window.history.replaceState ){
            window.history.replaceState( null, null, window.location.href );
        }
    </script>
    
    <script src="../../js/userscript.js"></script>
    <script src="https://kit.fontawesome.com/296ff2fa8f.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

</body>
</html>
