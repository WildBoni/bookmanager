<?php
  session_start();
  include_once 'dbconnect.php';

  if (!isset($_SESSION['userSession'])) {
    header("Location: index.php");
  }

  $query = $con->query("SELECT * FROM users WHERE id=".$_SESSION['userSession']);
  $userRow=$query->fetch_array();
  $con->close();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title>Welcome - <?php echo $userRow['email']; ?></title>
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
        	<h2><a href="view.php">VIEW ITEMS</a></h2>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
        <h2><a href="insert.php">INSERT NEW ITEMS</a></h2>
        </div>
      </div>
  </div>
  <script src="js/jquery-1.10.2.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>
</html>
