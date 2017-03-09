<?php
	session_start();
	include_once 'dbconnect.php';

	if (!isset($_SESSION['userSession'])) {
		header("Location: index.php");
	}

	$query = $con->query("SELECT * FROM users WHERE id=".$_SESSION['userSession']);
	$userRow=$query->fetch_array();

	$sql = "SELECT id, category FROM category";
	$result = $con->query($sql);

	$sql2 = "SELECT id, language FROM language";
	$result2 = $con->query($sql2);

?>
<!DOCTYPE html>
<html>
<head>
	<title>BKMNGR</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" >
	<script src="js/jquery-1.10.2.js"></script>
	<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
	<!-- Insert item -->
	<script>
	// Browser Support Code
	function ajaxFunction(){
		var ajaxRequest;  // The variable that makes Ajax possible!

		try{
   	// Opera 8.0+, Firefox, Safari
  	ajaxRequest = new XMLHttpRequest();
		}catch (e){
  		// Internet Explorer Browsers
  		try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
  		}catch (e) {
      	try{
        	ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      	}catch (e){
        	// Something went wrong
        	alert("Your browser broke!");
        	return false;
      	}
   		}
		}
	}
	//on the click of the submit button - INSERT ITEM
	$(document).on('click','#btn_submit',function(){

		var form = $('form')[0]; // You need to use standard javascript object here
		var formData = new FormData(form);

		var category = $('#category option:selected').val()
		formData.append('category', category);
		var language1 = $('#language1 option:selected').val()
		formData.append('language1', language1);
		var language2 = $('#language2 option:selected').val()
		formData.append('language2', language2);

		//call your .php script in the background,
		//when it returns it will call the success function if the request was successful or
		//the error one if there was an issue (like a 404, 500 or any other error status)
		$.ajax({
	    url : "ajaxinsert.php",
	    type: "POST",
	    data : formData,
			contentType: false,
			processData: false,
	    success: function(data)
	    {
	      //if success then1 just output the text to the status div then clear the form inputs to prepare for new data
	      $("#status_text").html("<p>OK</p>");
	    }
		});
	});
	//on the click of the submit button - INSERT CATEGORY
	$(document).on('click','#btn_submit_category',function(){

		var form = $('form')[1]; // You need to use standard javascript object here
		var formData = new FormData(form);

		//call your .php script in the background,
		//when it returns it will call the success function if the request was successful or
		//the error one if there was an issue (like a 404, 500 or any other error status)
		$.ajax({
	    url : "ajaxinsert_category.php",
	    type: "POST",
	    data : formData,
			contentType: false,
			processData: false,
	    success: function(data)
	    {
	      //if success then1 just output the text to the status div then clear the form inputs to prepare for new data
	      $("#status_text").html("<p>OK</p>");
	    }
		});
	});
	//on the click of the submit button - INSERT LANGUAGE
	$(document).on('click','#btn_submit_language',function(){

		var form = $('form')[2]; // You need to use standard javascript object here
		var formData = new FormData(form);

		//call your .php script in the background,
		//when it returns it will call the success function if the request was successful or
		//the error one if there was an issue (like a 404, 500 or any other error status)
		$.ajax({
	    url : "ajaxinsert_language.php",
	    type: "POST",
	    data : formData,
			contentType: false,
			processData: false,
	    success: function(data)
	    {
	      //if success then1 just output the text to the status div then clear the form inputs to prepare for new data
	      $("#status_text").html("<p>OK</p>");
	    }
		});
	});
	</script>
</head>
<body>
	<?php
    include 'header.php';
  ?>
	<div class="container-fluid">
	  <div class="row">
	    <div class="col-sm-12">
	      <h1>INSERT NEW ITEMS</h1>

				<div id="status_text">
				</div>


	<!--      	<form method="post" action="<?php //echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">   -->
	      <form class="form" action="" method="post" enctype="multipart/form-data">
	        <h2>NEW ITEM</h2>
					<div class="form-group">
						<div class="row">
						  <div class="col-sm-6">
			          <label for="name">Name:</label>
			          <input type="text" id="name" class="form-control" name="name">
			        </div>
							<div class="col-sm-6">
			          <label for="surname">Surname:</label>
			          <input type="text" id="surname" class="form-control" name="surname">
			        </div>
						</div>
					</div>
					<div class="form-group">
						<label for="title">Title:</label>
	          <input type="text" id="title" class="form-control" name="title">
	        </div>
					<div class="form-group">
						<div class="row">
							<div class="col-sm-6">
			          <label for="note">Note:</label>
			          <input type="text" id="note" class="form-control" name="note">
			        </div>
							<div class="col-sm-6">
								<label for="other">Other:</label>
								<input type="text" id="other" class="form-control" name="other">
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-12">
								<input type="file" class="form-control" name="fileToUpload" id="fileToUpload">
							</div>
						</div>
			  	</div>
	        <div class="form-group">
						<div class="row">
							<?php
								if ($result !== FALSE) {
							?>
							<div class="col-sm-4">
			        	<label for="dropdown">Category:</label>
			          <select id="category" name="categoryID">
									<?php
								    while ($row = $result->fetch_assoc()) {
							        echo "<option value=\"{$row['id']}\">";
							        echo $row['category'];
							        echo "</option>";
								    }
									?>
	          		</select>
							</div>
							<?php
								}
								if ($result2 !== FALSE) {
							?>
				      <div class="col-sm-4">
								<label for="dropdown">Language1:</label>
				        <select id="language1" name="language1ID">
									<?php
								    while ($row2 = $result2->fetch_assoc()) {
							        echo "<option value=\"{$row2['id']}\">";
							        echo $row2['language'];
							        echo "</option>";
								    }
										?>
									</select>
							</div>
							<div class="col-sm-4">
								<label for="dropdown">Language2:</label>
				        <select id="language2" name="language2ID">
									<?php
										mysqli_data_seek($result2,0);
								    while ($row2 = $result2->fetch_assoc()) {
							        echo "<option value=\"{$row2['id']}\">";
							        echo $row2['language'];
							        echo "</option>";
								    }
									?>
				        </select>
				      </div>
							<?php
								}
							?>
						</div>
					</div>
	        <button type="submit" id="btn_submit" class="btn btn-default">Submit new item</button>
	 	    </form>
				<hr>
	      <form class="form" action="" method="post">
	        <h2>NEW CATEGORY</h2>
	        <div class="form-group">
	          <label for="name">CAT:</label>
	          <input type="text" class="form-control" name="cat">
	        </div>
	        <button type="submit" id="btn_submit_category" class="btn btn-default">Submit new category</button>
	 	    </form>
				<hr>
				<form class="form" action="" method="post">
					<h2>NEW LANGUAGE</h2>
					<div class="form-group">
						<label for="name">LANGUAGE:</label>
						<input type="text" class="form-control" name="lang">
					</div>
	        <button type="submit" id="btn_submit_language" class="btn btn-default">Submit new language</button>
				</form>
	    </div>
	  </div>
	</div>

<script src="js/bootstrap.min.js"></script>

</body>
</html>
