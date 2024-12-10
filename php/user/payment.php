<!-- <?php
    // $username = $_POST['username'];
    // $cartTotal = $_POST['amount']; 

    // $paisa = $cartTotal * 100;

    // $curl = curl_init();
    // curl_setopt_array($curl, array(
    //     CURLOPT_URL => 'https://a.khalti.com/api/v2/epayment/initiate/',
    //     CURLOPT_RETURNTRANSFER => true,
    //     CURLOPT_ENCODING => '',
    //     CURLOPT_MAXREDIRS => 10,
    //     CURLOPT_TIMEOUT => 0,
    //     CURLOPT_FOLLOWLOCATION => true,
    //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //     CURLOPT_CUSTOMREQUEST => 'POST',
    //     CURLOPT_POSTFIELDS =>'{
    //         "return_url": "http://localhost/legoempire/php/user/paymentsuccess.php",
    //         "website_url": "https://127.0.0.1/",
    //         "amount": "' . $paisa . '",
    //         "purchase_order_id": "Order01",
    //             "purchase_order_name": "test",

    //         "customer_info": {
    //             "name": "'.$username.'",
    //             "email": "test@khalti.com",
    //             "phone": "9800000001"
    //         }
    //     }

    //     ',
    //     CURLOPT_HTTPHEADER => array(
    //         'Authorization: key live_secret_key_68791341fdd94846a146f0457ff7b455',
    //         'Content-Type: application/json',
    //     ),
    // ));

    // $response = curl_exec($curl);
    // curl_close($curl);
    // echo $response;
    
    // if(!empty($response)){
    //     $responseData = json_decode($response, true);

    //     if(isset($responseData['payment_url'])){
    //         $value = $responseData['payment_url'];
    //         echo $value;
    //         header("Location: $value");
    //     }else{
    //         echo "Payment url not found in response.";
        
    //     }
    // }else{
    //     echo "Empty response received.";
    // }
?> -->
<?php
session_start();

// Check if the user is logged in
if(isset($_SESSION['userId'])){
    include '../connect.php'; // Assuming this file contains the database connection code

    // Fetch user data from the database
    $userId = $_SESSION['userId'];
    $stmt = $conn->prepare("SELECT * FROM user_data WHERE userId = :userId");
    $stmt->bindParam(':userId', $userId);
    $stmt->execute();
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if user data was found
    if($userData){
        // Extract user information
        $username = $userData['name'];
        $email = $userData['email'];
        $phone = $userData['phone'];

        // Amount calculation
        $cartTotal = $_POST['amount']; 
        $paisa = $cartTotal * 100;

        // Construct customer info object
        $customerInfo = array(
            "name" => $username,
            "email" => $email,
            "phone" => $phone
        );

        // Payment initiation request
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://a.khalti.com/api/v2/epayment/initiate/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode(array(
                "return_url" => "http://localhost/legoempire/php/user/paymentsuccess.php",
               "website_url" => "https://127.0.0.1/",
                "amount" => $paisa,
                "purchase_order_id" => "Order01",
                "purchase_order_name" => "test",
                "customer_info" => $customerInfo
            )),
            
            CURLOPT_HTTPHEADER => array(
                'Authorization: key live_secret_key_68791341fdd94846a146f0457ff7b455',
                'Content-Type: application/json',
            ),
        ));

        // Execute the request
        $response = curl_exec($curl);
        curl_close($curl);
        echo $response;

        // Process the response
         if(!empty($response)){
        $responseData = json_decode($response, true);

        if(isset($responseData['payment_url'])){
            $value = $responseData['payment_url'];
            echo $value;
            header("Location: $value");
        }else{
            echo "Payment url not found in response.";
        
        }
    }else{
        echo "Empty response received.";
    }
    } else {
        echo "User data not found.";
    }
} else {
    echo "User not logged in.";
}
?>


<!-- <?php
// session_start();

// // Check if the user is logged in
// if(isset($_SESSION['userId'])){
//     include '../connect.php'; // Assuming this file contains the database connection code

//     // Fetch user data from the database
//     $userId = $_SESSION['userId'];
//     $stmt = $conn->prepare("SELECT * FROM user_data WHERE userId = :userId");
//     $stmt->bindParam(':userId', $userId);
//     $stmt->execute();
//     $userData = $stmt->fetch(PDO::FETCH_ASSOC);

//     // Check if user data was found
//     if($userData){
//         // Extract user information
//         $username = $userData['name'];
//         $email = $userData['email'];
//         $phone = $userData['phone'];

//         // Amount calculation
//         $cartTotal = $_POST['amount']; 
//         $paisa = $cartTotal * 100;

//         // Construct customer info object
//         $customerInfo = array(
//             "name" => $username,
//             "email" => $email,
//             "phone" => $phone
//         );

//         // Payment initiation request
//         $curl = curl_init();
//         curl_setopt_array($curl, array(
//             CURLOPT_URL => 'https://a.khalti.com/api/v2/epayment/initiate/',
//             CURLOPT_RETURNTRANSFER => true,
//             CURLOPT_ENCODING => '',
//             CURLOPT_MAXREDIRS => 10,
//             CURLOPT_TIMEOUT => 0,
//             CURLOPT_FOLLOWLOCATION => true,
//             CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//             CURLOPT_CUSTOMREQUEST => 'POST',
//             CURLOPT_POSTFIELDS => json_encode(array(
//                 "return_url" => "http://karkibiplov.com.np/paymentsuccess.php",
//                 "website_url" => "https://karkibiplov.com.np/",
//                 "amount" => $paisa,
//                 "purchase_order_id" => "Order01",
//                 "purchase_order_name" => "test",
//                 "customer_info" => $customerInfo
//             )),
//             CURLOPT_HTTPHEADER => array(
//                 'Authorization: key live_secret_key_68791341fdd94846a146f0457ff7b455',
//                 'Content-Type: application/json',
//             ),
//         ));

//         // Execute the request
//         $response = curl_exec($curl);
        

//         // Process the response
//          if(!empty($response)){
//         $responseData = json_decode($response, true);

//         if(isset($responseData['payment_url'])){
//             $value = $responseData['payment_url'];
           
//             header("Location: $value");
//         }else{
//             echo "Payment url not found in response.";
        
//         }
//     }else{
//         echo "Empty response received.";
//     }
//     } else {
//         echo "User data not found.";
//     }
// } else {
//     echo "User not logged in.";
// }
?> -->
