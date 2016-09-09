<?php
  session_start();
  include_once 'dbconnect.php';

  if (!isset($_SESSION['userSession'])) {
    header("Location: index.php");
  }

  $query = $con->query("SELECT * FROM users WHERE id=".$_SESSION['userSession']);
  $userRow=$query->fetch_array();

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
				<?php
					$sql = "SELECT item.id, category.category, item.name, item.title FROM item INNER JOIN category ON item.category=category.id";
					$result = $con->query($sql);

					if ($result->num_rows > 0) {
				  	// output data of each row
					  while($row = $result->fetch_assoc()) {
					  	echo "<br> id: ". $row["id"]. " - Name: ". $row["name"]. " - Title: ". $row["title"]. " - Category: " . $row["category"] . " - <a href='edit.php?id=".$row['id']."'>Link</a> <br>";
					  }
					} else {
					  echo "0 results";
					}

					$con->close();
				?>
	    </div>
	  </div>
	</div>

<script src="js/jquery-1.10.2.js"></script>
<script src="js/bootstrap.min.js"></script>

</body>
</html>
