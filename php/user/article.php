<?php
    session_start();
    include '../connect.php';

    if(isset($_GET['articleId'])){
        $articleId = $_GET['articleId'];
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
    <!-- <link rel="stylesheet" href="../../fontawesome/css/all.min.css"> -->
    <link rel="stylesheet" href="/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../../css/user.css">
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
                            <a href="../user/cart.php" class="nav-link pe-0">
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
        $sql = "SELECT * FROM article_data WHERE articleId = :articleId";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':articleId', $articleId, PDO::PARAM_INT);
        $stmt->execute();

        if($stmt->rowCount() > 0){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>

    <nav class="container" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="homepage.php" class="nav-link">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo $row['title'] ?></li>
        </ol>
    </nav>

    <div class="vl"></div>

    <div class="container mt-3">
        <img src="../../news-images/<?php echo $row['displayimage'] ?>" class="w-100" alt="">
        <div class="container text-center mt-4">
            <h2><?php echo $row['title'] ?></h2>
            <h6 class="lh-base" style="font-size: 1.11rem; text-align: justify;"><?php echo $row['description'] ?></h6>
        </div>
        
        <div class="container mt-4">
            <div class="row mb-4">
                <div class="col-4">
                    <img src="../../news-images/<?php echo $row['imageone'] ?>" class="w-100" alt="">
                </div>
                <div class="col-4">
                    <img src="../../news-images/<?php echo $row['imagetwo'] ?>" class="w-100" alt="">
                </div>
                <div class="col-4">
                    <img src="../../news-images/<?php echo $row['imagethree'] ?>" class="w-100" alt="">
                </div>
            </div>

            <h6 class="lh-base" style="font-size: 1.11rem; text-align: justify;"><?php echo $row['remdescription'] ?></h6>
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
    
    <script src="../../js/userscript.js"></script>
    <script src="https://kit.fontawesome.com/296ff2fa8f.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

</body>
</html>