<?php

	$target_dir = "uploads/";
	$target_file = $target_dir . basename($_FILES["fileToUpload2"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

  include_once 'dbconnect.php';

  $ud_ID = (int)$_POST["ID"];
  $name = $title = $surname = $other = $note = $categoryID = $language1ID = $language2ID = $image = "";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $title = htmlspecialchars($_POST['title']);
    $surname = htmlspecialchars($_POST['surname']);
    $other = htmlspecialchars($_POST['other']);
    $note = htmlspecialchars($_POST['note']);
    $categoryID = htmlspecialchars($_POST['categoryID']);
    $language1ID = htmlspecialchars($_POST['language1ID']);
    $language2ID = htmlspecialchars($_POST['language2ID']);
	$image=($_FILES['fileToUpload2']['name']);
  }

  $sql = "UPDATE item SET name = '$name', title = '$title', surname = '$surname',
    other = '$other', note = '$note', category = '$categoryID',
    language1 = '$language1ID', language2 = '$language2ID', image='$image'
    WHERE id='$ud_ID'";

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload2"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload2"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload2"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload2"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

  if ($con->query($sql) === TRUE) {
      echo "<p>Record ($ud_ID) updated successfully</p><p><a href='view.php'>Back to Item View</a></p>";
  } else {
      echo "Error: ($ud_ID) Not Updated";
  }

  $con->close();

?>
