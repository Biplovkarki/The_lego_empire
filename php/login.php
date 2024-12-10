<?php
    session_start();
    include 'connect.php';

    if(isset($_SESSION['username'])){
        header('location: user/userpage.php');
    }

    if(isset($_POST['login-submit'])){
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM user_data WHERE email=:email");
        $stmt ->bindParam(':email', $email);
        $stmt ->execute();
        $userauth = $stmt->fetch();
    
        if($userauth){
            if(password_verify($password, $userauth['password'])){
                session_start();
                $_SESSION['username'] = $userauth['email'];
                $_SESSION['userId'] = $userauth['userId'];
                header('location: user/userpage.php');
                exit();
            }
        }
    }

    if(isset($_POST['register-submit'])){
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "SELECT * FROM user_data WHERE phone = ? OR email = ?";
        $stmt = $conn->prepare($sql);
        $stmt ->execute([$phone, $email]);
        $result = $stmt->fetch();

        if($result){
            
        }else{
            $sql = "INSERT INTO user_data (name, phone, email, password) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);

            if($stmt->execute([$name, $phone, $email, $hashed_password])){
                $sql = "INSERT INTO profile_data (name, phone, email) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);

                if($stmt->execute([$name, $phone, $email,])){
                    $success = 1;
                }
            }
        }
    }
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/homepage.css">
</head>
<body>
    
    <div class="register-container">
    <div class="container">

    <nav class="navbar ps-3 pt-5 container">
        <div class="container d-flex justify-content-center">
            <a class="navbar-brand mt-3" href="homepage.php">
                <img src="../images/logo.png" alt="The Lego Empire" width="175">
            </a>
        </div>
    </nav>

    <!-- Login Form -->

    <div class="container mt-5">
        <div class="container homepage-login-container col-md-4" id="login">
            <form action="" method="POST" class="form py-4">
                <div>
                    <div class="input-wrapper">
                        <input type="email" class="form-control mb-3" name="email" id="email" placeholder="Email address" required>
                        <i class="fa fa-envelope"></i>
                    </div>
                    <div class="input-wrapper">
                        <input type="password" class="form-control mb-2" name="password" id="password" placeholder="Password" pattern="(?=.*\d)(?=.*[a-z]).{7,}" title="Must contain at least one number and one lowercase letter, and at least 7 or more characters" required>
                        <i class="fa fa-lock"></i>
                    </div>
                </div>                
                
                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" value="" id="showpassword" onclick="showPassword()">
                    <small><label class="form-check-label" for="showpassword">Show Password</label></small>
                </div>
                
                <div class="d-grid">
                    <button type="submit" class="btn pt-1" name="login-submit" id="login-submit" value="Login" style="border: none; background-color: black; color: white;">Login</button>
                </div>
            </form>

            <div class="text-center">Want to dive into LEGO world?<a onclick="showRegisterForm()" style="cursor: pointer; font-weight: bold;"> Create Account</a></div>
        </div>
    </div>

    <!-- Registration Form -->

    <div class="container">
        <div class="container homepage-register-container col-md-4" id="register" style="display: none;">
            <form action="" method="POST" class="form py-4">
                <div>
                    <div class="input-wrapper">
                        <input type="text" class="form-control mb-3" name="name" id="name" placeholder="Name" required>
                        <i class="fa fa-user"></i>
                    </div>
                    <div class="input-wrapper">
                        <input type="number" class="form-control mb-3" name="phone" id="phone" placeholder="Phone number" required>
                        <i class="fa fa-phone"></i>
                    </div>
                    <div class="input-wrapper">
                        <input type="email" class="form-control mb-3" name="email" id="email" placeholder="Email address" required>
                        <i class="fa fa-envelope"></i>
                    </div>
                    <div class="input-wrapper">
                        <input type="password" class="form-control mb-2" name="password" id="regpassword" placeholder="Password" pattern="(?=.*\d)(?=.*[a-z]).{7,}" title="Must contain at least one number and one lowercase letter, and at least 7 or more characters" required>
                        <i class="fa fa-lock"></i>
                    </div>
                </div>                
                
                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" value="" id="showregpassword" onclick="showRegPassword()">
                    <small><label class="form-check-label" for="showregpassword">Show Password</label></small>
                </div>
                
                <div class="d-grid">
                    <button type="submit" class="btn pt-1" name="register-submit" id="register-submit" value="Register" style="border: none; background-color: black; color: white;">Create Account</button>
                </div>
            </form>

            <div class="text-center">Already a LEGO member?<a onclick="showLoginForm()" style="cursor: pointer; font-weight: bold;"> Login</a></div>
        </div>
    </div>
    
    </div>
    </div>

    <!-- Login Error Message -->
    
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="loginErrorToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Login Error</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body" id="errorToastBody">Incorrect email or password.</div>
    </div>
    </div>

    <!-- Registration Success Message -->

    <div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="userSuccessToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Registration Successful</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">Your account has been created.</div>
    </div>
    </div>

    <!-- Registration Error Message -->

    <div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="userErrorToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Registration Error</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body" id="errorToastBody">User already exists.</div>
    </div>
    </div>
    
    <script>
    <?php
        if(!$userauth || !password_verify($password, $userauth['password'])){
            echo 'document.addEventListener("DOMContentLoaded", function() {
                var errorToast = new bootstrap.Toast(document.getElementById("loginErrorToast"));
                errorToast.show();
            });';
        }
    ?>
    </script>

    <script>
    <?php
        if(isset($success) && $success === 1){
            echo 'document.addEventListener("DOMContentLoaded", function() {
                var successToast = new bootstrap.Toast(document.getElementById("userSuccessToast"));
                successToast.show();
            });';
        }
    ?>
    </script>

    <script>
    <?php
        if(isset($result) && $result){
            echo 'document.addEventListener("DOMContentLoaded", function() {
                var errorToast = new bootstrap.Toast(document.getElementById("userErrorToast"));
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

    <script src="../js/script.js"></script>
    <script src="https://kit.fontawesome.com/296ff2fa8f.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

</body>
</html>