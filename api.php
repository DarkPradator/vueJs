<?php

$conn = new mysqli("localhost", "root", "", "vueDb");

if ($conn->connect_error) {
	# code...
	die("Could not connect");
}

$res = array('error' => false);

$action = 'read';

if (isset($_GET['action'])) {
	# code...
	$action = $_GET['action'];
}

if ($action == 'read') {
	# code...
	$result = $conn->query("SELECT * FROM products");
	$products = array();

	while ($row = $result->fetch_assoc()) {
		# code...
		array_push($products, $row);
	}

	$res['products'] = $products; 
}

if ($action == 'create') {
	# code...
	$name = $_POST['name'];
	$description = $_POST['description'];
	$price = $_POST['price'];

	$result = $conn->query("INSERT INTO products (name, description, price) VALUES ('$name', '$description', '$price')");

	if ($result) {
		# code...
		$res['message'] = "Product added successfully";
	}else{
		$res['error'] = true;
		$res['message'] = "Could not insert Product";
	}
}

if ($action == 'update') {
	# code...
	$id = $_POST['id'];
	$name = $_POST['name'];
	$description = $_POST['description'];
	$price = $_POST['price'];

	$result = $conn->query("UPDATE products SET name = '$name', description= '$description', price = '$price' WHERE id = '$id' ");

	if ($result) {
		# code...
		$res['message'] = "Product updated successfully";
	}else{
		$res['error'] = true;
		$res['message'] = "Could not update Product";
	}
}

if ($action == 'delete') {
	# code...
	$id = $_POST['id'];
	$result = $conn->query("DELETE FROM products WHERE id = '$id' ");

	if ($result) {
		# code...
		$res['message'] = "Product deleted successfully";
	}else{
		$res['error'] = true;
		$res['message'] = "Could not delete Product";
	}
}

$conn->close();

header("Content-type: application/json");
echo json_encode($res);

?>