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

  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $title = $row['title'];
      $note = $row['note'];
      $category = $row['category'];
      $image = $row['image'];
      $other= $row['other'];

      $sql3 = "SELECT language.id AS langId, language.language
      FROM item
      LEFT JOIN item_language ON item.id = item_language.Item_Id
      LEFT JOIN language ON item_language.Language_Id = language.id
      WHERE item.id = $UID";
      $languages = array();
      $result3 = $con->query($sql3);
      while($row3 = $result3->fetch_array()) {
          $languages[] = $row3;
      }

      $language1 = $languages[0]['language'];
      $language2 = $languages[1]['language'];

      $sql4 =  "SELECT author.id AS authId, author.surname AS authSurname, author.name AS authName
        FROM item
        LEFT JOIN item_author ON item.id = item_author.ItemId
        LEFT JOIN author ON item_author.AuthorID = author.id
        WHERE item.id = $UID";
      $result4 = $con->query($sql4);
      if ($result4->num_rows > 0) {
        $row4 = $result4->fetch_assoc();
          $authID = $row4['authId'];
          $name = $row4['authName'];
          $surname = $row4['authSurname'];
          echo "OK - ";
      } else {
        echo ("no!");
      }
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
  //search author
  $(document).ready(function(){
	    $('.search-box input[type="text"]').on("keyup input", function(){
	        /* Get input value on change */
	        var inputVal = $(this).val();
	        var resultDropdown = $(".result");
	        if(inputVal.length){
	            $.get("livesearch_author.php", {term: inputVal}).done(function(data){
	                // Display the returned data in browser
	                resultDropdown.html(data);
	            });
	        } else{
	            resultDropdown.empty();
	        }
	    });
	});

  var autoreID = "";


	$(document).on('click','.checkName',function(){
		autoreID = $(this).val();
		console.log(autoreID);
	});


  // Delete database value code
  $(document).on('click','.delete',function(){
    var element = $(this);
    var formData = new FormData();
    var del_id = element.attr('data-id');
    var del_authid = element.attr('data-authid');
    formData.append('id', del_id);
    formData.append('authid', del_authid);
    if(confirm("Are you sure you want to delete this?")) {
      $.ajax({
        type: "POST",
        url: "ajaxdelete_author.php",
        data: formData,
        contentType: false,
  			processData: false,
        success: function(data){
          for (var pair of formData.entries()) {
    console.log(pair[0]+ ', ' + pair[1]);
}
        }
      });
      $(this).animate({ backgroundColor: "#003" }, "slow")
      .animate({ opacity: "hide" }, "slow");
    }
    return false;
  });

    $(document).on('click','.delImg',function(){

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
          <input type="hidden" name="authID" value="<?=$authID;?>">

          <div class="form-group">
						<div class="row">
							<div class="col-sm-12">
								<label>Author:</label>
								<div class="search-box">
					        <input type="text" autocomplete="off" placeholder="Search author..." />
					      </div>
							</div>
						</div>
						<div class="row result">

				    </div>
					</div>

          <p style="margin-top:10px;">Author: <?=$name?> - <?=$surname?>  |
            <a data-id="<?php echo $UID?>" data-authid="<?php echo $authID?>" class="delete" href="#">Delete assignment</a></p>
          Title: <input type="text" name="title" value="<?=$title?>"><br>
          Other: <input type="text" name="other" value="<?=$other?>"><br>
          Note: <input type="text" name="note" value="<?=$note?>"><br>
          <div id="deleteimg">
            <?php if (!empty($image)) { ?>
			  		  <img src="uploads/<?php echo $image ?>">
			  	  <?php } else { ?>
              <!-- <img src="uploads/no_img.jpg"> -->
				    <?php } ?>
		      </div>
      		<?php if (!empty($image)) { ?>
       		<a data-id="<?=$UID;?>" class="delImg" href="#">Delete</a>
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
              <option value="0">NOT selected</option>
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
              <option value="0">NOT selected</option>
              <?php
                $sql5 ="SELECT * FROM language ";
                $result5 = $con->query($sql5);
                while ($row5 = $result5->fetch_assoc()) {
                  if ($row5['language'] == $language1) {
                    echo "<option value='" . $row5['id'] . "' selected>" . $row5['language'] . "</option>";
                  }
                  else {
                    echo "<option value='" . $row5['id'] . "'>" . $row5['language'] . "</option>";
                  }
                }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="dropdown">Language2:</label>
            <select name="language2ID">
              <option value="0">NOT selected</option>
              <?php
                mysqli_data_seek($result5,0);
                while ($row5 = $result5->fetch_assoc()) {
                  if ($row5['language'] == $language2) {
                    echo "<option value='" . $row5['id'] . "' selected>" . $row5['language'] . "</option>";
                  }
                  else {
                    echo "<option value='" . $row5['id'] . "'>" . $row5['language'] . "</option>";
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
