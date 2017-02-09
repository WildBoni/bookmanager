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
</head>
<body>
  <?php
    include 'header.php';
  ?>
	<div class="container-fluid" style="margin-top:70px;">
	  <div class="row">
	    <div class="col-sm-12">
        <?php
          $sql = "SELECT item.name, L1.language AS language1, L2.language AS language2,
            item.id, item.title, item.surname, item.other, item.note, item.image, category.category
            FROM item LEFT JOIN category ON item.category=category.id
            LEFT JOIN language L1 ON (L1.Id = item.language1)
            LEFT JOIN language L2 ON (L2.Id = item.language2)
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
              ?>
                <tr>
                  <td><?php echo $row["id"] ?></td>
                  <td><?php echo $row["surname"] ?></td>
                  <td><?php echo $row["name"] ?></td>
                  <td><?php echo $row["title"] ?></td>
                  <td><?php echo $row["category"] ?></td>
                  <td><?php echo $row["language1"] ?></td>
                  <td><?php echo $row["language2"] ?></td>
                  <td><?php echo $row["other"] ?></td>
                  <td><?php echo $row["note"] ?></td>
                  <td><?php echo "<a href='edit.php?id=".$row['id']."'>Edit</a>" ?></td>
                  <td><a data-id="<?php echo $row['id'] ?>" class="delete" href="#">Delete</a></td>
                  <td>
                    <?php if (!empty($row["image"])) { ?>
                      <img src="uploads/<?php echo $row["image"] ?>">
                    <?php } else { ?>
                      <!-- <img src="uploads/no_img.jpg"> -->
                      <?php } ?>
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
