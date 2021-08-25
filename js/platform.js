var app = new Vue({
	el: '#root',
	data:{
		showingAddModal: false,
		showingEditModal: false,
		showingDeleteModal: false,
		errorMessage: "",
		successMessage: "",
		products: [],
		newProduct: {name: "", description: "", price: ""},
		logDetails: {username: '', password: ''},
		clickedProduct: {}
	},
	mounted: function(){
		console.log('Mounted')
		this.getAllProducts()
	},
	methods:{
		getAllProducts:function(){
			axios.get("http://localhost/vueJs/vueTest/api.php?action=read")
			.then(function(response){
				if (response.data.error) 
				{
					app.errorMessage = response.data.message
				}else{
					app.products =response.data.products
				}
			})
		},

		saveProduct: function(){
			var formData = app.toFormData(app.newProduct)
			axios.post("http://localhost/vueJs/vueTest/api.php?action=create", formData)
			.then(function(response){
				app.newProduct = {name: "", description: "", price: ""}
				if (response.data.error) 
				{
					app.errorMessage = response.data.message
				}else{
					app.successMessage = response.data.message
					app.getAllProducts()
				}
			})
		},

		updateProduct: function()
		{
			var formData = app.toFormData(app.clickedProduct)
			axios.post("http://localhost/vueJs/vueTest/api.php?action=update", formData)
			.then(function(response){
				app.clickedProduct = {}
				if (response.data.error) 
				{
					app.errorMessage= response.data.message
				}else{
					app.successMessage = response.data.message
					app.getAllProducts()
				}
			})
		},

		deleteProduct: function(){
			var formData = app.toFormData(app.clickedProduct)
			axios.post("http://localhost/vueJs/vueTest/api.php?action=delete", formData)
			.then(function(response){
				app.clickedProduct = {}
				if (response.data.error) 
				{
					app.errorMessage= response.data.message
				}else{
					app.successMessage = response.data.message
					app.getAllProducts()
				}
			})
		},

		selectProduct(product){
			app.clickedProduct = product
		},

		toFormData: function(obj){
			var form_data = new FormData();
			for(var key in obj){
				form_data.append(key, obj[key]);
			}
			return form_data
		},

		// login
		keymonitor: function(event) {
			if(event.key == "Enter"){
			  app.checkLogin();
		 }
		},

		checkLogin: function(){
			var logForm = app.toFormData(app.logDetails);
			axios.post('login.php', logForm)
				.then(function(response){

					if(response.data.error){
						app.errorMessage = response.data.message;
					}
					else{
						app.successMessage = response.data.message;
						app.logDetails = {username: '', password:''};
						setTimeout(function(){
							window.location.href="platform.php";
						},2000);

					}
				});
		},
 
		clearMessage: function(){
			app.errorMessage = '';
			app.successMessage = '';
		}
	}
})
