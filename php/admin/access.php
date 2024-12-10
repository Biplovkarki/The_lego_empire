<?php
    include '../connect.php';

    if(!isset($_SESSION['adminname'])){
        header('location: adminauthentication.php');
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
    
    <div class="admin-content p-3">
        <?php 
            $sql = "SELECT * FROM admin_data";
            $stmt = $conn->prepare($sql);
            $stmt ->execute();
        ?>

        <div class="row">
            <div class="col">
                <table class="table">
                    <tr>
                        <td class="fw-bold text-center">S.N.</td>
                        <td class="fw-bold">Name</td>
                        <td class="fw-bold">Phone</td>
                        <td class="fw-bold">Email Address</td>
                    </tr>

                    <?php
                        $count = 1;

                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                            $name = $row['name'];
                            $phone = $row['phone'];
                            $email = $row['email'];
            
                            echo '<tr>';
                                echo '<td class="text-center">' . $count . '</td>';
                                echo '<td>' . $name . '</td>';
                                echo '<td>' . $phone . '</td>';
                                echo '<td>' . $email . '</td>';
                            echo '</tr>';
            
                            $count++;
                        }
                    ?>
                </table>
            </div>
        </div>
    </div>
    
    <script src="../../js/adminscript.js"></script>
    <script src="https://kit.fontawesome.com/296ff2fa8f.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

</body>
</html>