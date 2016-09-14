<?php
  session_start();
  include_once 'dbconnect.php';

  if (!isset($_SESSION['userSession'])) {
    header("Location: index.php");
  }

  $query = $con->query("SELECT * FROM users WHERE id=".$_SESSION['userSession']);
  $userRow=$query->fetch_array();

  $UID = (int)$_GET['id'];
  $sql ="SELECT * FROM language WHERE id = '$UID'";
  $result = $con->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $language = $row['language'];
      echo "Ready to edit";
    }
  }else {
    echo 'No entry found. <a href="javascript:history.back()">Go back</a>';
  }
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
        <form action="update_language.php" method="post">
          <input type="hidden" name="ID" value="<?=$UID;?>">
          Category: <input type="text" name="language" value="<?=$language?>"><br>
          <input type="Submit">
        </form>
      </div>
    </div>
  </div>
  <script src="js/jquery-1.10.2.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>
<?php
  $con->close();
?>
