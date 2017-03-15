<?php
  session_start();
  include_once 'dbconnect.php';

  if (!isset($_SESSION['userSession'])) {
    header("Location: index.php");
  }

  $query = $con->query("SELECT * FROM users WHERE id=".$_SESSION['userSession']);
  $userRow=$query->fetch_array();
  $currentItem = 0;
?>
<!DOCTYPE html>
<html>
<head>
	<title>BKMNGR</title>
  <script src="//code.jquery.com/jquery-1.12.3.js"></script>
  <link rel="stylesheet"  href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link rel="stylesheet"  href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
  <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" >

  <script>
    $(document).ready(function() {
      $('#example').DataTable( {
        "lengthMenu": [[50, 100, 150, -1], [50, 100, 150, "All"]]
      } );
    } );
    // Delete database value code
    $(document).on('click','.delete',function(){
      var element = $(this);
      var del_id = element.attr('data-id');
      var info = 'id=' + del_id;
      if(confirm("Are you sure you want to delete this?")) {
        $.ajax({
          type: "POST",
          url: "ajaxdelete.php",
          data: info,
          success: function(){
          }
        });
        $(this).parents("tr").animate({ backgroundColor: "#003" }, "slow")
        .animate({ opacity: "hide" }, "slow");
      }
      return false;
    });
  </script>
  <!-- Edit database value -->
  <script>
  function showEdit(editableObj) {
    $(editableObj).css("background","#FFF");
  }

  function saveToDatabase(editableObj,column,id) {
    $(editableObj).css("background","#FFF url(loaderIcon.gif) no-repeat right");
    $.ajax({
      url: "ajaxedit.php",
      type: "POST",
      data:'column='+column+'&editval='+editableObj.innerHTML+'&id='+id,
      success: function(data){
        $(editableObj).css("background","#E8E8E8");
      }
    });
  }
  </script>
  <!-- Remove image -->
  <script>
    $(document).on('click','.delImg',function(){

      var element = $(this);
      var del_id = element.attr('data-id');
      var info = 'id=' + del_id;
      if(confirm("Are you sure you want to delete this image?")) {
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
	<div class="container-fluid" style="margin-top:70px;">
	  <div class="row">
	    <div class="col-sm-12">
        <?php
          $sql = "SELECT item.name, item.id, item.title, item.surname, item.other, item.note, item.image, category.category
            FROM item LEFT JOIN category ON item.category=category.id
            ORDER BY surname ASC, title ASC";
          $result = $con->query($sql);

          if ($result->num_rows > 0) {
        ?>
        <div class="table-responsive">
          <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>ID</th>
                <th>Surname</th>
                <th>Name</th>
                <th>Title</th>
                <th>Category</th>
                <th>Language1</th>
                <th>Language2</th>
                <th>Other authors</th>
                <th>Note</th>
                <th>Edit</th>
                <th>Delete</th>
                <th>Image</th>
              </tr>
            </thead>
            <tbody>
              <?php
                // output data of each row
                while($row = $result->fetch_assoc()) {
                  $currentItem = $row["id"];
              ?>
                <tr>
                  <td><?php echo $row["id"] ?></td>
                  <td contenteditable="true" onBlur="saveToDatabase(this,'surname','<?php echo $row["id"] ?>')" onClick="showEdit(this);"><?php echo $row["surname"] ?></td>
                  <td contenteditable="true" onBlur="saveToDatabase(this,'name','<?php echo $row["id"] ?>')" onClick="showEdit(this);"><?php echo $row["name"] ?></td>
                  <td contenteditable="true" onBlur="saveToDatabase(this,'title','<?php echo $row["id"] ?>')" onClick="showEdit(this);"><?php echo $row["title"] ?></td>
                  <td><?php echo $row["category"] ?></td>

                    <?php
                      $sql2 =  "SELECT language.id AS langId, language.language
                      FROM item
                      LEFT JOIN item_language ON item.id = item_language.Item_Id
                      LEFT JOIN language ON item_language.Language_Id = language.id
                      WHERE item.id = $currentItem";
                      $result2 = $con->query($sql2);
                      if ($result2->num_rows == 1) {
                        $row2 = $result2->fetch_array();
                          echo "<td>" . $row2['language'] . "</td><td></td>";
                      } else if ($result2->num_rows == 2) {
                        while($row2 = $result2->fetch_array()) {
                          echo "<td>" . $row2['language'] . "</td>";
                        }
                      } else {
                        echo ("<td></td><td></td>");
                      } ?>

                  <td contenteditable="true" onBlur="saveToDatabase(this,'other','<?php echo $row["id"] ?>')" onClick="showEdit(this);"><?php echo $row["other"] ?></td>
                  <td contenteditable="true" onBlur="saveToDatabase(this,'note','<?php echo $row["id"] ?>')" onClick="showEdit(this);"><?php echo $row["note"] ?></td>
                  <td><?php echo "<a href='edit.php?id=".$row['id']."'>Edit</a>" ?></td>
                  <td><a data-id="<?php echo $row['id'] ?>" class="delete" href="#">Delete</a></td>
                  <td>
                    <div id="deleteimg">
                      <?php if (!empty($row["image"])) { ?>
                        <img height="50" src="uploads/<?php echo $row["image"] ?>">
                      <?php } else { ?>
                        <!-- <img src="uploads/no_img.jpg"> -->
                        <?php } ?>
                        <?php if (!empty($row["image"])) { ?>
                        <a data-id="<?php echo $row['id'] ?>" class="delImg" href="#">Delete</a>
                        <?php } ?>
                      </div>
                    </td>
                </tr>
              <?php
                }
                } else {
                  echo "0 results";
                }
                $con->close();
              ?>
            </tbody>
          </table>
        </div>
	    </div>
	  </div>
	</div>

  <script src="js/bootstrap.min.js"></script>
</body>
</html>
