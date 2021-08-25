<?php
	session_start();
	$conn = new mysqli("localhost", "root", "", "vueDb");
 
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
 
	if (!isset($_SESSION['user']) ||(trim ($_SESSION['user']) == '')){
		header('location:index.php');
	}
 
	$sql="SELECT * FROM user WHERE userid='".$_SESSION['user']."'";
	$query=$conn->query($sql);
	$row=$query->fetch_array();
 
?>
<!DOCTYPE html>
<html>
<head>
	<title>Vue.js test</title>
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<div id="root">
		<div class="container">
			<div class="jumbotron">
				<h1 class="text-center">Welcome, <?php echo $row['username']; ?>!</h1>
			</div>
			<h1 class="fleft">List of Products</h1>
			<button class="fright addNew" @click="showingAddModal = true">Add New</button>
			<div class="clear"></div>
			<hr>
			<p class="errorMessage" v-if="errorMessage">
				{{ errorMessage }}
				<button class="fright close" @click="errorMessage = '' ">X</button>
			</p>
			<p class="successMessage" v-if="successMessage">
				{{ successMessage }}
				<button class="fright close" @click="successMessage = '' ">X</button>
			</p>
			<table class="list">
				<tr>
					<th>ID</th>
					<th>Product Name</th>
					<th>Description</th>
					<th>Price</th>
					<th>Edit</th>
					<th>Delete</th>
				</tr>
				<tr v-for="product in products">
					<td>{{ product.id }}</td>
					<td>{{ product.name }}</td>
					<td>{{ product.description }}</td>
					<td>{{ product.price }}</td>
					<td><button @click="showingEditModal = true; selectProduct(product)">Edit</button></td>
					<td><button @click="showingDeleteModal = true; selectProduct(product)">Delete</button></td>
				</tr>
			</table>
		</div>

		<div class="modal" id="addModal" v-if="showingAddModal">
			<div class="modalContainer">
				<div class="modalHeading">
					<p class="fleft">Add New Produst</p>
					<button class="fright close" @click="showingAddModal= false">X</button>
					<div class="clear"></div>
				</div>
				<div class="modalContent">
					<table class="form">
						<tr>
							<th>Produst Name</th>
							<th> : </th>
							<td> <input type="text" name="" v-model="newProduct.name"> </td>
						</tr>
						<tr>
							<th>Description</th>
							<th> : </th>
							<td> <input type="text" name="" v-model="newProduct.description"> </td>
						</tr>
						<tr>
							<th>Price</th>
							<th> : </th>
							<td> <input type="text" name="" v-model="newProduct.price"> </td>
						</tr>
						<tr>
							<th></th>
							<th></th>
							<td> <button @click="showingAddModal = false; saveProduct()">Save</button> </td>
						</tr>
					</table>
				</div>
			</div>
		</div>

		<div class="modal" id="editModal" v-if="showingEditModal">
			<div class="modalContainer">
				<div class="modalHeading">
					<p class="fleft">Edit This Product</p>
					<button class="fright close" @click="showingEditModal= false">X</button>
					<div class="clear"></div>
				</div>
				<div class="modalContent">
					<table class="form">
						<tr>
							<th>Name</th>
							<th> : </th>
							<td> <input type="text" name="" v-model="clickedProduct.name"> </td>
						</tr>
						<tr>
							<th>Description</th>
							<th> : </th>
							<td> <input type="text" name="" v-model="clickedProduct.description"> </td>
						</tr>
						<tr>
							<th>Price</th>
							<th> : </th>
							<td> <input type="text" name="" v-model="clickedProduct.price"></td>
						</tr>
						<tr>
							<th></th>
							<th></th>
							<td> <button @click="showingEditModal = false; updateProduct()">Update</button> </td>
						</tr>
					</table>
				</div>
			</div>
		</div>

		<div class="modal" id="deleteModal" v-if="showingDeleteModal">
			<div class="modalContainer">
				<div class="modalHeading">
					<p class="fleft">Are you sure ?</p>
					<button class="fright close" @click="showingDeleteModal = false">X</button>
					<div class="clear"></div>
				</div>
				<div class="modalContent">
					<p>You are going to delete {{ clickedProduct.name }}......</p>
					<br><br><br><br><br>
					<button @click="showingDeleteModal = false; deleteProduct()">Yes</button>
					<button @click="showingDeleteModal = false">No</button>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="jumbotron">
				<a href="logout.php" class="btn btn-primary"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
			</div>
		</div>
	</div>
<script type="text/javascript" src="js/vue.js"></script>
<script type="text/javascript" src="js/axios.js"></script>
<script type="text/javascript" src="js/platform.js"></script>
</body>
</html>