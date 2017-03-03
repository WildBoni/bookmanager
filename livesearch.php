<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */

session_start();
include_once 'dbconnect.php';

if (!isset($_SESSION['userSession'])) {
  header("Location: index.php");
}
// Escape user inputs for security
$term = mysqli_real_escape_string($con, $_REQUEST['term']);

if(isset($term)){
    // Attempt select query execution
    $sql = "SELECT * FROM item WHERE name LIKE '%" . $term . "%' OR surname LIKE '%" . $term . "%' OR title LIKE '%" . $term . "%'";
    if($result = mysqli_query($con, $sql)){
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_array($result)){
                echo "<p>" . $row['name'] . " - " . $row['surname'] . " - " . $row['title'] ."</p>";
            }
            // Close result set
            mysqli_free_result($result);
        } else{
            echo "<p>No matches found</p>";
        }
    } else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
    }
}

// close connection
mysqli_close($con);
?>
