// Deleting an item
<?php
  session_start();
  include_once 'dbconnect.php';

  if (!isset($_SESSION['userSession'])) {
    header("Location: index.php");
  }

  $id = $authId = "";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = htmlspecialchars($_POST['id']);
    $authId = htmlspecialchars($_POST['authid']);
  }
  $sql = $con->query("DELETE FROM item_author WHERE ItemId='$id' AND AuthorId='$authId'");

?>
