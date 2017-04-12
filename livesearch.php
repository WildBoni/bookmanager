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
    //$sql = "SELECT * FROM author WHERE name LIKE '%" . $term . "%' OR surname LIKE '%" . $term . "%' OR SELECT title FROM item WHERE title LIKE '%" . $term . "%' ";

    $sql = "SELECT author.name, author.surname, item.title, item.id
      FROM item
        LEFT JOIN item_author ON item.id = item_author.ItemId
        LEFT JOIN author ON item_author.AuthorID = author.id
          WHERE author.name like '%" . $term . "%'
            OR author.surname like '%" . $term . "%'
            OR item.title like '%" . $term . "%'";
    if($result = mysqli_query($con, $sql)){
        if(mysqli_num_rows($result) > 0){
          echo("<div class='totale text-center'>Total results: <strong>".mysqli_num_rows($result)."</strong></div><div class='result'>");
            while($row = mysqli_fetch_array($result)){
                echo "<p>" . $row['name'] . " | <strong>" . $row['surname'] . "</strong> | " . $row['title'] . "";
                if(isset($_SESSION['userSession'])!="") {
                  echo "| <a href='edit.php?id=".$row['id']. "'>Edit Item</a>";
                 }
                 echo "</p>";
            }
            // Close result set
            mysqli_free_result($result);
          echo("</div>");
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
