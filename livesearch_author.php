<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */

session_start();
include_once 'dbconnect.php';

// if (!isset($_SESSION['userSession'])) {
//   header("Location: index.php");
// }
// Escape user inputs for security
$term = mysqli_real_escape_string($con, $_REQUEST['term']);

if(isset($term)){
    // Attempt select query execution
    $sql6 = "SELECT * FROM author WHERE name LIKE '%" . $term . "%' OR surname LIKE '%" . $term . "%'";
    if($result6 = mysqli_query($con, $sql6)){
        if(mysqli_num_rows($result6) > 0){
          echo("<div class='result'>
          <fieldset id='attivo'>
            <legend>Author:</legend>
            <ul style='list-style-type:none; overflow-y:scroll; height:150px;'>");
            while($row6 = mysqli_fetch_array($result6)){
              echo "<li><input type='radio' name='checkAttivo[]' class='checkName' id='checkAttivo' value=\"{$row6['id']}\"/>";
              echo "<span>". $row6['surname'] ." | " .$row6['name'] ."</span>";
              echo "</li>";
            }
          echo("</ul>
          </fieldset>");
            // Close result set
            mysqli_free_result($result6);
          echo("</div>");
        } else{
            echo '<script>autoreID="";</script><div id="notFound" style="background-color:#e7e7e7;">
            				<div class="row">
            					<div class="col-sm-12">
            						NOT FOUND? Insert it!
            					</div>
            					<div class="col-sm-6">
            			      <label for="name">Name:</label>
            			      <input type="text" id="name" class="form-control" name="name">
            			    </div>
            					<div class="col-sm-6">
            			      <label for="surname">Surname:</label>
            			      <input type="text" id="surname" class="form-control" name="surname">
            			    </div>
            				</div>
            			</div>';
        }
    } else{
        echo "ERROR: Could not able to execute $sql6. " . mysqli_error($con);
    }
}

// close connection
mysqli_close($con);
?>
