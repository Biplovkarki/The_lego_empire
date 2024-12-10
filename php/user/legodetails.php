<?php
    session_start();
    include '../connect.php';

    if(isset($_GET['legoId'])){
        $legoId = $_GET['legoId'];
    }

    $stmt = $conn->prepare("SELECT * FROM lego_data WHERE legoId = :legoId");
    $stmt ->bindParam(':legoId', $legoId, PDO::PARAM_INT);
    $stmt ->execute();

    if($stmt->rowCount() > 0){
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if(isset($_POST['order-submit'])){
            if(!isset($_SESSION['userId'])){
                $success = 2;
            }else{
                $userId = $_SESSION['userId'];
                $legoId = $_POST['legoId'];
                $title = $_POST['title'];
                $price = $_POST['price'];
                $quantity = $_POST['quantity'];

                $quantityInStock = $row['stock'];
                
                if($quantity <= $quantityInStock){
                    $stmt = $conn->prepare("SELECT legoId FROM cart_data WHERE userId = :userId AND legoId = :legoId");
                    $stmt ->bindParam(':userId', $userId, PDO::PARAM_INT);
                    $stmt ->bindParam(':legoId', $legoId, PDO::PARAM_INT);
                    $stmt ->execute();

                    if($stmt->rowCount() > 0){
                        $success = 0;
                    }else{
                        try{
                            $conn->beginTransaction();
                            $updateStockStmt = $conn->prepare("UPDATE lego_data SET stock = stock - :quantity WHERE legoId = :legoId");
                            $updateStockStmt ->bindParam(':quantity', $quantity, PDO::PARAM_INT);
                            $updateStockStmt ->bindParam(':legoId', $legoId, PDO::PARAM_INT);
                            $updateStockStmt ->execute();

                            if($updateStockStmt->rowCount() > 0){
                                $stmt = $conn->prepare("INSERT INTO cart_data (userId, legoId, title, price, quantity) VALUES (:userId, :legoId, :title, :price, :quantity)");
                                $stmt ->bindParam(':userId', $userId, PDO::PARAM_INT);
                                $stmt ->bindParam(':legoId', $legoId, PDO::PARAM_INT);
                                $stmt ->bindParam(':title', $title, PDO::PARAM_STR);
                                $stmt ->bindParam(':price', $price, PDO::PARAM_STR);
                                $stmt ->bindParam(':quantity', $quantity, PDO::PARAM_INT);

                                if($stmt->execute()){
                                    $conn->commit();
                                    $success = 1;
                                }else{
                                    $conn->rollBack();
                                }
                            }else{
                                $conn->rollBack();
                            }
                        }catch(PDOException $e){
                            $conn->rollBack();
                            echo "Error: " . $e->getMessage();
                        }
                    }
                }else{
                    $success = 3;
                }
            }
        }

        if(isset($_POST['rating-submit'])){
            if(!isset($_SESSION['userId'])){
                $error = 2;
            }else{
                $userId = $_SESSION['userId'];
                $legoId = $_POST['legoId'];
                
                if(empty($_POST['rating'])){
                    $error = 3;
                }else{
                    $rating = $_POST['rating'];
                    $checkStmt = $conn->prepare("SELECT * FROM lego_rating WHERE legoId = :legoId AND userId = :userId");
                    $checkStmt ->bindParam(':legoId', $legoId, PDO::PARAM_INT);
                    $checkStmt ->bindParam(':userId', $userId, PDO::PARAM_INT);
                    $checkStmt ->execute();
                
                    if($checkStmt->rowCount() > 0){
                        $error = 0;
                    }else{
                        $insertStmt = $conn->prepare("INSERT INTO lego_rating (legoId, userId, rating) VALUES (:legoId, :userId, :rating)");
                        $insertStmt ->bindParam(':legoId', $legoId, PDO::PARAM_INT);
                        $insertStmt ->bindParam(':userId', $userId, PDO::PARAM_INT);
                        $insertStmt ->bindParam(':rating', $rating, PDO::PARAM_INT);

                        if($insertStmt->execute()){
                            $error = 1;
                        }
                    }
                }
            }
        }

        $averageRatingSql = "SELECT AVG(rating) as avgRating FROM lego_rating WHERE legoId = :legoId";
        $averageRatingStmt = $conn->prepare($averageRatingSql);
        $averageRatingStmt ->bindParam(':legoId', $legoId, PDO::PARAM_INT);
        $averageRatingStmt ->execute();

        $averageRating = $averageRatingStmt->fetch(PDO::FETCH_ASSOC)['avgRating'];
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../../css/user.css">

    <style>
        .stars{
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
        }

        .averageRating{
            display: flex;
            font-size: 0.87rem;
            gap: 3.4px;
        }

        .star.selected{
            color: #ffbb00;
        }

        .star:hover{
            color: #ffbb00;
        }
    </style>
</head>
<body>
    <div class="container">
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
                        <a href="cart.php" class="nav-link pe-0">
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

    <?php
        $sql = "SELECT * FROM lego_data WHERE legoId = :legoId";
        $stmt = $conn->prepare($sql);
        $stmt ->bindParam(':legoId', $legoId, PDO::PARAM_INT);
        $stmt ->execute();

        if($stmt->rowCount() > 0){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>

    <nav class="container" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="userpage.php" class="nav-link">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo $row['title'] ?></li>
        </ol>
    </nav>

    <div class="vl"></div>

    <div class="container mt-3">
        <div class="row">
            <div class="col-8">
            <div id="carouselExample" class="carousel slide carousel-dark">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="../../lego-images/<?php echo $row['mainimage'] ?>" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="../../lego-images/<?php echo $row['secondaryimage'] ?>" class="d-block w-100" alt="...">
                    </div>
                </div>
    
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>

                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            </div>

            <div class="col-4">
                <form action="" method="POST">
                    <div>
                        <input type="hidden" name="legoId" id="legoId" value="<?php echo $row['legoId'] ?>">
                        <input type="hidden" name="title" id="title" value="<?php echo $row['title'] ?>">
                        <h5 class="fw-bold pt-2" name="title"><?php echo $row['title'] ?></h5>

                        <div class="averageRating" id="average-stars" data-average-rating="<?php echo $averageRating; ?>">
                            <?php
                                $averageRatingRounded = round($averageRating);
                                for ($i = 1; $i <= 5; $i++) {
                                    if($i <= $averageRatingRounded){
                                        echo '<i class="fa-solid fa-star" style="color: #FFB234;"></i>';
                                    } else {    
                                        echo '<i class="fa-regular fa-star" style="color: #FFB234;"></i>';
                                    }
                                }
                            ?>
                        </div>
                        
                        <input type="hidden" name="price" id="price" value="<?php echo $row['price'] ?>">
                        <h5 class="fw-bold mt-3" name="price">NRs <?php echo $row['price'] ?></h5>
                        
                        <?php 
                            if($row['stock'] > 0){
                                echo "<p class='fw-bold text-success'>Available Now</p>";
                            }else{
                                echo "<p class='fw-bold text-danger'>Out of Stock</p>";
                            }
                        ?>
                    </div>

                    <div class="quantity-btn rounded">
                        <div class="value-button rounded-start" id="decrease" onclick="decreaseValue()" value="Decrease Value"><i class="fa fa-minus"></i></div>
                        <input class="number-field fw-bold" type="number" name="quantity" id="number" value="1" readonly>
                        <div class="value-button rounded-end" id="increase" onclick="increaseValue()" value="Increase Value"><i class="fa fa-plus"></i></div>
                    </div>

                    <?php
                        if($row['stock'] > 0){
                            echo '<button class="nav-link btn cart-btn mt-1 py-2 fw-bold w-100" name="order-submit">Add to Cart</button>';
                        }else{
                            echo '<button class="nav-link btn cart-btn mt-1 py-2 fw-bold w-100" name="order-submit" disabled>Add to Cart</button>';
                        }    
                    ?>
                </form>

                <div class="border rounded mt-3 py-3">
                    <img src="../../lego-images/<?php echo $row['mainimage'] ?>" class="w-25" alt="">
                    <small class="fw-bold">Gift with the purchase of NRs 700 or more*</small>
                </div>

                <div class="warning mt-2">
                    <p class="fw-bold mb-0">WARNING:<br>CHOKING HAZARD.</p>
                    <p>Toy contains small parts and a small ball. Not for children under 3 years.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="vl mt-3"></div>

    <div class="container basic-container mt-4 mb-3 text-center">
        <div>
            <h1><?php echo $row['age'] ?>+</h1>
            <div class="fw-bold">Ages</div>
        </div>
        <div>
            <h1><?php echo $row['pieces'] ?></h1>
            <div class="fw-bold">Pieces</div>
        </div>
        <div>
            <h1><?php echo $row['points'] ?></h1>
            <div class="fw-bold">Insiders Points</div>
        </div>
        <div>
            <h1>#<?php echo $row['itemNumber'] ?></h1>
            <div class="fw-bold">Item</div>
        </div>
    </div>

    <div class="container about-container mt-5">
        <div class="feature-container rounded-top border-bottom-0">
            <a class="nav-link p-0 w-100" data-bs-toggle="collapse" href="#collapseFeature" aria-expanded="false" aria-controls="collapseFeature">
            <div class="row">
                <div class="col">
                    <h4>Features</h4>
                </div>
                <div class="col-1 text-center d-flex justify-content-end pt-2">
                    <i class="fa fa-minus"></i>
                </div>
            </div>
            </a>

            <div class="collapse show" id="collapseFeature">
            <div class="card card-body border-0 p-0 pt-3">
                <div class="row text-center">
                    <div class="col">
                        <div class="card border-0" style="width: 24.5rem;">
                            <img src="../../lego-images/<?php echo $row['imageone'] ?>" alt="...">
                            <div class="card-body">
                                <h6 class="card-title fw-bold"><?php echo $row['titleone'] ?></h6>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card border-0" style="width: 24.5rem;">
                            <img src="../../lego-images/<?php echo $row['imagetwo'] ?>" alt="...">
                            <div class="card-body">
                                <h6 class="card-title fw-bold"><?php echo $row['titletwo'] ?></h6>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card border-0" style="width: 24.5rem;">
                            <img src="../../lego-images/<?php echo $row['imagethree'] ?>" alt="...">
                            <div class="card-body">
                                <h6 class="card-title fw-bold"><?php echo $row['titlethree'] ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
        
        <div class="specification-container border-bottom-0">
            <a class="nav-link p-0 w-100" data-bs-toggle="collapse" href="#collapseSpecification" aria-expanded="false" aria-controls="collapseSpecification">
            <div class="row">
                <div class="col">
                    <h4>Specifications</h4>
                </div>
                <div class="col-1 text-center d-flex justify-content-end pt-2">
                    <i class="fa fa-plus" id="icon-toggle"></i>
                </div>
            </div>
            </a>

            <div class="collapse" id="collapseSpecification">
            <div class="card card-body border-0 p-0 pt-3">
                <div style="text-align: justify;">
                    <?php echo $row['specifications'] ?>

                    <div>
                        <?php
                            $specificationspoints = explode("\n", $row['specificationspoint']);
                            echo "<ul class='mt-3'>";
                            foreach($specificationspoints as $point){
                                echo "<li class='mt-2'>$point</li>";
                            }
                            echo "</ul>";
                        ?>
                    </div>
                </div>
            </div>
            </div>
        </div>

        <div class="rating-container rounded-bottom">
            <h4><label for="rating">Product Review & Ratings</label></h4>

            <form action="" method="POST">
                <div class="row mt-3">
                    <div class="col">
                        <div class="input-wrapper">
                            <textarea type="text" class="form-control mb-3" name="review" id="review" rows="3" placeholder="Review about the product . . ." disabled></textarea>
                        </div>
                    </div>

                    <div class="col-md-4 pt-1">
                        <div class="stars" id="stars">
                            <i class="star fa fa-star" data-rating="1"></i>
                            <i class="star fa fa-star" data-rating="2"></i>
                            <i class="star fa fa-star" data-rating="3"></i>
                            <i class="star fa fa-star" data-rating="4"></i>
                            <i class="star fa fa-star" data-rating="5"></i>
                            
                            <input type="hidden" name="rating" id="rating">
                            <input type="hidden" name="legoId" id="legoId" value="<?php echo $row['legoId'] ?>">
                        </div>

                        <button class="nav-link btn rating-btn mt-4 py-2 fw-bold w-100" type="submit" name="rating-submit" id="rating-submit">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <?php } ?>

    <!-- Footer -->

    <div class="container mt-5 rounded" style="height: 6vh; background-color: black; color: white;">
        <div class="w-100 h-100 d-inline-block ps-3 pt-3">
            <div class="row" style="font-size: 0.77rem;">
                <div class="col-7">
                    <p>© TheLegoEmpire, All rights reserved 2023.</p>
                </div>
                <div class="col text-end">
                    <a href="https://www.facebook.com/" target="_blank" style="margin-right: 1vw;"><i class="fa-brands fa-facebook-f" style="color: #ffffff;"></i></a>
                    <a href="https://www.instagram.com/" target="_blank" style="margin-right: 1vw;"><i class="fa-brands fa-instagram" style="color: #ffffff;"></i></a>
                    <a href="https://www.twitter.com/" target="_blank" style="margin-right: 1vw;"><i class="fa-brands fa-x-twitter" style="color: #ffffff;"></i></a>
                    <a href="https://www.youtube.com/" target="_blank" style="margin-right: 1vw;"><i class="fa-brands fa-youtube" style="color: #ffffff;"></i></a>
                </div>                
            </div>
        </div>
    </div>

    </div>

    <div class="text-end fixed-top-container" id="top-container">
        <a href="" id="scroll-to-top">
            <i class="fa-solid fa-angle-up rounded" style="background-color: black; color: #ffffff; padding: 13px; font-size: larger;"></i>
        </a>
    </div>

    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="userSuccessToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto" id="successToastHead"></strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="successToastBody"></div>
        </div>
    </div>

    <div class="toast-container position-fixed bottom-0 end-0 p-3">
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
            if(isset($success) && $success === 0){
                echo 'document.addEventListener("DOMContentLoaded", function(){
                    var successToast = new bootstrap.Toast(document.getElementById("userSuccessToast"));
                    document.getElementById("successToastHead").innerHTML = "Product Already Exists";
                    document.getElementById("successToastBody").innerHTML = "The product is already in the cart.";
                    successToast.show();
                });';
            }

            if(isset($success) && $success === 1){
                echo 'document.addEventListener("DOMContentLoaded", function(){
                    var successToast = new bootstrap.Toast(document.getElementById("userSuccessToast"));
                    document.getElementById("successToastHead").innerHTML = "Product Added";
                    document.getElementById("successToastBody").innerHTML = "The product has been added to the cart.";
                    successToast.show();
                });';
            }

            if(isset($success) && $success === 2){
                echo 'document.addEventListener("DOMContentLoaded", function(){
                    var successToast = new bootstrap.Toast(document.getElementById("userSuccessToast"));
                    document.getElementById("successToastHead").innerHTML = "Login First";
                    document.getElementById("successToastBody").innerHTML = "You should login first to add a product.";
                    successToast.show();
                });';
            }

            if(isset($success) && $success === 3){
                echo 'document.addEventListener("DOMContentLoaded", function(){
                    var successToast = new bootstrap.Toast(document.getElementById("userSuccessToast"));
                    document.getElementById("successToastHead").innerHTML = "Inventory Error";
                    document.getElementById("successToastBody").innerHTML = "The required quantity is not available.";
                    successToast.show();
                });';
            }
        ?>
    </script>

    <script>
        <?php
            if(isset($error) && $error === 0){
                echo 'document.addEventListener("DOMContentLoaded", function(){
                    var errorToast = new bootstrap.Toast(document.getElementById("userErrorToast"));
                    document.getElementById("errorToastHead").innerHTML = "Rating Error";
                    document.getElementById("errorToastBody").innerHTML = "You have already rated this product.";
                    errorToast.show();
                });';
            }

            if(isset($error) && $error === 1){
                echo 'document.addEventListener("DOMContentLoaded", function(){
                    var errorToast = new bootstrap.Toast(document.getElementById("userErrorToast"));
                    document.getElementById("errorToastHead").innerHTML = "Rating Successful";
                    document.getElementById("errorToastBody").innerHTML = "The product has been rated.";
                    errorToast.show();
                });';
            }

            if(isset($error) && $error === 2){
                echo 'document.addEventListener("DOMContentLoaded", function(){
                    var errorToast = new bootstrap.Toast(document.getElementById("userErrorToast"));
                    document.getElementById("errorToastHead").innerHTML = "Rating Error";
                    document.getElementById("errorToastBody").innerHTML = "You should login first to rate a product.";
                    errorToast.show();
                });';
            }

            if(isset($error) && $error === 3){
                echo 'document.addEventListener("DOMContentLoaded", function(){
                    var errorToast = new bootstrap.Toast(document.getElementById("userErrorToast"));
                    document.getElementById("errorToastHead").innerHTML = "Rating Error";
                    document.getElementById("errorToastBody").innerHTML = "You must provide a rating.";
                    errorToast.show();
                });';
            }
        ?>
    </script>

    <script>
        function increaseValue(){
            var value = parseInt(document.getElementById('number').value, 10);
            value = isNaN(value) ? 0 : value;

            if(value < 15){
                value++;
            }
            document.getElementById('number').value = value;
        }

        function decreaseValue(){
            var value = parseInt(document.getElementById('number').value, 10);
            value = isNaN(value) ? 0 : value;

            if(value > 1){
                value--;
            }
            document.getElementById('number').value = value;
        }
    </script>
    
    <script>
        $(document).ready(function (){
            $(".nav-link").on("click", function (){
                var icon = $(this).find("i");

                if(icon.hasClass("fa-plus")){
                    icon.removeClass("fa-plus").addClass("fa-minus");
                    icon.css("transition", "transform 1s");
                }else{
                    icon.removeClass("fa-minus").addClass("fa-plus");
                    icon.css("transition", "transform 1s");
                }
            });
        });
    </script>

    <script>
        if( window.history.replaceState ){
            window.history.replaceState( null, null, window.location.href );
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function(){
            const stars = document.querySelectorAll(".star");
            const ratingInput = document.getElementById("rating");

            stars.forEach(star => {
                star.addEventListener("mouseenter", function(){
                    const hoveredRating = this.getAttribute("data-rating");

                    stars.forEach(s => {
                        if(s.getAttribute("data-rating") <= hoveredRating){
                            s.classList.add("hovered");
                        }else{
                            s.classList.remove("hovered");
                        }
                    });
                });

                star.addEventListener("mouseleave", function(){
                    stars.forEach(s => s.classList.remove("hovered"));
                });

                star.addEventListener("click", function(){
                    const selectedRating = this.getAttribute("data-rating");
                    ratingInput.value = selectedRating;

                    stars.forEach(s => s.classList.remove("hovered", "selected"));
                    stars.forEach(s => {
                        if(s.getAttribute("data-rating") <= selectedRating){
                            s.classList.add("selected");
                        }
                    });
                });
            });
        });
    </script>
    
    <script src="../../js/userscript.js"></script>
    <script src="https://kit.fontawesome.com/296ff2fa8f.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

</body>
</html>