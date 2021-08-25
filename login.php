<?php
session_start();
 
$conn = new mysqli("localhost", "root", "", "vueDb");
 
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
 
$res = array('error' => false);
 
$username = $_POST['username'];
$password = $_POST['password'];
 
if($username==''){
	$res['error'] = true;
	$res['message'] = "Username is required";
}
else if($password==''){
	$res['error'] = true;
	$res['message'] = "Password is required";
}
else{
	$sql = "select * from user where username='$username' and password='$password'";
	$query = $conn->query($sql);
 
	if($query->num_rows>0){
		$row=$query->fetch_array();
		$_SESSION['user']=$row['userid'];
		$res['message'] = "Login Successful";
	}
	else{
		$res['error'] = true;
		$res['message'] = "Login Failed. User not Found";
	}
}
 
 
 
$conn->close();
 
header("Content-type: application/json");
echo json_encode($res);
die();
 
 
?>