<?php
    include '../connect.php';

    if(!isset($_SESSION['adminname'])){
        header('location: adminauthentication.php');
    }

    if(isset($_SESSION['adminId'])){
        $adminId = $_SESSION['adminId'];
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
            $sql = "SELECT password FROM admin_data WHERE adminId = :adminId";
            $stmt = $conn->prepare($sql);
            $stmt ->bindParam(':adminId', $adminId);
            $stmt ->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if($result){
                $storedPassword = $result['password'];
                if(password_verify($oldPassword, $storedPassword)){
                    $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                    $sql = "UPDATE admin_data SET password = :newPassword WHERE adminId = :adminId";
                    $stmt = $conn->prepare($sql);
                    $stmt ->bindParam(':adminId', $adminId);
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
    </style>
</head>
<body>

    <div class="update-content-container" id="update">
        <?php
            $sql = "SELECT * FROM admin_data WHERE adminId = :adminId";
            $stmt = $conn->prepare($sql);
            $stmt ->bindParam(':adminId', $adminId);
            $stmt ->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        ?>

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
        if( window.history.replaceState ){
            window.history.replaceState( null, null, window.location.href );
        }
    </script>
    
    <script src="../../js/adminscript.js"></script>
    <script src="https://kit.fontawesome.com/296ff2fa8f.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

</body>
</html>