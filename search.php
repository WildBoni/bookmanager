<?php
  session_start();
  include_once 'dbconnect.php';

  if (isset($_SESSION['userSession'])) {
    $query = $con->query("SELECT * FROM users WHERE id=".$_SESSION['userSession']);
    $userRow=$query->fetch_array();
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>BKMNGR</title>
<script src="//code.jquery.com/jquery-1.12.3.js"></script>
<link rel="stylesheet"  href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<!-- <link rel="stylesheet"  href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script> -->
<meta content="width=device-width, initial-scale=1.0" name="viewport" >

<style type="text/css">
    /* Formatting search box */
    .search-box{
        width: 300px;
        position: relative;
        display: inline-block;
        font-size: 14px;
        margin-top: 100px;
    }
    .search-box input[type="text"]{
        height: 32px;
        padding: 5px 10px;
        border: 1px solid #CCCCCC;
        font-size: 14px;
    }
    .result{
    }

    /* Formatting result items */
    .result p{
        margin: 0;
        padding: 7px 10px;
        border: 1px solid #CCCCCC;
    }
    .result p:hover{
        background: #f2f2f2;
    }
</style>

<script type="text/javascript">
$(document).ready(function(){
    $('.search-box input[type="text"]').on("keyup input", function(){
        /* Get input value on change */
        var inputVal = $(this).val();
        var resultDropdown = $(".result");
        if(inputVal.length){
            $.get("livesearch.php", {term: inputVal}).done(function(data){
                // Display the returned data in browser
                resultDropdown.html(data);
            });
        } else{
            resultDropdown.empty();
        }
    });

    // Set search input value on click of result item
    // $(document).on("click", ".result p", function(){
    //     $(".search-box").find('input[type="text"]').val($(this).text());
    //     $(".result").empty();
    // });
});
</script>
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12 text-center">
        <?php
          include 'header.php';
        ?>
        <div class="search-box">
            <input type="text" autocomplete="off" placeholder="Search item..." />
        </div>
      </div>
    </div>
    <div class="row result">
      <div class="col-sm-12 text-center">
      </div>
      <div class="col-sm-12 text-center">
      </div>
    </div>
  </div>
  <script src="js/bootstrap.min.js"></script>
</body>
</html>
