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
  <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" >
	<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
  <script>
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
	<div class="container-fluid">
	  <div class="row">
	    <div class="col-sm-12">
        <?php
          $sql = "SELECT item.name, L1.language AS language1, L2.language AS language2, item.id, item.title, item.surname, item.other, item.note, category.category
            FROM item LEFT JOIN category ON item.category=category.id
            LEFT JOIN language L1 ON (L1.Id = item.language1)
            LEFT JOIN language L2 ON (L2.Id = item.language2)
            ORDER BY surname ASC, title ASC";
          $result = $con->query($sql);

          if ($result->num_rows > 0) {
        ?>
        <div class="table-responsive">
          <table class="table">
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
                </tr>
              <?php
                  }
                } else {
                  echo "0 results";
                }
              ?>
            </tbody>
          </table>
          <?php
            if ($result=mysqli_query($con,$sql)) {
              // Return the number of rows in result set
              $rowcount=mysqli_num_rows($result);
              printf("Your library has <strong>%d</strong> items.\n",$rowcount);
              // Free result set
              mysqli_free_result($result);
              }
            $con->close();
          ?>
          </div>
	    </div>
	  </div>
	</div>



<script src="js/jquery-1.10.2.js"></script>
<script src="js/bootstrap.min.js"></script>

</body>
</html>
