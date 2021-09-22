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
       
        <script src="jquery-3.3.1.js" type="text/javascript"></script>

        <script src="script.js" type="text/javascript"></script>
    
    <title>DIT CAQ</title>
</head>

<body>

            <?php

              $thread_id= $_GET['threadid'];
              $sql = "SELECT * FROM `threads` WHERE thread_id=$thread_id";
              $result = mysqli_query($conn,$sql);
              
              
              
              while($row = mysqli_fetch_assoc($result)){
                $title = $row['thread_title'];
                $desc = $row['thread_desc'];
                 //query for user postest question  
               $thread_user_id = $row['thread_user_id'];
               $sql2 = "SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
               $result2 = mysqli_query($conn,$sql2);
               $row2 = mysqli_fetch_assoc($result2);
               $posted_by = $row2['user_email'];
                
               

            
            }

                ?>


            <?php
                $showAlert = false; 
                $method = $_SERVER['REQUEST_METHOD'];
                if($method=='POST'){
                    //Insert into thread db
                    $comment = $_POST['comment'];
                    $comment = str_replace("<", "&lt;", $comment);
                    $comment = str_replace(">", "&gt;", $comment);
                    $sno=$_POST["sno"];
                    $sql = "INSERT INTO `comments` (`comment_id`, `comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES (NULL, '$comment', '$thread_id', '$sno', current_timestamp()) ";
                    $result = mysqli_query($conn,$sql);
                    $showAlert = true;
                    if($showAlert){
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success</strong> Your Comment has been posted!!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>';
                    }

                }

            ?>





<!-- category container starts from here -->
    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4"> <?php echo  $title ;?></h1>
            <p class="lead"><?php echo  $desc ;?></p>
            <hr class="my-4">
            <p> No Spam / Advertising / Self-promote in the forums. <br>
                Do not post copyright-infringing material. <br>
                Do not post “offensive” posts, links or images. <br>
                Do not cross post questions. <br>
                Remain respectful of other members at all times.</p>
            <p>
              <b>posted by  <?php  echo $posted_by  ?></b>  
            </p>
        </div>
    </div>
   

    <?php

if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']== true){
echo' <div class="container">
<h1 class="py-2">Post a Comment</h1>

<form action=" '. $_SERVER['REQUEST_URI'].' " method="post">
   
    <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Type your comment</label>
        <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
        <input type="hidden" name="sno" value="'.$_SESSION["sno"] .'"
    </div>
    <button type="submit" class="btn btn-primary mt-2">Post Comment</button>
</form>


</div>';

}
else{

    echo '<div class="jumbotron jumbotron-fluid">
    <div class="container">
      <h1 class="display-4">Post comment</h1>
      <p class="lead">Please login to post a comment.</p>
    </div>
  </div>';
}



?>

   
    <div class="container">
        <h1 class="py-2">dicussion</h1>
      
      
        
        
        <?php

        $thread_id= $_GET['threadid'];
        $sql = "SELECT * FROM `comments` WHERE thread_id=$thread_id";
        $result = mysqli_query($conn,$sql);
        $noresult = true;
        while($row = mysqli_fetch_assoc($result)){
        $noresult = false;
        $comment_id =  $row['comment_id'];
        $content = $row['comment_content'];
        $comment_time = $row['comment_time'];

        $comment_by = $row['comment_by'];
        $sql2 = "SELECT user_email FROM `users` WHERE sno='$comment_by'";
        $result2 = mysqli_query($conn,$sql2);
        $row2 = mysqli_fetch_assoc($result2);
        $userid = $_SESSION["sno"]; 
        





        $type = -1;

        // Checking user status
        $status_query = "SELECT count(*) as cntStatus,type FROM votes WHERE userid=".$userid." and comment_id=".$comment_id;
        $status_result = mysqli_query($conn,$status_query);
        $status_row = mysqli_fetch_array($status_result);
        $count_status = $status_row['cntStatus'];
        if($count_status > 0){
            $type = $status_row['type'];
        }

        // Count post total likes and unlikes
        $like_query = "SELECT COUNT(*) AS cntLikes FROM votes WHERE type=1 and comment_id=".$comment_id;
        $like_result = mysqli_query($conn,$like_query);
        $like_row = mysqli_fetch_array($like_result);
        $total_likes = $like_row['cntLikes'];

        $unlike_query = "SELECT COUNT(*) AS cntUnlikes FROM votes WHERE type=0 and comment_id=".$comment_id;
        $unlike_result = mysqli_query($conn,$unlike_query);
        $unlike_row = mysqli_fetch_array($unlike_result);
        $total_unlikes = $unlike_row['cntUnlikes'];
        $color="color: #ffa449";

        echo '

         <div class="media my-3">
            <img src="img/userdefault.png" width="50px" class="d-felx mr-3" alt="Generic placeholder image" >
            <div class="media-body">
               <p class="font-weight-bold my-0">'.$row2['user_email'].' 
               at '.$comment_time.' </p>
               ' .$content. '
               <div class="post-action" method="POST">

                <input type="button" value="Upvote" id="like_'.$comment_id.' " class="like" style='.$color.'" '. (($type=='1')?''.$color="color: #ffa449;".'':"") .'" />&nbsp;(<span id="like_'. $comment_id .'">'. $total_likes .'</span>)&nbsp;

                <input type="button" value="DownVote" id="unlike_'.$comment_id.'" class="unlike" style='.$color.'" '. (($type=='0')?''.$color="color: #DBAD6A;".'':"") .'" />&nbsp;(<span id="unlike_'. $comment_id .'">'.$total_unlikes.'</span>)

            </div>
            </div>
        </div>';
        }
        if($noresult){
            echo '<div class="jumbotron jumbotron-fluid">
            <div class="container">
              <p class="display-4"> No comments Found</p>
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