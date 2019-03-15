<?php
    require_once('connect.php');
    require_once('generateToken.php');
    
    session_start();
    
    $jwt = $_SESSION['jwt'];    
    $id = $_SESSION['user_id'];

    validateToken($id, $jwt, $conn);

    function validateToken($id, $userToken, $conn){
        $existingToken = generateToken($id, 1, $conn);
        echo "Existing token: ". $existingToken;

        if($userToken===$existingToken){
            echo "<br><br> Valid token!";
        }else{
            echo "<br><br> Invalid token!";
        }
    }
?>