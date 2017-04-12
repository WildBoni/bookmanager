<?php

	$target_dir = "uploads/";
	$target_file = $target_dir . basename($_FILES["fileToUpload2"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

  include_once 'dbconnect.php';

  $ud_ID = (int)$_POST["ID"];
  $au_ID = (int)$_POST["authID"];

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

  $sql = "UPDATE item SET title = '$title', other = '$other', note = '$note', category = '$categoryID', image='$image'
    WHERE id='$ud_ID'";

	$sql2 = "UPDATE author SET name = '$name', surname = '$surname' WHERE id='$au_ID'";

	$sql4 ="SELECT * FROM item_language WHERE Item_Id = '$ud_ID'";
	$languages = array();
	$result4 = $con->query($sql4);
	while($row4 = $result4->fetch_array()) {
			$languages[] = $row4;
	}

	$language1 = $languages[0]['Id'];
	$language2 = $languages[1]['Id'];

	$sql3 = "UPDATE item_language SET Language_Id = '$language1ID' WHERE Id='$language1'";
	$sql5 = "UPDATE item_language SET Language_Id = '$language2ID' WHERE Id='$language2'";

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
    echo "<p>Record ($ud_ID) updated successfully</p><p><a href='javascript:history.go(-2);'>Back to Item View</a></p>";
  } else {
    echo "Error: ($ud_ID) Not Updated";
  }

	if ($con->query($sql2) === TRUE) {
    echo "<p>Record ($au_ID) updated successfully</p><p><a href='javascript:history.go(-2);'>Back to Item View</a></p>";
  } else {
    echo "Error: ($au_ID) Not Updated";
  }

	if ($con->query($sql3) === TRUE) {
    echo "<p>Record1 ($language1ID) updated successfully</p><p><a href='javascript:history.go(-2);'>Back to Item View</a></p>";
  } else {
    echo "Error: ($au_ID) Not Updated";
  }

	if ($con->query($sql5) === TRUE) {
    echo "<p>Record2 ($language2ID) updated successfully</p><p><a href='javascript:history.go(-2);'>Back to Item View</a></p>";
  } else {
    echo "Error: ($au_ID) Not Updated";
  }

  $con->close();

?>
