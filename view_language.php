<?php
  session_start();
  include_once 'dbconnect.php';

  if (!isset($_SESSION['userSession'])) {
    header("Location: index.php");
  }

  $query = $con->query("SELECT * FROM users WHERE id=".$_SESSION['userSession']);
  $userRow=$query->fetch_array();

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
        "columnDefs": [
          { "width": "5%", "targets": 0 }
        ]
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
          url: "ajaxdelete_language.php",
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
      url: "ajaxedit_language.php",
      type: "POST",
      data:'column='+column+'&editval='+editableObj.innerHTML+'&id='+id,
      success: function(data){
        $(editableObj).css("background","#E8E8E8");
      }
    });
  }
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
          $sql = "SELECT language.id, language.language
            FROM language";
          $result = $con->query($sql);

          if ($result->num_rows > 0) {
        ?>
        <div class="table-responsive">
          <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>ID</th>
                <th>Language</th>
                <th>Edit</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
              <?php
                // output data of each row
                while($row = $result->fetch_assoc()) {
              ?>
                <tr>
                  <td><?php echo $row["id"] ?></td>
                  <td contenteditable="true" onBlur="saveToDatabase(this,'language','<?php echo $row["id"] ?>')" onClick="showEdit(this);"><?php echo $row["language"] ?></td>
                  <td><?php echo "<a href='edit_language.php?id=".$row['id']."'>Edit</a>" ?></td>
                  <td><a data-id="<?php echo $row['id'] ?>" class="delete" href="#">Delete</a></td>
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
