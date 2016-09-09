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

?>
<!DOCTYPE html>
<html>
<head>
	<title>BKMNGR</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" >
	<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
</head>
<body>
	<?php
    include 'header.php';
  ?>
	<div class="container-fluid">
	  <div class="row">
	    <div class="col-sm-12">
	      <h2>INSERT NEW ITEMS</h2>
	<!--      	<form method="post" action="<?php //echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">   -->
	      <form  method="post" action="input.php">
	        <h3>NEW BOOK</h3>
	        <div class="form-group">
	          <label for="name">Name:</label>
	          <input type="text" class="form-control" name="name">
	        </div>
	        <div class="form-group">
	          <label for="title">Title:</label>
	          <input type="text" class="form-control" name="title">
	        </div>
	        <div class="form-group">
	        	<label for="dropdown">Category:</label>
	          <select name="categoryID">
							<?php
						    while ($row = $result->fetch_assoc()) {
					        echo "<option value=\"{$row['id']}\">";
					        echo $row['category'];
					        echo "</option>";
						    }
							?>
	          </select>
	        </div>
	        <button type="submit" class="btn btn-default">Submit</button>
	 	    </form>
	      <form  method="post" action="cat_input.php">
	        <h3>NEW CATEGORY</h3>
	        <div class="form-group">
	          <label for="name">CAT:</label>
	          <input type="text" class="form-control" name="cat">
	        </div>
	        <button type="submit" class="btn btn-default">Submit</button>
	 	    </form>
	    </div>
	  </div>
	</div>

<script src="js/jquery-1.10.2.js"></script>
<script src="js/bootstrap.min.js"></script>

</body>
</html>
