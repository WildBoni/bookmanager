<?php
include_once 'dbconnect.php';

$name = $title = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $cat = htmlspecialchars($_POST['cat']);
}


$sql = "INSERT INTO category (category)
VALUES ('$cat')";

if ($conn->query($sql) === TRUE) {
    echo "New category created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

?>