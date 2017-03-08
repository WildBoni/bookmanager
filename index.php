<?php
  session_start();
  require_once 'dbconnect.php';

  if (isset($_SESSION['userSession'])!="") {
    header("Location: home.php");
    exit;
  }

  if (isset($_POST['btn-login'])) {
    $email = strip_tags($_POST['email']);
    $password = strip_tags($_POST['password']);

    $email = $con->real_escape_string($email);
    $password = $con->real_escape_string($password);

    $query = $con->query("SELECT id, email, password FROM users WHERE email='$email'");
    $row=$query->fetch_array();

    $count = $query->num_rows; // if email/password are correct returns must be 1 row

    if (password_verify($password, $row['password']) && $count==1) {
      $_SESSION['userSession'] = $row['id'];
      header("Location: home.php");
    } else {
      $msg = "<div class='alert alert-danger'>
        <span class='glyphicon glyphicon-info-sign'></span> &nbsp; Invalid Username or Password !
      </div>";
    }
    $con->close();
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title>BKMNGR</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport" >
	<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
</head>

<body style="padding-top:10px;">
  </div>
  <div class="signin-form">
    <div class="container" style="background-color:#e7e7e7;">
      <form class="form-signin" method="post" id="login-form">
        <h2>Admin panel</h2>
        <hr />
        <?php
          if(isset($msg)){
            echo $msg;
          }
        ?>
        <div class="form-group">
          <input type="email" class="form-control" placeholder="Email address" name="email" required />
          <span id="check-e"></span>
        </div>
        <div class="form-group">
          <input type="password" class="form-control" placeholder="Password" name="password" required />
        </div>
        <hr />
        <div class="form-group">
          <button type="submit" class="btn btn-default" name="btn-login" id="btn-login">
            <span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign In
          </button>
          <a href="register.php" class="btn btn-default" style="float:right;">Sign UP Here</a>
        </div>
      </form>
    </div>
  </div>
  <div class="container" style="padding:20px 0 0px 0;">
    <div class="text-center">
      <h4><a href="search.php"style="background-color:#356b67; color:#FFF; padding: 10px 20px;">
        <span class="glyphicon glyphicon-search" style="font-size16px;"></span> Free search</a>
      </h4>
    </div>
</body>

<script src="js/jquery-1.10.2.js"></script>
<script src="js/bootstrap.min.js"></script>

</html>
