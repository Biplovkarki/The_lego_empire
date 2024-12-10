<?php
    session_start();
    include '../connect.php';

    $cartTotal = 0;
    $total = 0;
    $charge = 50;

    if(isset($_SESSION['userId'])){
        $userId = $_SESSION['userId'];
        $username = $_SESSION['username'];
    }

    $stmt = $conn->prepare("SELECT COUNT(itemId) AS item_count FROM cart_data WHERE userId = :userId");
    $stmt ->bindParam(':userId', $userId);
    $stmt ->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $itemCount = $result['item_count'];

    if(isset($_POST['delete']) && isset($_POST['legoIdToDelete'])){
        $legoId = $_POST['legoIdToDelete'];
    
        $stmt = $conn->prepare("DELETE FROM cart_data WHERE userId = :userId AND legoId = :legoId");
        $stmt ->bindParam(':userId', $userId);
        $stmt ->bindParam(':legoId', $legoId);
        $stmt ->execute();
    
        header('location: cart.php');
        exit();
    }

    if(isset($_POST['update-cart'])){
        if(isset($_POST['quantity']) && is_array($_POST['quantity'])){
            $quantities = $_POST['quantity'];
    
            foreach($quantities as $legoId => $newQuantity){
                $legoId = intval($legoId);
                $newQuantity = intval($newQuantity);
    
                if($newQuantity <= 0){
                    $stmt = $conn->prepare("DELETE FROM cart_data WHERE userId = :userId AND legoId = :legoId");
                    $stmt ->bindParam(':userId', $userId);
                    $stmt ->bindParam(':legoId', $legoId);
                    $stmt ->execute();
                }else{
                    $stmt = $conn->prepare("UPDATE cart_data SET quantity = :quantity WHERE userId = :userId AND legoId = :legoId");
                    $stmt ->bindParam(':userId', $userId);
                    $stmt ->bindParam(':legoId', $legoId);
                    $stmt ->bindParam(':quantity', $newQuantity);
                    $stmt ->execute();
                }
                $total = 0;
            }
            header('location: cart.php');
            exit();
        }
    }

    if(isset($_POST['cash-on-delivery'])){
        // Handle Cash on Delivery logic here, like saving the order details to the database
        // For example:
        // $stmt = $conn->prepare("INSERT INTO orders (userId, totalAmount, paymentMethod) VALUES (:userId, :totalAmount, 'COD')");
        // $stmt->bindParam(':userId', $userId);
        // $stmt->bindParam(':totalAmount', $cartTotal);
        // $stmt->execute();
        
        // Redirect to order confirmation page
        header('Location: order_confirmation.php');
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
    <!-- <link rel="stylesheet" href="../../fontawesome/css/all.min.css"> -->
    <link rel="stylesheet" href="/fontawesome/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link href="https://fonts.cdnfonts.com/css/louis-george-cafe" rel="stylesheet">
    <link rel="stylesheet" href="../../css/user.css">
</head>
<body>
    <div class="cart-container">
    <div class="container" style="box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.25);">
        <?php
            if(isset($_SESSION['username'])){
                echo '<nav class="navbar navbar-expand-lg sticky-top">
                <div class="container">
                    <a class="navbar-brand" href="userpage.php">
                        <img src="../../images/logo.png" alt="The Lego Empire" width="175">
                    </a>
        
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    
                    <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item me-1">
                            <a href="account.php" class="nav-link"><i class="fa-solid fa-user" style="color: #000000; font-size: 1.1rem;"></i></a>
                        </li>
                        <li class="nav-item">
                            <a href="cart.php" class="nav-link pe-1">
                                <i class="fa-solid fa-cart-shopping" style="color: #000000; font-size: 1.1rem;"></i>
                            </a>
                        </li>
                    </ul>
                    </div>
                </div>
                </nav>';
            }else{
                echo '<nav class="navbar navbar-expand-lg">
                <div class="container">
                    <a class="navbar-brand" href="../homepage.php">
                        <img src="../../images/logo.png" alt="The Lego Empire" width="175">
                    </a>
        
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    
                    <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item me-4">
                            <a href="cart.php" class="nav-link pe-0">
                                <i class="fa-solid fa-cart-shopping" style="color: #000000; font-size: 1.1rem;"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../login.php" class="nav-link btn px-4 login-btn" role="button">LOGIN</a>
                        </li>
                    </ul>
                    </div>
                </div>
                </nav>';
            }
        ?>

        <div class="mt-3">
            <div class="cart-content p-3">
                <?php 
                    $sql = "SELECT * FROM cart_data WHERE userId = :userId";
                    $stmt = $conn->prepare($sql);
                    $stmt ->bindParam(':userId', $userId);
                    $stmt ->execute();
                ?>
                
                <h4 class="fw-bold">Shopping Cart</h4>
                <p>You currently have <?php echo $itemCount; ?> item(s) in your cart.</p>

                <div class="row">
                    <div class="col">
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                            <table class="table">
                                <tr>
                                    <td class="fw-bold text-center">Item</td>
                                    <td class="fw-bold">Lego Name</td>
                                    <td class="fw-bold">Unit Price</td>
                                    <td class="fw-bold text-center">Quantity</td>
                                    <td class="fw-bold">Sub Total</td>
                                    <td></td>
                                </tr>

                                <?php
                                    $count = 1;

                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                        $legoId = $row['legoId'];
                                        $title = $row['title'];
                                        $price = $row['price'];
                                        $quantity = $row['quantity'];

                                        $subTotal = $price * $quantity;
                                        $total += $subTotal;
                                        $cartTotal = $total + $charge;
                
                                        echo '<tr>';
                                            echo '<td class="text-center">' . $count . '</td>';
                                            echo '<td>' . $title . '</td>';
                                            echo '<td>' . $price . '</td>';
                                            echo '<td class="text-center quantity-change px-5"><input type="number" class="form-control text-center p-0" name="quantity['.$legoId.']" value="'. $quantity .'"></td>';
                                            echo '<td>' . 'NRs ' . $subTotal . '</td>';
                                            echo '<td><i class="fa-solid fa-trash" style="color: #cfcfcf; cursor: pointer" id="showDeleteConfirmation" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal" data-lego-id="'.$legoId.'" onclick="setLegoIdToDelete(this.getAttribute(\'data-lego-id\'))"></i></td>';
                                        echo '</tr>';
                
                                        $count++;
                                    }
                                ?>
                            </table>

                            <div class="mt-5">
                                <div class="row">
                                    <?php if ($itemCount > 0): ?>
                                        <div class="col-md-3">
                                            <a href="userpage.php" class="nav-link btn cart-btn py-2 fw-bold" role="button"><i class="fa-solid fa-chevron-left fa-2xs me-1"></i>Continue Shopping</a>
                                        </div>
                                        <div class="col text-end">
                                            <button class="btn cart-btn px-5 py-2 fw-bold" name="update-cart">Update Cart</button>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-3 border-start border-2">
                        <div class="order-summary">
                            <table class="table text-start">
                                <tr>
                                    <td class="fw-bold text-center" colspan="2">Order Summary</td>
                                </tr>
                                <tr>
                                    <td>Order Subtotal</td>
                                    <td><?php echo 'NRs ' . $total; ?></td>
                                </tr>
                                <tr>
                                    <td>Delivery Cost</td>
                                    <td><?php echo 'NRs ' . $charge; ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Total</td>
                                    <td class="fw-bold"><?php echo 'NRs ' . $cartTotal; ?></td>
                                </tr>
                            </table>

                            <div class="mt-5">
                                <?php
                                    if($itemCount > 0){
                                        $sql = "SELECT * FROM profile_data WHERE userId = :userId";
                                        $stmt = $conn->prepare($sql);
                                        $stmt ->bindParam(':userId', $userId);
                                        $stmt ->execute();
                                        $profileData = $stmt->fetch(PDO::FETCH_ASSOC);
                                
                                        $sql = "SELECT * FROM lego_data WHERE legoId = :legoId";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->bindParam(':legoId', $legoId); // Assuming $legoId is the ID of the LEGO product
                                        $stmt->execute();
                                        $legoData = $stmt->fetch(PDO::FETCH_ASSOC);
                                        $title = $legoData['title'];
                                        $legoId = $legoData['legoId'];
                                        if(!empty($profileData['landmark'] && $profileData['address'] && $profileData['area'] && $profileData['city'] && $profileData['province'])){
                                            echo '
                                                <form action="payment.php" method="POST">
                                                    <input type="number" name="amount" id="amount" value="' . $cartTotal . '" hidden>
                                                    <input type="text" name="username" id="username" value="' . $username . '" hidden>
                                                    <input type="text" name="legoid" id="legoid" value="' . $legoId . '" hidden>
                                                    <input type="text" name="legotitle" id="legotitle" value="' . $title . '" hidden>
                                                    <input type="submit" class="btn cart-btn px-5 py-2 fw-bold w-100" value="Checkout with khalti">
                                                </form>';
                                            
                                            echo '
                                                <form action="' . $_SERVER['PHP_SELF'] . '" method="POST">
                                                    <button type="submit" class="btn cart-btn py-2 fw-bold w-100 mt-3" name="cash-on-delivery">Cash on Delivery</button>
                                                </form>';
                                        }else{
                                            echo '<button class="btn cart-btn py-2 fw-bold w-100" disabled>Checkout with khalti</button>';
                                            echo '<button class="btn cart-btn py-2 fw-bold w-100 mt-3" disabled>Cash on delivery</button>';
                                            echo '<p class="text-danger mt-2 fw-bold">Billing address not set. Please update your profile.</p>';
                                        }
                                    }else{
                                        echo '<h6 class="fw-bold">No items in the cart to proceed.</h6>';
                                    }
                                ?>
                            </div>
                        <div>
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

    <!-- Delete Confirmation -->

    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <input type="hidden" name="legoIdToDelete" id="legoIdToDelete" value="">
                    <div class="modal-body">
                        Are you sure you want to remove the item(s)?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary pt-1" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary pt-1" name="delete" id="delete">Remove Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        function setLegoIdToDelete(legoId) {
            document.getElementById('legoIdToDelete').value = legoId;
        }
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
