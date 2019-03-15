<?php
  require_once('connect.php');
  
  function generateToken($id, $new, $conn){
    
    $header = [
      'typ' => 'JWT',
      'alg' => 'HS256',  
    ];
    $header = json_encode($header);
    $header = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));

    $sql = "SELECT * FROM tbl_user WHERE user_id = '" . $id . "'";
		$result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    if($new == 0){
      $t = time();
      $date = date("Y-m-d h:m:s",$t);
      $sql = "UPDATE tbl_user SET date_created = '".$date."' WHERE user_id = '".$id."'";
      $result = mysqli_query($conn, $sql);
    }else{
      $date = $row['date_created'];
    }

    $payload = [
      'id' => $row['user_id'],
      'user' => $row['user'],
      'date_created' => $date
    ];
    $payload = json_encode($payload);
    $payload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
    
    $signature = hash_hmac('sha256', $header.".".$payload, base64_encode('discretekey'), true);
    $signature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
    
    $jwt = "$header.$payload.$signature";
    return $jwt;
  }
?>