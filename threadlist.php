<?php
       include '_header.php';
       include '_dbconnect.php';
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

    <?php

              $id= $_GET['catid'];
              $sql = "SELECT * FROM `categories` WHERE category_id=$id";
              $result = mysqli_query($conn,$sql);
              while($row = mysqli_fetch_assoc($result)){
                $catname = $row['category_name'];
                $catdesc = $row['category_description'];
            
            
            }

                ?>

    <?php
                $showAlert = false; 
                $method = $_SERVER['REQUEST_METHOD'];
                if($method=='POST'){
                    //Insert into thread db
                    $th_title = $_POST['title'];
                    $th_desc = $_POST['desc'];

                    $th_title = str_replace("<", "&lt;", $th_title);
                    $th_title = str_replace(">", "&gt;", $th_title);
                    $th_desc = str_replace("<", "&lt;", $th_desc);
                    $th_desc = str_replace(">", "&gt;", $th_desc);
                   
                    $sno=$_POST["sno"];
                    $sql = "INSERT INTO `threads` (`thread_id`, `thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES (NULL, '$th_title', '$th_desc', '$id', '$sno', current_timestamp())";
                    $result = mysqli_query($conn,$sql);
                    $showAlert = true;
                    if($showAlert){
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success</strong> Your thread has been posted!! please wait for community to respond.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>';
                    }

                }

     ?>



    <!-- category container starts from here -->
    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4">welcome to <?php echo  $catname ;?> forum</h1>
            <p class="lead"><?php echo  $catdesc ;?></p>
            <hr class="my-4">
            <p> No Spam / Advertising / Self-promote in the forums. <br>
                Do not post copyright-infringing material. <br>
                Do not post “offensive” posts, links or images. <br>
                Do not cross post questions. <br>
                Remain respectful of other members at all times.</p>
            <p class="lead">
                <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
            </p>
        </div>
    </div>

    <?php

    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']== true){
    echo'<div class="container">
        <h1 class="py-2">Start a discussion</h1>

        <form action=" ' .$_SERVER["REQUEST_URI"] .' " method="post">
            <div class="form-group">
                <label for="exampleInputEmail1">Problem Title</label>
                <input type="title" class="form-control" id="title" name="title" aria-describedby="emailHelp"
                    placeholder="Enter Title">
                <small id="emailHelp" class="form-text text-muted">keep your title as short and crisp as
                    possible.</small>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Elaborate your problem</label>
                <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
                <input type="hidden" name="sno" value="'.$_SESSION["sno"] .'"
            </div>
            <button type="submit" class="btn btn-primary mt-2">Submit</button>
        </form>


    </div>';

    }
    else{

        echo '<div class="jumbotron jumbotron-fluid">
        <div class="container">
          <h1 class="display-4">Start a discussion</h1>
          <p class="lead">Please login to start a dicussion.</p>
        </div>
      </div>';
    }



    ?>

    <div class="container" id="ques">
        <h1 class="py-2">browse questions</h1>

<!--  -->
        <?php

        $id= $_GET['catid'];
        $sql = "SELECT * FROM `threads` WHERE thread_cat_id=$id";
        $result = mysqli_query($conn,$sql);
        $noresult= true;
        while($row = mysqli_fetch_assoc($result)){
                $noresult = false;
                $id =  $row['thread_id'];
                $title = $row['thread_title'];
                $desc = $row['thread_desc'];
                $thread_time = $row['timestamp'];
                $thread_user_id = $row['thread_user_id'];
                $sql2 = "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
                $result2 = mysqli_query($conn,$sql2);
                $row2 = mysqli_fetch_assoc($result2);
                


        
        echo ' <div class="media my-3">
            <img src="img/userdefault.png" width="50px" class="d-inline mr-3" alt="Generic placeholder image" >
            <div class="media-body">
            <p class="font-weight-bold my-0 d-inline">'.$row2['user_email'].' at '.$thread_time.' </p>
                <h5 class="mt-0"><a class="text-dark" href="thread.php?threadid=' . $id. '">' . $title . '</a></h5>
                ' . $desc . '
            </div>
        </div>';
        }
        if($noresult){
            echo '<div class="jumbotron jumbotron-fluid">
            <div class="container">
              <p class="display-4"> No Threads Found</p>
              <p class="lead"><b> be the first person to ask the question</b></p>
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