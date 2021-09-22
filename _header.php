<?php 
session_start();
if(isset($_session['loggedin']) && $_SESSION== true){


  
}
echo '  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container-fluid">
  <a class="navbar-brand" href="index.php">DIT CAQ</a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="about.php">about</a>
      </li>
      <li class="nav-item">
        <a class="nav-link " href="contact.php"  aria-current="page">contact</a>
      </li>
    </ul>';

    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']== true){

      echo '  <form class="d-flex my-2" method="get" action="search.php">
              <input class="form-control me-2" name ="search" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success me-2" type="submit">Search</button>
              <p class="text-light my-0 mx-2">Welcome '.$_SESSION['useremail'].'</p>
              <a href="_logout.php" class="btn btn-primary me-2 " >logout</a>
              </form>';
              
  
    }

    else{
      echo'    <form class="d-flex my-2" method="get" action="search.php">
      <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success me-2" type="submit">Search</button>
      </form>
  
      <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#loginModal">login</button>
      <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#signupModal">signup</button>';

    }


    
 echo ' </div>
        </div>
        </nav>';

include '_loginModal.php';
include '_signupModal.php';
if(isset($_GET['signupsuccess']) && $_GET['signupsuccess']== "true"){

  echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
  <strong>Success
  !</strong> you can now login.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
if(isset($_GET['error'])&& $_GET['error']=="email already in use"){
  echo '<div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
  <strong>email allready exist</strong>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
if(isset($_GET['error'])&& $_GET['error']=="passwords do not match"){
  echo '<div class="alert alert-danger alert-dismissiable fade show my-0" role="alert">
  <strong>password do not match</strong>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
if(isset($_GET['loginError'])&& $_GET['loginError']=="password do not match"){
  echo '<div class="alert alert-danger alert-dismissiable fade show my-0" role="alert">
  <strong>Wrong password</strong>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
if(isset($_GET['loginError'])&& $_GET['loginError']=="email do not found"){
  echo '<div class="alert alert-danger alert-dismissiable fade show my-0" role="alert">
  <strong>Invalid Email</strong>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
if(isset($_GET['loginError'])&& $_GET['loginError']=="false"){
  echo '<div class="alert alert-success alert-dismissiable fade show my-0" role="alert">
  <strong>logged in</strong>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
?>