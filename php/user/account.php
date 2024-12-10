<?php
    session_start();
    include '../connect.php';

    $cartTotal = 0;

    if(isset($_SESSION['userId'])){
        $userId = $_SESSION['userId'];
    }

    if(isset($_POST['update-submit'])){
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];

        if(empty($_POST['name']) || empty($_POST['phone']) || empty($_POST['email'])){
            $update = 0;
        }else{
            $sql = "UPDATE user_data SET name = :name, phone = :phone, email = :email WHERE userId = :userId";
            $stmt = $conn->prepare($sql);
            $stmt ->bindParam(':userId', $userId);
            $stmt ->bindParam(':name', $name);
            $stmt ->bindParam(':phone', $phone);
            $stmt ->bindParam(':email', $email);
            $stmt ->execute();

            $sql = "UPDATE profile_data SET name = :name, phone = :phone, email = :email WHERE userId = :userId";
            $stmt = $conn->prepare($sql);
            $stmt ->bindParam(':userId', $userId);
            $stmt ->bindParam(':name', $name);
            $stmt ->bindParam(':phone', $phone);
            $stmt ->bindParam(':email', $email);

            if($stmt->execute()){
                $update = 1;
            }
        }
    }

    if(isset($_POST['change-submit'])){
        $oldPassword = $_POST['oldPassword'];
        $newPassword = $_POST['newPassword'];
        $confirmPassword = $_POST['confirmPassword'];
    
        if(empty($oldPassword) || empty($newPassword) || empty($confirmPassword)){
            $change = 3;
        }else if($newPassword !== $confirmPassword){
            $change = 2;
        }else{
            $sql = "SELECT password FROM user_data WHERE userId = :userId";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if($result) {
                $storedPassword = $result['password'];
            
                if(password_verify($oldPassword, $storedPassword)){
                    $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            
                    $sql = "UPDATE user_data SET password = :newPassword WHERE userId = :userId";
                    $stmt = $conn->prepare($sql);
                    $stmt ->bindParam(':userId', $userId);
                    $stmt ->bindParam(':newPassword', $hashedNewPassword);
            
                    if($stmt->execute()){
                        $change = 0;
                    }
                }else{
                    $change = 1;
                }
            }
        }
    }

    if(isset($_POST['billing-submit'])){
       // $country = $_POST['country'];
        $province = $_POST['province'];
        $city = $_POST['city'];
        $area = $_POST['area'];
        $address = $_POST['address'];
        $landmark = $_POST['landmark'];

        if( empty($_POST['province']) || empty($_POST['city']) || empty($_POST['area']) || empty($_POST['address']) || empty($_POST['landmark'])){
            $billing = 0;
        }else{
            $sql = "UPDATE profile_data SET  province = :province, city = :city, area = :area, address = :address, landmark = :landmark WHERE userId = :userId";
            $stmt = $conn->prepare($sql);
            $stmt ->bindParam(':userId', $userId);
          
            $stmt ->bindParam(':province', $province);
            $stmt ->bindParam(':city', $city);
            $stmt ->bindParam(':area', $area);
            $stmt ->bindParam(':address', $address);
            $stmt ->bindParam(':landmark', $landmark);

            if($stmt->execute()){
                $billing = 1;
            }
        }
    }

    if(isset($_POST['delete-account'])){
        $stmt = $conn->prepare("DELETE FROM user_data WHERE userId = :userId");
        $stmt ->bindParam(':userId', $userId);
        $stmt ->execute();

        $stmt = $conn->prepare("DELETE FROM profile_data WHERE userId = :userId");
        $stmt ->bindParam(':userId', $userId);
        $stmt ->execute();

        $stmt = $conn->prepare("DELETE FROM order_data WHERE userId = :userId");
        $stmt ->bindParam(':userId', $userId);
        $stmt ->execute();
    
        header('location: logout.php');
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
    <!-- <link rel="stylesheet" href="/htdocs/fontawesome/css/all.min.css"> -->
    <link rel="stylesheet" href="/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../../css/user.css">
</head>
<body>
    
    <div class="container">
        <nav class="navbar navbar-expand-lg sticky-top">
            <div class="container">
                <a class="navbar-brand" href="userpage.php">
                    <img src="../../images/logo.png" alt="The Lego Empire" width="175">
                </a>
    
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                    
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a href="cart.php" class="nav-link pe-1">
                                <i class="fa-solid fa-cart-shopping" style="color: #000000; font-size: 1.1rem;"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="mt-3">
            <div class="account-content p-3">
                <h4 class="fw-bold">Manage Account</h4>

                <div class="row">
                    <div class="col-3">
                        <div class="list-group" id="list-tab" role="tablist">
                            <a href="#list-profile" class="list-group-item list-group-item-action border-0 rounded-1 mb-1 fw-bold active" id="list-profile-list" data-bs-toggle="list" role="tab" aria-controls="list-profile">Edit Profile</a>
                            <a href="#list-password" class="list-group-item list-group-item-action border-0 rounded-1 mb-1 fw-bold" id="list-password-list" data-bs-toggle="list" role="tab" aria-controls="list-password">Change Password</a>
                            <a href="#list-billing" class="list-group-item list-group-item-action border-0 rounded-1 mb-1 fw-bold" id="list-billing-list" data-bs-toggle="list" role="tab" aria-controls="list-billing">Billing Address</a>
                            <a href="#list-order" class="list-group-item list-group-item-action border-0 rounded-1 mb-1 fw-bold" id="list-order-list" data-bs-toggle="list" role="tab" aria-controls="list-order">My Orders</a>
                            <a class="list-group-item list-group-item-action border-0 rounded-1 mb-1 fw-bold" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal" style="cursor: pointer;">Delete Account</a>
                            <a class="list-group-item list-group-item-action border-0 rounded-1 mb-1 fw-bold" data-bs-toggle="modal" data-bs-target="#logoutConfirmationModal" style="cursor: pointer;">Logout</a>
                        </div>
                    </div>
                    <div class="col border-start border-2 ps-4">
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
                                <div class="update-content-container" id="update">
                                    <?php
                                        $sql = "SELECT * FROM profile_data WHERE userId = :userId";
                                        $stmt = $conn->prepare($sql);
                                        $stmt ->bindParam(':userId', $userId);
                                        $stmt ->execute();
                                        $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                    ?>

                                    <form action="" method="POST" class="form">
                                        <div class="mb-3">
                                            <label for="name" class="form-label fw-bold">Name</label>
                                            <input type="text" class="form-control" name="name" placeholder="Enter name" id="name" value="<?php echo isset($result['name']) ? $result['name'] : ''; ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="phone" class="form-label fw-bold">Phone Number</label>
                                            <input type="number" class="form-control" name="phone" placeholder="Enter phone number" id="phone" value="<?php echo $result['phone'] ?>">
                                        </div>
                                        <div class="mb-4">
                                            <label for="email" class="form-label fw-bold">Email Address</label>
                                            <input type="email" class="form-control" name="email" placeholder="Enter email address" id="email" value="<?php echo is_array($result) && isset($result['email']) ? $result['email'] : ''; ?>">
                                        </div>
                                        
                                        <div class="d-flex justify-content-end">
                                            <button type="submit" class="btn pt-1 px-5 fw-bold" name="update-submit" id="update-submit" value="Update" style="border: none; background-color: black; color: white;">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="list-password" role="tabpanel" aria-labelledby="list-password-list">
                                <div class="update-content-container" id="update">
                                    <form action="" method="POST" class="form">
                                        <div class="mb-3">
                                            <label for="password" class="form-label fw-bold">Old Password</label>
                                            <input type="text" class="form-control" name="oldPassword" id="password">
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label fw-bold">New Password</label>
                                            <input type="text" class="form-control" name="newPassword" id="password">
                                        </div>
                                        <div class="mb-4">
                                            <label for="password" class="form-label fw-bold">Confirm New Password</label>
                                            <input type="text" class="form-control" name="confirmPassword" id="password">
                                        </div>
                                        
                                        <div class="d-flex justify-content-end">
                                            <button type="submit" class="btn pt-1 px-5 fw-bold" name="change-submit" id="change-submit" value="Change Password" style="border: none; background-color: black; color: white;">Change Password</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="list-billing" role="tabpanel" aria-labelledby="list-billing-list">
                                <div class="update-content-container" id="update">
                                    <form action="" method="POST" class="form">
                                        <div class="mb-3">
                                            <label for="province" class="form-label fw-bold">Province</label>
                                            <select class="form-select" name="province" id="province">
                                                <option value="<?php echo $result['province'] ?>"><?php echo $result['province'] ?></option>
                                                <option value="Bagmati">Bagmati</option>
                                                <option value="Gandaki">Gandaki</option>
                                                <option value="Karnali">Karnali</option>
                                                <option value="Koshi">Koshi</option>
                                                <option value="Lumbini">Lumbini</option>
                                                <option value="Madesh">Madesh</option>
                                                <option value="Sudurpashchim">Sudurpashchim</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="city" class="form-label fw-bold">City</label>
                                            <input type="text" class="form-control" name="city" placeholder="Enter city name" id="city" value="<?php echo $result['city'] ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="area" class="form-label fw-bold">Area</label>
                                            <input type="text" class="form-control" name="area" placeholder="Enter area name" id="area" value="<?php echo $result['area'] ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="address" class="form-label fw-bold">Address</label>
                                            <input type="text" class="form-control" name="address" placeholder="Enter building/ street/ house no." id="address" value="<?php echo $result['address'] ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="landmark" class="form-label fw-bold">Landmark</label>
                                            <input type="text" class="form-control" name="landmark" placeholder="Example: beside bank" id="landmark" value="<?php echo $result['landmark'] ?>">
                                        </div>

                                        <div class="d-flex justify-content-end">
                                            <button type="submit" class="btn pt-1 px-5 fw-bold" name="billing-submit" id="billing-submit" value="Billing" style="border: none; background-color: black; color: white;">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="list-order" role="tabpanel" aria-labelledby="list-order-list">
                                <div class="update-content-container" id="update">
                                    <div class="cart-content">
                                        <?php 
                                            $sql = "SELECT * FROM order_data WHERE userId = :userId ORDER BY orderId DESC";
                                            $stmt = $conn->prepare($sql);
                                            $stmt ->bindParam(':userId', $userId);
                                            $stmt ->execute();
                                        ?>
                                        
                                        <h4 class="fw-bold">My Orders</h4>
                                        <div class="row">
                                            <div class="col">
                                                <table class="table">
                                                    <tr>
                                                        <td class="fw-bold text-center">Item</td>
                                                        <td class="fw-bold">Lego Name</td>
                                                        <td class="fw-bold">Transaction ID</td>
                                                        <td class="fw-bold">Quantity</td>
                                                        <td class="fw-bold">Total</td>
                                                    </tr>

                                                    <?php
                                                        $count = 1;
                                                        $total = 0;
                                                        $charge = 5;

                                                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                                            $legoId = $row['legoId'];
                                                            $title = $row['title'];
                                                            $transactionId = $row['transactionId'];
                                                            $quantity = $row['quantity'];
                                                            $price = $row['price'];

                                                            $subTotal = $price * $quantity;
                                                            $total += $subTotal;
                                                            $cartTotal = $total + $charge;
                                    
                                                            echo '<tr>';
                                                                echo '<td class="text-center">' . $count . '</td>';
                                                                echo '<td>' . $title . '</td>';
                                                                echo '<td>' . $transactionId . '</td>';
                                                                echo '<td class=" quantity-change px-4">'. $quantity .'</td>';
                                                                echo '<td>' . 'NRs ' . $subTotal . '</td>';
                                                            echo '</tr>';
                                    
                                                            $count++;
                                                        }
                                                    ?>
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

    <!-- Delete Confirmation -->

    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                Are you sure you want to delete your account?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary pt-1" data-bs-dismiss="modal">Cancel</button>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <button type="submit" class="btn btn-primary pt-1" name="delete-account" id="delete">Delete account</button>
                </form>
            </div>
        </div>
    </div>
    </div>

    <!-- Success Message -->

    <div class="toast-container position-fixed bottom-0 start-0 p-3">
    <div id="userSuccessToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto" id="successToastHead"></strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body" id="successToastBody"></div>
    </div>
    </div>

    <!-- Error Message -->

    <div class="toast-container position-fixed bottom-0 start-0 p-3">
    <div id="userErrorToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto" id="errorToastHead"></strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body" id="errorToastBody"></div>
    </div>
    </div>

    <script>
        <?php
            if(isset($update) && $update === 1){
                echo 'document.addEventListener("DOMContentLoaded", function(){
                    var successToast = new bootstrap.Toast(document.getElementById("userSuccessToast"));
                    document.getElementById("successToastHead").innerHTML = "Update Successful";
                    document.getElementById("successToastBody").innerHTML = "Profile data has been updated.";
                    successToast.show();
                });';
            }
        ?>
    </script>

    <script>
        <?php
            if(isset($update) && $update === 0){
                echo 'document.addEventListener("DOMContentLoaded", function(){
                    var errorToast = new bootstrap.Toast(document.getElementById("userErrorToast"));
                    document.getElementById("errorToastHead").innerHTML = "Update Error";
                    document.getElementById("errorToastBody").innerHTML = "Fill up all the fields.";
                    errorToast.show();
                });';
            }
        ?>
    </script>

    <script>
        <?php
            if(isset($change) && $change === 0){
                echo 'document.addEventListener("DOMContentLoaded", function(){
                    var successToast = new bootstrap.Toast(document.getElementById("userSuccessToast"));
                    document.getElementById("successToastHead").innerHTML = "Change Successful";
                    document.getElementById("successToastBody").innerHTML = "Password has been changed.";
                    successToast.show();
                });';
            }
        ?>
    </script>

    <script>
        <?php
            if(isset($change) && $change === 1){
                echo 'document.addEventListener("DOMContentLoaded", function(){
                    var errorToast = new bootstrap.Toast(document.getElementById("userErrorToast"));
                    document.getElementById("errorToastHead").innerHTML = "Change Error";
                    document.getElementById("errorToastBody").innerHTML = "Old password does not match.";
                    errorToast.show();
                });';
            }
        ?>
    </script>

    <script>
        <?php
            if(isset($change) && $change === 2){
                echo 'document.addEventListener("DOMContentLoaded", function(){
                    var errorToast = new bootstrap.Toast(document.getElementById("userErrorToast"));
                    document.getElementById("errorToastHead").innerHTML = "Change Error";
                    document.getElementById("errorToastBody").innerHTML = "New password and confirm password does not match.";
                    errorToast.show();
                });';
            }
        ?>
    </script>

    <script>
        <?php
            if(isset($change) && $change === 3){
                echo 'document.addEventListener("DOMContentLoaded", function(){
                    var errorToast = new bootstrap.Toast(document.getElementById("userErrorToast"));
                    document.getElementById("errorToastHead").innerHTML = "Change Error";
                    document.getElementById("errorToastBody").innerHTML = "Fill up all the fields.";
                    errorToast.show();
                });';
            }
        ?>
    </script>

    <script>
        <?php
            if(isset($billing) && $billing === 1){
                echo 'document.addEventListener("DOMContentLoaded", function(){
                    var successToast = new bootstrap.Toast(document.getElementById("userSuccessToast"));
                    document.getElementById("successToastHead").innerHTML = "Change Successful";
                    document.getElementById("successToastBody").innerHTML = "Billing address has been changed.";
                    successToast.show();
                });';
            }
        ?>
    </script>

    <script>
        <?php
            if(isset($billing) && $billing === 0){
                echo 'document.addEventListener("DOMContentLoaded", function(){
                    var errorToast = new bootstrap.Toast(document.getElementById("userErrorToast"));
                    document.getElementById("errorToastHead").innerHTML = "Update Error";
                    document.getElementById("errorToastBody").innerHTML = "Fill up all the fields.";
                    errorToast.show();
                });';
            }
        ?>
    </script>

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