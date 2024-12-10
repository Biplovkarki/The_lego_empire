<?php
    session_start();
    include 'connect.php';

    if(isset($_SESSION['username'])){
        header('location: user/userpage.php');
    }

    $averageRatingStmt = $conn->prepare("SELECT AVG(rating) as avgRating FROM lego_rating WHERE legoId = :legoId");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Lego Empire</title>
    <link rel="apple-touch-icon" sizes="180x180" href="../favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../favicon/favicon-16x16.png">
    <link rel="manifest" href="../favicon/site.webmanifest">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link href="https://fonts.cdnfonts.com/css/louis-george-cafe" rel="stylesheet">
    <link rel="stylesheet" href="../css/homepage.css">
</head>
<body>

    <div class="container">
        <div class="background-img">
            <nav class="navbar navbar-expand-lg">
                <div class="container">
                    <a class="navbar-brand" href="homepage.php">
                        <img src="../images/logo.png" alt="The Lego Empire" width="175">
                    </a>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item me-4">
                                <a href="../php/user/cart.php" class="nav-link pe-0">
                                    <i class="fa-solid fa-cart-shopping" style="color: #000000; font-size: 1.1rem;"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="login.php" class="nav-link btn px-4 login-btn" role="button">LOGIN</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="background-container">
                <div class="backgroundImgWrapper">
                    <div class="text-overlay"></div>
                </div>
            </div>
        </div>

        <div class="container base-category mt-4 mb-3 text-center">
            <div class="image-container">
                <a href="user/category.php?category=Marvel"><img src="../images/marvel.png" class="img-fluid" alt="Marvel"></a>
                <div class="image-text fw-bold">MARVEL</div>
            </div>
            <div class="image-container">
                <a href="user/category.php?category=Halloween"><img src="../images/halloween.png" class="img-fluid" alt="Halloween"></a>
                <div class="image-text fw-bold">HALLOWEEN</div>
            </div>
            <div class="image-container">
                <a href="user/category.php?category=ALL PRODUCTS"><img src="../images/lego.png" class="img-fluid" alt="LEGO"></a>
                <div class="image-text fw-bold">ALL PRODUCTS</div>
            </div>
            <div class="image-container">
                <a href="user/category.php?category=Offers"><img src="../images/offer.png" class="img-fluid" alt="Offer"></a>
                <div class="image-text fw-bold">OFFERS</div>
            </div>
            <div class="image-container">
                <a href="user/category.php?category=DC"><img src="../images/dc.png" class="img-fluid" alt="DC"></a>
                <div class="image-text fw-bold">DC</div>
            </div>
            
        </div>

        <div class="container sale-container mt-5">
            <h3 class="fw-bold">On Sale!</h3>
            <div class="slider">
                <div class="slider-container">
                <?php
                    $sql = "SELECT * FROM lego_data ORDER BY RAND() LIMIT 8";
                    $stmt = $conn->query($sql);
                    if($stmt->rowCount() > 0){
                        while($row = $stmt->fetch()){
                            echo '<div class="card slider-card" style="width: 18.75rem; margin-left: 0.60vw; margin-right: 0.60vw;">
                                <a href="user/legodetails.php?legoId=' .$row['legoId']. '" class="nav-link">
                                    <img src="../lego-images/' .$row['mainimage']. '" class="card-img-top my-3" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title fw-bold fs-6">' .$row['title']. '</h5>
                                </a>';
                                        $averageRatingStmt->bindParam(':legoId', $row['legoId']);
                                        $averageRatingStmt->execute();
                                        $averageRating = $averageRatingStmt->fetch(PDO::FETCH_ASSOC)['avgRating'];

                                        echo '<div class="averageRating" id="average-stars" data-average-rating="' . $averageRating . '">';
                                            $averageRatingRounded = round($averageRating);
                                            for($i = 1; $i <= 5; $i++){
                                                if($i <= $averageRatingRounded){
                                                    echo '<i class="fa-solid fa-star" style="color: #FFB234;"></i>';
                                                }else{    
                                                    echo '<i class="fa-regular fa-star" style="color: #FFB234;"></i>';
                                                }
                                            }
                                        echo '</div>
                                        <p class="card-text mt-1"><span class="text-decoration-line-through">NRs 1000</span> <span class="fw-bold">NRs ' .$row['price']. '</span></p>
                                        <a href="user/legodetails.php?legoId=' .$row['legoId']. '" class="nav-link btn cart-btn mt-1 py-2 fw-bold" role="button">Add to Cart</a>
                                    </div>
                            </div>';
                        }
                    }else{
                        echo "<div class='container'>No Products Found.</div>";
                    }
                ?>
                </div>
            </div>
        </div>

        <div class="container features-container text-center rounded mt-5 pb-3 px-0">
            <div class="image-container">
                <img src="../images/return.png" class="img-fluid" alt="Marvel">
                <div class="image-text fw-bold">Easy Return</div>
                <div>Return any item before 7 days.</div>
            </div>
            <div class="image-container">
                <img src="../images/shipping.png" class="img-fluid" alt="Halloween">
                <div class="image-text fw-bold">Free Shipping</div>
                <div>Enjoy free shipping inside Nepal.</div>
            </div>
            <div class="image-container mt-4">
                <img src="../images/guarantee.png" class="img-fluid" alt="LEGO">
                <div class="image-text fw-bold">Satisfaction Guarantee</div>
                <div>We guarantee you with our quality satisfaction.</div>
            </div>
            <div class="image-container">
                <img src="../images/fast-shipping.png" class="img-fluid" alt="Halloween">
                <div class="image-text fw-bold">Fast Shipping</div>
                <div>Items are shipped within 24 hours.</div>
            </div>
            <div class="image-container">
                <img src="../images/money-return.png" class="img-fluid" alt="LEGO">
                <div class="image-text fw-bold">Money Back Guarantee</div>
                <div>We offer money back guarantee.</div>
            </div>
        </div>

        <div class="container news-container mt-5">
            <h3 class="fw-bold">Read All About It</h3>
            <div class="row">
                <?php
                    $sql = "SELECT * FROM article_data ORDER BY RAND() LIMIT 3";
                    $stmt = $conn->query($sql);
                    if($stmt->rowCount() > 0){
                        while($row = $stmt->fetch()){
                            echo '<div class="col">
                                <div class="card" style="width: 25.5rem; border: none;">
                                <a href="user/article.php?articleId=' .$row['articleId'].'">
                                    <img src="../news-images/' .$row['mainimage']. '" class="card-img-top rounded" style="" alt="...">
                                    <div class="card-body px-0">
                                        <h5 class="card-title fw-bold fs-5 mb-3">' .$row['title']. '</h5>
                                        <p style="text-align: justify;">' .$row['subtext']. '</p>
                                    </div>
                                </a>
                                </div>
                            </div>';
                        }
                    }else{
                        echo "<div class='container'>No Articles Found.</div>";
                    }
                ?>
            </div>
        </div>

        <div class="container mt-3 rounded" style="height: 6vh; background-color: black; color: white;">
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

    <script>
        if( window.history.replaceState ){
            window.history.replaceState( null, null, window.location.href );
        }
    </script>
    
    <script src="../js/script.js"></script>
    <script src="https://kit.fontawesome.com/296ff2fa8f.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

</body>
</html>