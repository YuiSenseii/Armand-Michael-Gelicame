<?php
    require_once('generateToken.php');
    require_once('connect.php');
    session_start();

    $user = $_POST['uname'];
    $pass = $_POST['pass'];
    
	$sql = "SELECT * FROM tbl_user WHERE user = '" . $user . "' AND pass = '" . $pass . "'";
	$result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);
    
	if($count == 1){
		$sql = "SELECT * FROM tbl_user WHERE user = '" . $user . "'";
		$result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);

        $id = $row['user_id'];
        $jwt = generateToken($id, 0, $conn);

        $_SESSION['user_id'] = $id;
        $_SESSION['jwt'] = $jwt;
        
        header("Location: ../validate.html");
    }
    else{
        echo "Error";
    }
?>