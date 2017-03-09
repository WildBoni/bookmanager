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
      <div class="col-sm-12" style="padding: 0 15px;">
          <h4><a href="view.php"style="background-color:#8d8a51; color:#FFF; padding: 10px 20px; display: block; width:198px;">
            <span class="glyphicon glyphicon-list" style="font-size16px;"></span> View items</a>
          </h4>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12" style="padding: 0 15px;">
          <h4><a href="insert.php"style="background-color:#893939; color:#FFF; padding: 10px 20px; display: block; width:198px;">
            <span class="glyphicon glyphicon-plus" style="font-size16px;"></span> Insert new items</a>
          </h4>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12" style="padding: 0 15px;">
          <h4><a href="search.php"style="background-color:#356b67; color:#FFF; padding: 10px 20px; display: block; width:198px;">
            <span class="glyphicon glyphicon-search" style="font-size16px;"></span> Free search</a>
          </h4>
      </div>
    </div>
  </div>
  <script src="js/jquery-1.10.2.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>
</html>
