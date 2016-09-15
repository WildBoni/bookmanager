<?php

$servername = $dbusername = $dbpassword = $dbname = $useremail = $userpassword = $username = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $servername = htmlspecialchars($_POST['host']);
  $dbusername = htmlspecialchars($_POST['dbusername']);
  $dbpassword = htmlspecialchars($_POST['dbpassword']);
  $dbname = htmlspecialchars($_POST['dbname']);

  $useremail = htmlspecialchars($_POST['useremail']);
  $userpassword = htmlspecialchars($_POST['username']);
  $username = htmlspecialchars($_POST['userpassword']);

}

$data = "<?php
  \$servername = \"$servername\";
  \$dbusername = \"$dbusername\";
  \$dbpassword = \"$dbpassword\";
  \$dbname = \"$dbname\";

  \$useremail = \"$useremail\";
  \$userpassword = \"$userpassword\";
  \$username = \"$username\";
?>";

file_put_contents("config.php", $data);

include_once 'config.php';

// Create connection
$con = new mysqli($servername, $dbusername, $dbpassword);
// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS `".$dbname."`";
if ($con->query($sql) === TRUE) {
    echo "Database created successfully!";
} else {
    echo "Error creating database: " . $con->error;
}

echo "<br>";

// Create connection
$con2 = new mysqli($servername, $dbusername, $dbpassword, $dbname);
// Check connection
if ($con2->connect_error) {
    die("Connection failed: " . $con2->connect_error);
}

$sql1 = "CREATE TABLE IF NOT EXISTS users (
  id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  username varchar(60) NOT NULL,
  email varchar(60) NOT NULL,
  password varchar(255) NOT NULL,
  UNIQUE KEY email (email)
);";

$sql1 .= "INSERT INTO users (username, password, email)
VALUES ('$username', '$userpassword', '$useremail');";

$sql1 .= "CREATE TABLE IF NOT EXISTS category (
  id int(8) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  language varchar(150) NOT NULL
);";

$sql1 .= "CREATE TABLE IF NOT EXISTS language (
  id int(8) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  category varchar(150) NOT NULL
);";

$sql1 .= "CREATE TABLE IF NOT EXISTS item (
  id int(8) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  category varchar(8) NOT NULL,
  language1 varchar(150) NOT NULL,
  language2 varchar(150) NOT NULL,
  name varchar(150) NOT NULL,
  note varchar(255) NOT NULL,
  other varchar(255) NOT NULL,
  surname varchar(150) NOT NULL,
  title varchar(255) NOT NULL
);";



if ($con2->multi_query($sql1) === TRUE) {
    echo "<p>Tables created successfully!</p>
      <h2>Remember to delete install.php and create.php from your server!</h2>
      <p>Go to <a href='index.php'>login</a>
      and start adding items to your library!</p>";
} else {
    echo "Error creating tables: " . $con2->error;
}

$con->close();
$con2->close();
?>
