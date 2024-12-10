<?php
session_start();
include '../connect.php';

if (!isset($_SESSION['username'])) {
    header('location: ../index.php');
    exit(); // Stop further execution
}

$status = isset($_GET['status']) ? $_GET['status'] : '';
$amount = isset($_GET['amount']) ? $_GET['amount'] : '';
$userId = isset($_SESSION['userId']) ? $_SESSION['userId'] : '';
$transactionId = isset($_GET['transaction_id']) ? $_GET['transaction_id'] : '';

$total = $amount / 100;

if (empty($transactionId)) {
    // Payment failed
    echo "<div style='display: flex; flex-direction: column; justify-content: center; align-items: center; height: 100vh;;'>";
    echo "<div style='background-color: #FFFFFF; padding: 20px; border-radius: 10px; text-align: center;  background-color: #CECECE'>";
    echo "<img src='../../images/failed.png' alt='Failed' style='width: 100px;'>";
    echo "<h3 style='color: red;'>Payment Failed</h3>";
    echo "<p style='color: red;'>The payment process was unsuccessful. Please try again or contact customer support.</p>";
    echo '<a href="userpage.php">';
    echo "<button style='background-color: #f44336; color: white; border: none; border-radius: 5px; padding: 10px 20px; cursor: pointer; transition: background-color 0.3s ease;'>Back to userpage</button>";
    echo '</a>';
    echo "</div>";
    echo '</div>';
    exit(); // Stop further execution
}



$sql = "SELECT * FROM cart_data WHERE userId = :userId";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':userId', $userId);
$stmt->execute();

$cartItems = array();
$status = "Paid";

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $cartItems[] = array(
        'legoId' => $row['legoId'],
        'title' => $row['title'],
        'price' => $row['price'],
        'quantity' => $row['quantity'],
    );
}

foreach ($cartItems as $item) {
    $legoId = $item['legoId'];
    $title = $item['title'];
    $price = $item['price'];
    $quantity = $item['quantity'];

    $sql = "INSERT INTO order_data (userId, legoId, title, price, quantity, transactionId, status) VALUES (:userId, :legoId, :title, :price, :quantity, :transactionId, :status)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':userId', $userId);
    $stmt->bindParam(':legoId', $legoId);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':quantity', $quantity);
    $stmt->bindParam(':transactionId', $transactionId);
    $stmt->bindParam(':status', $status);
    $stmt->execute();
}

$stmt = $conn->prepare("DELETE FROM cart_data WHERE userId = :userId");
$stmt->bindParam(':userId', $userId);
$stmt->execute();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Lego Empire - Payment Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link href="https://fonts.cdnfonts.com/css/louis-george-cafe" rel="stylesheet">
    
    <link rel="stylesheet" href="../../css/user.css">
    <link rel="stylesheet" href="../../fontawesome/css/all.min.css">

    <style>
        body {
            background-color: #f6f4f9;
            font-family: 'Arial', sans-serif;
        }

        .payment-container {
            margin-top: 50px;
            padding: 20px;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .payment-container img {
            width: 100px;
        }

        .payment-container h3 {
            margin-top: 30px;
            font-size: 24px;
        }

        .payment-container h6 {
            font-size: 18px;
        }

        .payment-container p {
            font-size: 16px;
            color: #666;
        }

        .payment-container .btn {
            margin-top: 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .payment-container .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="container payment-container">
    <div class="row text-center">
        <div class="col-md-12 mb-3">
            <?php if (!empty($transactionId)) : ?>
                <img src="../../images/success.png" class="mt-5" alt="">
                <h3 class="fw-bold mt-5">Payment Success</h3>
                <h6 class="mt-3">Thank you for purchasing via Khalti Payment Gateway! Your payment has been confirmed successfully.</h6>
                <div class="row text-center">
                    <div class="col-md-12">
                        <h6 class="fw-bold">Paid Amount: NRs. <?php echo $total ?></h6>
                        <h6 class="fw-bold">Transaction ID: <?php echo $transactionId ?></h6>
                    </div>
                </div>
            <!-- <?php else : ?>
                <img src="../../images/failed.png" class="mt-5" alt="">
                <h3 class="fw-bold mt-5">Payment Failed</h3>
                <h6 class="mt-3">The payment process was unsuccessful. Please try again or contact customer support.</h6>
            <?php endif; ?> -->
        </div>
    </div>

    <div class="row text-center">
        <div class="col-md-12">
            <a href="userpage.php">
                <button class="btn cart-btn py-2 fw-bold w-50">Back to userpage</button>
            </a>
        </div>
    </div>
</div>


</body>
</html>
