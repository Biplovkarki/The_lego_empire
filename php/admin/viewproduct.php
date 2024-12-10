<?php
    include '../connect.php';

    if(!isset($_SESSION['adminname'])){
        header('location: adminauthentication.php');
    }

    if(isset($_POST['itemNumber'])){
        $itemNumber = $_POST['itemNumber'];
    }

    $stmt = $conn->prepare("SELECT * FROM lego_data WHERE itemNumber = :itemNumber");
    $stmt ->bindParam(':itemNumber', $itemNumber);
    $stmt ->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $title = isset($result['title']) ? $result['title'] : '';
    $price = isset($result['price']) ? $result['price'] : '';
    $category = isset($result['category']) ? $result['category'] : '';
    $age = isset($result['age']) ? $result['age'] : '';
    $pieces = isset($result['pieces']) ? $result['pieces'] : '';
    $points = isset($result['points']) ? $result['points'] : '';
    $itemNumber = isset($result['itemNumber']) ? $result['itemNumber'] : '';
    $specifications = isset($result['specifications']) ? $result['specifications'] : '';
    $specificationspoint = isset($result['specificationspoint']) ? $result['specificationspoint'] : '';

    if(isset($_POST['update-product'])){
        $title = $_POST['title'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $age = $_POST['age'];
        $pieces = $_POST['pieces'];
        $points = $_POST['points'];
        $itemNumber = $_POST['itemNumber'];
        $specifications = $_POST['specifications'];
        $specificationspoint = $_POST['specificationspoint'];
    
        if(empty($_POST['title']) || empty($_POST['price']) || empty($_POST['category']) || empty($_POST['age']) || empty($_POST['pieces']) || empty($_POST['points']) || empty($_POST['itemNumber']) || empty($_POST['specifications']) || empty($_POST['specificationspoint'])){
            $success = 0;
        }else{
            $stmt = $conn->prepare("UPDATE lego_data SET title = :title, price = :price, category = :category, age = :age, pieces = :pieces, points = :points, specifications = :specifications, specificationspoint = :specificationspoint WHERE itemNumber = :itemNumber");
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':category', $category);
            $stmt->bindParam(':age', $age);
            $stmt->bindParam(':pieces', $pieces);
            $stmt->bindParam(':points', $points);
            $stmt->bindParam(':itemNumber', $itemNumber);
            $stmt->bindParam(':specifications', $specifications);
            $stmt->bindParam(':specificationspoint', $specificationspoint);
    
            if($stmt->execute()){
                $success = 1;
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

        textarea{
            overflow: hidden;
        }

        select{
            height: 5.5vh;
        }
    </style>
</head>
<body>

    <!-- Product Edit Form -->
    <div class="product-edit-container">
        <form action="" method="POST" class="form" onsubmit="return validateForm()" onkeydown="return handleEnterKey(event)">
            <div class="row">
                <div class="col-md-2">
                    <div class="input-wrapper">
                        <label class="fw-bold" for="mainimage">Item Number</label>
                        <select class="form-select" name="itemNumber" id="itemNumber" onchange="this.form.submit()">
                            <option value=""></option>
                            <?php
                                $stmt = $conn->prepare("SELECT DISTINCT itemNumber FROM lego_data ORDER BY itemNumber ASC");
                                $stmt ->execute();
                                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                
                                foreach ($result as $row) {
                                    $selected = ($row['itemNumber'] == $itemNumber) ? "selected" : "";
                                    echo "<option value='".$row['itemNumber']."' ".$selected.">".$row['itemNumber']."</option>";
                                }
                                ?>
                        </select>

                        <!-- <input type="number" class="form-control" name="itemNumber" id="itemNumber" value="<?php echo $itemNumber ?>" onchange="this.form.submit()" required> -->
                    </div>
                </div>
                <div class="col-md-3 ps-0">
                    <div class="input-wrapper">
                        <label class="fw-bold" for="mainimage">Category</label>
                        <input type="text" class="form-control mb-3" name="category" id="category" value="<?php echo $category ?>" required>
                    </div>
                </div>
                <div class="col ps-0">
                    <div class="input-wrapper">
                        <label class="fw-bold" for="mainimage">Product Name</label>
                        <input type="text" class="form-control mb-3" name="title" id="title" value="<?php echo $title ?>" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="input-wrapper">
                        <label class="fw-bold" for="mainimage">Price</label>
                        <input type="number" class="form-control mb-3" name="price" id="price" value="<?php echo $price ?>" required>
                    </div>
                </div>
                <div class="col ps-0">
                    <div class="input-wrapper">
                        <label class="fw-bold" for="mainimage">Appropiate Age</label>
                        <input type="number" class="form-control mb-3" name="age" id="age" value="<?php echo $age ?>" required>
                    </div>
                </div>
                <div class="col ps-0">
                    <div class="input-wrapper">
                        <label class="fw-bold" for="mainimage">Lego Pieces</label>
                        <input type="number" class="form-control mb-3" name="pieces" id="pieces" value="<?php echo $pieces ?>" required>
                    </div>
                </div>
                <div class="col ps-0">
                    <div class="input-wrapper">
                        <label class="fw-bold" for="mainimage">Lego Points</label>
                        <input type="number" class="form-control mb-3" name="points" id="points" value="<?php echo $points ?>" required>
                    </div>
                </div>
            </div>
                
            <div class="input-wrapper">
                <label class="fw-bold" for="mainimage">Specifications</label>
                <textarea class="form-control mb-3" name="specifications" id="specifications" rows="7" required><?php echo $specifications ?></textarea>
            </div>
            <div class="input-wrapper">
                <label class="fw-bold" for="mainimage">Specifications Point</label>
                <textarea class="form-control mb-3" name="specificationspoint" id="specificationspoint" rows="7" required><?php echo $specificationspoint ?></textarea>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn pt-1" name="update-product" id="update-product" value="Update" style="border: none; background-color: black; color: white;">Update Product</button>
            </div>
        </form>
    </div>

    <!-- Product Update Success Message -->

    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="userSuccessToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto" id="successToastHead"></strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="successToastBody"></div>
        </div>
    </div>

    <script>
        <?php
            if(isset($success) && $success === 1){
                echo 'document.addEventListener("DOMContentLoaded", function(){
                    var successToast = new bootstrap.Toast(document.getElementById("userSuccessToast"));
                    document.getElementById("successToastHead").innerHTML = "Product Update Successful";
                    document.getElementById("successToastBody").innerHTML = "The product has been updated successfully.";
                    successToast.show();
                });';
            }
        ?>
    </script>

    <script>
        <?php
            if(isset($success) && $success === 0){
                echo 'document.addEventListener("DOMContentLoaded", function(){
                    var successToast = new bootstrap.Toast(document.getElementById("userSuccessToast"));
                    document.getElementById("successToastHead").innerHTML = "Product Update Error";
                    document.getElementById("successToastBody").innerHTML = "Fill in the blanks.";
                    successToast.show();
                });';
            }
        ?>
    </script>

    <script>
        function validateForm(){
            return true;
        }

        function handleEnterKey(event){
            if(event.key === 'Enter'){
                event.preventDefault();
                return false;
            }
        }
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