<?php   
 $showError = "false";
if($_SERVER["REQUEST_METHOD"]== "POST"){

    include '_dbconnect.php';
    $email = $_POST['loginEmail'];
    $pass = $_POST['loginPass'];
   

    $sql="select * from `users` where user_email='$email'";
    $result = mysqli_query($conn,$sql);
    $numRows = mysqli_num_rows($result);
    if($numRows==1){
            $row = mysqli_fetch_assoc($result);
          
            
            if(password_verify($pass, $row['user_pass'])){
                session_start();
                $_SESSION['loggedin']= true;
                $_SESSION['sno'] = $row['sno'];
                $_SESSION['useremail'] = $email;
             
                header("location: index.php");
                exit();

            }

            else{
                    $showError="password do not match";
                    header("location: index.php?loginError=$showError");

                }
            }
        
            
    else{

        $showError="email do not found";
        header("location: index.php?loginError=$showError");
    }        

        }


?>