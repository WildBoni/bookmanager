<?php
  session_start();
  include_once 'dbconnect.php';

  if (!isset($_SESSION['userSession'])) {
    header("Location: index.php");
  }

  $target_dir = "uploads/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

  $name = $title = $surname = $other = $note = $categoryID = $language1ID = $language2ID = $image = $autoreID = "";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $surname = htmlspecialchars($_POST['surname']);
    $other = htmlspecialchars($_POST['other']);
    $note = htmlspecialchars($_POST['note']);
    $title = htmlspecialchars($_POST['title']);
    $categoryID = htmlspecialchars($_POST['category']);
    $language1ID = htmlspecialchars($_POST['language1']);
    $language2ID = htmlspecialchars($_POST['language2']);
		$image=($_FILES['fileToUpload']['name']);
    $autoreID = htmlspecialchars($_POST['autoreID']);
    $checkAttivo = $_POST['checkAttivo'];
  }

  echo "<script type='text/javascript'>alert('$autoreID');</script>";

  // Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
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
	if ($_FILES["fileToUpload"]["size"] > 500000) {
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
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
	}

  $sql7 = "INSERT INTO item (other, note, title, category, image)
  VALUES ('$other', '$note', '$title', '$categoryID', '$image')";

  if ($con->query($sql7) === TRUE) {
    echo "<p>New item created successfully</p>";
  } else {
    echo "Error: " . $sql7 . "<br>" . $con->error;
  }

	if($_POST["language1"] != "") {
    $sql8 = "INSERT INTO item_language (Item_Id, Language_Id)
    VALUES ((SELECT MAX(id) FROM item), '$language1ID')";

    if ($con->query($sql8) === TRUE) {
      echo "<p>New item created successfully</p>";
    } else {
      echo "Error: " . $sql8 . "<br>" . $con->error;
    }
  }

  if($_POST["language2"] != "") {
    $sql3 = "INSERT INTO item_language (Item_Id, Language_Id)
    VALUES ((SELECT MAX(id) FROM item), '$language2ID')";

    if ($con->query($sql3) === TRUE) {
      echo "<p>New item created successfully</p>";
    } else {
      echo "Error: " . $sql3 . "<br>" . $con->error;
    }
  }

  if($_POST["autoreID"] == "") {
    $sql4 = "INSERT INTO author (name, surname, other)
    VALUES ('$name', '$surname', '')";

    if ($con->query($sql4) === TRUE) {
      echo "<p>New item created successfully</p>";
    } else {
      echo "Error: " . $sql4 . "<br>" . $con->error;
    }

    $sql9 = "INSERT INTO item_author (ItemId, AuthorId)
    VALUES ((SELECT MAX(id) FROM item), (SELECT MAX(id) FROM author))";

    if ($con->query($sql9) === TRUE) {
      echo "<p>New item created successfully</p>";
    } else {
      echo "Error: " . $sql9 . "<br>" . $con->error;
    }

  } else {

    for ($i=0; $i<sizeof($checkAttivo); $i++) {
      $sql10 = "INSERT INTO item_author (ItemId, AuthorId)
      VALUES ((SELECT MAX(id) FROM item), ('" . $checkAttivo[$i] . "'))";
      if ($con->query($sql10) === TRUE) {
        echo "<p>Author linked successfully</p>";
      } else {
        echo "Error: " . $sql10 . "<br>" . $con->error;
      }
    }

  }

  $con->close();

?>
