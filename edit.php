<?php

include_once 'dbconnect.php';

$UID = (int)$_GET['id'];
$sql ="SELECT * FROM item WHERE id = '$UID'";

$result = $con->query($sql);

if ($result->num_rows > 0) {
     // output data of each row
     while($row = $result->fetch_assoc()) {
	$name = $row['name'];
    $title = $row['title'];
    echo "Ready to edit";
	} 
}else {
    echo 'No entry found. <a href="javascript:history.back()">Go back</a>';
}
?>
<form action="update.php" method="post">
<input type="hidden" name="ID" value="<?=$UID;?>">
Name: <input type="text" name="name" value="<?=$name?>"><br>
Title: <input type="text" name="title" value="<?=$title?>"><br>
<input type="Submit">
</form>
<?php
$con->close();
?>