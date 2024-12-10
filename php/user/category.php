<?php
    session_start();
    include '../connect.php';

    $activeFilter = '';
    
    if(isset($_GET['category'])){
        $category = $_GET['category'];
    
        $stmt = $conn->prepare("SELECT * FROM lego_data WHERE category = :category");
        $stmt ->bindParam(':category', $category);
        $stmt ->execute();
        $legos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    if(isset($_GET['category']) && $_GET['category'] == "ALL PRODUCTS"){
        $stmt = $conn->prepare("SELECT * FROM lego_data");
        $stmt ->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    if(isset($_GET['filter'])){
        $filter = $_GET['filter'];
        $activeFilter = getFilterName($filter);

        switch($filter){
            case 'low_high':
                $stmt = $conn->prepare("SELECT * FROM lego_data ORDER BY price ASC");
                break;

            case 'high_low':
                $stmt = $conn->prepare("SELECT * FROM lego_data ORDER BY price DESC");
                break;

            case 'alphabetical':
                $stmt = $conn->prepare("SELECT * FROM lego_data ORDER BY title ASC");
                break;
        }

        $stmt->execute();
        $filteredProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getFilterName($filter){
        switch($filter){
            case 'low_high':
                return 'Price: Low to High';
                break;

            case 'high_low':
                return 'Price: High to Low';
                break;

            case 'alphabetical':
                return 'A - Z';
                break;
        }
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
    <link rel="apple-touch-icon" sizes="180x180" href="../../favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../../favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../../favicon/favicon-16x16.png">
    <link rel="manifest" href="../../favicon/site.webmanifest">
    <!-- <link rel="stylesheet" href="../../fontawesome/css/all.min.css"> -->
    <link rel="stylesheet" href="/fontawesome/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link href="https://fonts.cdnfonts.com/css/louis-george-cafe" rel="stylesheet">
    <link rel="stylesheet" href="../../css/user.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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

        <!-- Category Filter -->

        <?php if(isset($category) && !empty($legos)): ?>
            <div class="container sale-container mt-5 mb-5">
                <h4 class="fw-bold">Category: <?php echo $category ?></h4>
                <div class="container">
                    <div class="row row-gap-4 mt-3">
                        <?php foreach($legos as $lego):
                            $legoId = $lego['legoId'];
                            $averageRatingStmt->bindParam(':legoId', $legoId);
                            $averageRatingStmt->execute();
                            $averageRating = $averageRatingStmt->fetch(PDO::FETCH_ASSOC)['avgRating'];
                        ?>
                            <div class="col">
                                <div class="card" style="width: 18.37rem;">
                                <a href="legodetails.php?legoId=<?php echo $lego['legoId'] ?>" class="nav-link">
                                    <img src="../../lego-images/<?php echo $lego['mainimage'] ?>" class="card-img-top my-3" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title fw-bold fs-6"><?php echo $lego['title'] ?></h5>
                                </a>
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
                                        <p class="card-text mt-1"><span class="fw-bold">NRs <?php echo $lego['price'] ?></span></p>
                                        <a href="legodetails.php?legoId=<?php echo $lego['legoId'] ?>" class="nav-link btn cart-btn mt-1 py-2 fw-bold" role="button">Add to Cart</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

        <!-- All Products -->

        <?php elseif(isset($_GET['category']) && $_GET['category'] == "ALL PRODUCTS" && isset($products)): ?>
            <div class="container sale-container mt-5 mb-5">
                <div class="row">
                    <div class="col">
                        <h4 class="fw-bold">All Products</h4>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select" name="sort" id="sort" onchange="this.form.submit()">
                            <option value="">Filter</option>
                            <option value="low_high">Price: Low to High</option>
                            <option value="high_low">Price: High to Low</option>
                            <option value="alphabetical">A - Z</option>
                        </select>
                    </div>
                </div>

                <div class="container">
                    <div class="row row-gap-4 mt-2">
                        <?php foreach($products as $product):
                            $legoId = $product['legoId'];
                            $averageRatingStmt->bindParam(':legoId', $legoId);
                            $averageRatingStmt->execute();
                            $averageRating = $averageRatingStmt->fetch(PDO::FETCH_ASSOC)['avgRating'];
                        ?>
                            <div class="col">
                                <div class="card" style="width: 18.37rem;">
                                <a href="legodetails.php?legoId=<?php echo $product['legoId'] ?>" class="nav-link">
                                    <img src="../../lego-images/<?php echo $product['mainimage'] ?>" class="card-img-top my-3" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title fw-bold fs-6"><?php echo $product['title'] ?></h5>
                                </a>
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
                                        <p class="card-text mt-1"><span class="fw-bold">NRs <?php echo $product['price'] ?></span></p>
                                        <a href="legodetails.php?legoId=<?php echo $product['legoId'] ?>" class="nav-link btn cart-btn mt-1 py-2 fw-bold" role="button">Add to Cart</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

        <!-- Filtered Products -->
        
        <?php elseif(isset($filteredProducts)): ?>
            <div class="container sale-container mt-5 mb-5">
                <div class="row">
                    <div class="col">
                        <h4 class="fw-bold">All Products</h4>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select" name="sort" id="sort" onchange="this.form.submit()">
                            <option value="low_high" <?php echo $filter === 'low_high' ? 'selected' : ''; ?>>Price: Low to High</option>
                            <option value="high_low" <?php echo $filter === 'high_low' ? 'selected' : ''; ?>>Price: High to Low</option>
                            <option value="alphabetical" <?php echo $filter === 'alphabetical' ? 'selected' : ''; ?>>A - Z</option>
                        </select>
                    </div>
                </div>

                <div class="container">
                    <div class="row row-gap-4 mt-2">
                        <?php foreach($filteredProducts as $product):
                            $legoId = $product['legoId'];
                            $averageRatingStmt->bindParam(':legoId', $legoId);
                            $averageRatingStmt->execute();
                            $averageRating = $averageRatingStmt->fetch(PDO::FETCH_ASSOC)['avgRating'];
                        ?>
                            <div class="col">
                                <div class="card" style="width: 18.37rem;">
                                <a href="legodetails.php?legoId=<?php echo $product['legoId'] ?>" class="nav-link">
                                    <img src="../../lego-images/<?php echo $product['mainimage'] ?>" class="card-img-top my-3" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title fw-bold fs-6"><?php echo $product['title'] ?></h5>
                                </a>
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
                                        <p class="card-text mt-1"><span class="fw-bold">$<?php echo $product['price'] ?></span></p>
                                        <a href="legodetails.php?legoId=<?php echo $product['legoId'] ?>" class="nav-link btn cart-btn mt-1 py-2 fw-bold" role="button">Add to Cart</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

        <?php else: ?>
            <div class="container mt-5 mb-5">
                <h5 class="fw-bold">No products found in this category.</h5>
            </div>
        <?php endif; ?>
    </div>

    <div class="text-end fixed-top-container" id="top-container">
        <a href="" id="scroll-to-top">
            <i class="fa-solid fa-angle-up rounded" style="background-color: black; color: #ffffff; padding: 13px; font-size: larger;"></i>
        </a>
    </div>

    <script>
        $(document).ready(function(){
            $("#sort").change(function(){
                var filter = $(this).val();
                window.location.href = 'category.php?filter=' + filter;
            });
        });
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