<?php
       include '_dbconnect.php';
       include '_header.php';
      ?>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <title>DIT CAQ</title>
</head>

<body>
   
<!-- seacrh result -->

<div class="container my-3" id="maincontainer">
    <h1 class="my-3">search result for <em>"<?php echo $_GET['search']; ?> "</em> </h1>

<?php 
$noresults= true;
$query = $_GET['search'];
$sql ="SELECT * FROM threads WHERE MATCH(thread_title,thread_desc) AGAINST('$query')";
$result =mysqli_query($conn,$sql);
while($row = mysqli_fetch_assoc($result)){
    $noresults= false;
    $title = $row['thread_title'];
    $desc = $row['thread_desc'];
    $thread_id= $row['thread_id'];
    $url = "thread.php?threadid=".$thread_id;



   echo ' <div class="result">
     <h3 class="my-3"><a href="' .$url. '" class="text-dark ">  '.$title.' </a></h3>
     <p>'.$desc.' </p>
    
    </div>
    </div>';
    }
    if($noresults){
        echo ' <div class="jumbotron jumbotron-fluid">
        <div class="container">
          <p class="display-4"> No results Found</p>
          <p class="lead"><b>
          Suggestions:<br>
          Make sure that all words are spelled correctly.<br>
          Try different keywords.<br>
          Try more general keywords.</b> </p>
        </div>
      </div>';



    }
?>





        <!-- remove later to ceheck alingment

        <div class="media my-3">
            <img src="img/userdefault.png" width="20px" class="d-felx mr-3" alt="Generic placeholder image" >
            <div class="media-body">
                <h5 class="mt-0">Media heading</h5>
                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus
                odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate
                fringilla. Donec lacinia congue felis in faucibus.
            </div>
        </div> -->
    </div>


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
    -->
</body>

</html>