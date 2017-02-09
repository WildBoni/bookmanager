<?php
  session_start();
  include_once 'dbconnect.php';

  if (!isset($_SESSION['userSession'])) {
    header("Location: index.php");
  }

  $query = $con->query("SELECT * FROM users WHERE id=".$_SESSION['userSession']);
  $userRow=$query->fetch_array();

  $UID = (int)$_GET['id'];
  $sql ="SELECT * FROM item WHERE id = '$UID'";
  $result = $con->query($sql);

  $sql2 = "SELECT id, category FROM category";
	$result2 = $con->query($sql2);

  $sql3 = "SELECT id, language FROM language";
	$result3 = $con->query($sql3);

  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $name = $row['name'];
      $title = $row['title'];
      $surname = $row['surname'];
      $other = $row['other'];
      $note = $row['note'];
      $category = $row['category'];
      $language1 = $row['language1'];
      $language2 = $row['language2'];
      $image = $row['image'];
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
	  <script src="js/jquery-1.10.2.js"></script>
  <script src="js/bootstrap.min.js"></script>
	  <script>
    $(document).on('click','.delete',function(){
		
      var element = $(this);
      var del_id = element.attr('data-id');
      var info = 'id=' + del_id;
      if(confirm("Are you sure you want to delete this?")) {
        $.ajax({
          type: "POST",
          url: "ajaxupdate.php",
          data: info,
          success: function(){
			$("#deleteimg").html("<p>Image deleted</p>");
          }
        });
      }
      return false;
    });
  </script>
</head>

<body>
  <?php
    include 'header.php';
  ?>
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <form class="form" action="update.php" enctype="multipart/form-data"  method="post">
          <input type="hidden" name="ID" value="<?=$UID;?>">
          Name: <input type="text" name="name" value="<?=$name?>"><br>
          Surname: <input type="text" name="surname" value="<?=$surname?>"><br>
          Title: <input type="text" name="title" value="<?=$title?>"><br>
          Other authors: <input type="text" name="other" value="<?=$other?>"><br>
          Note: <input type="text" name="note" value="<?=$note?>"><br>
          <div id="deleteimg">
             	<?php if (!empty($image)) { ?>
			  		<img src="uploads/<?php echo $image ?>">
			  	<?php } else { ?>
					 <!-- <img src="uploads/no_img.jpg"> -->
				<?php } ?>	
		  </div>   
      		<?php if (!empty($image)) { ?> 
       		<a data-id="<?=$UID;?>" class="delete" href="#">Delete</a>
       		<?php } ?>
	       	<div class="form-group">
				<div class="row">
					<div class="col-md-12">
						<input type="file" class="form-control" name="fileToUpload2" id="fileToUpload2">
					</div>
				</div>
			</div>

          <div class="form-group">
	        	<label for="dropdown">Category:</label>
	          <select name="categoryID">
							<?php
						    while ($row2 = $result2->fetch_assoc()) {
                  if ($row2['id'] == trim($category)) {
                    echo "<option value='" . $row2['id'] . "' selected>" . $row2['category'] . "</option>";
                  }
                  else {
                    echo "<option value='" . $row2['id'] . "'>" . $row2['category'] . "</option>";
                  }
						    }
							?>
	          </select>
	        </div>
          <div class="form-group">
            <label for="dropdown">Language1:</label>
            <select name="language1ID">
              <?php
                while ($row3 = $result3->fetch_assoc()) {
                  if ($row3['id'] == trim($language1)) {
                    echo "<option value='" . $row3['id'] . "' selected>" . $row3['language'] . "</option>";
                  }
                  else {
                    echo "<option value='" . $row3['id'] . "'>" . $row3['language'] . "</option>";
                  }
                }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="dropdown">Language2:</label>
            <select name="language2ID">
              <?php
                mysqli_data_seek($result3,0);
                while ($row3 = $result3->fetch_assoc()) {
                  if ($row3['id'] == trim($language2)) {
                    echo "<option value='" . $row3['id'] . "' selected>" . $row3['language'] . "</option>";
                  }
                  else {
                    echo "<option value='" . $row3['id'] . "'>" . $row3['language'] . "</option>";
                  }
                }
              ?>
            </select>
	        </div>
	        
          <input type="Submit">
        </form>
      </div>
    </div>
  </div>

</body>
<?php
  $con->close();
?>
