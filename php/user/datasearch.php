<?php
    session_start();
    include '../connect.php';

    if(isset($_POST['search'])){
        $title = strtolower($_POST['search']);
        $itemNumber = $_POST['search'];
    }
    
    if($title != null || $itemNumber != null){
        $stmt = $conn->prepare("SELECT * FROM lego_data WHERE lower(title) LIKE :title || itemNumber LIKE :itemNumber");
        $stmt ->bindParam(':title', $titleLike);
        $stmt ->bindParam(':itemNumber', $itemNumberLike);
        $titleLike = '%' .$title. '%';
        $itemNumberLike = '%' .$itemNumber. '%';
        $stmt ->execute();
        $value = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $status = 1; 

        $getLego = array(); 
        foreach($value as $item){
            $getLego[] = $item['legoId'];
            $count++;
        }
    }else{
        $status = 0;
    }

    if(empty($getLego)){
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
    <div class="container mt-5">
        <h4 class='fw-bold'>No products found.</h4>
        <h5>Redirecting to the homepage . . .</h5>
    </div>
</body>
</html>

<?php 
    }else{
        $queryString = http_build_query($getLego);
        header("location: userpage.php?count=$count&status=$status&$queryString");
    }    
?>

<script>
    setTimeout(function(){
        window.location.href = "userpage.php";
    }, 2500);
</script>