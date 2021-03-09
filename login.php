<?php
require ('header.php');
?>
<?php
  require ("db_connect.php");

        $email = $emailErr = $passwordErr = $loginErr = $password = "";
        $not_inserting = false;
     if(isset($_POST["finallogin"])){
    

              function validate($data){
              $data = trim($data);
              $data = htmlspecialchars($data);
              $data = stripslashes($data);
              return $data;
              }

                  if(empty($_POST["loginemail"])) {
                     $emailErr = "Email is required";
                     $not_inserting = true;
                  } else {
                     $email = validate($_POST["loginemail"]);
                     $email = $conn ->real_escape_string($email);
                        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                           $emailErr = "Invalid email format";
                           $not_inserting = true;
                           echo 'some error';
                        }
                  }

              $password = $_POST["loginpassword"];
              $password = $conn ->real_escape_string($password);
                   if(empty($password)) {
                   $loginErr = "password is required";
                   $not_inserting = true;
                    } 

                   if($not_inserting == false){

                          
                          $sql = "SELECT * FROM user_all_info WHERE user_emailid = '$email'";
                          $result = $conn->query($sql);  
                               if($result->num_rows == 1) { 
       
                                    while($row = $result->fetch_assoc()){
                                       $firstname = $row['user_firstname'];
                                       $lastname  = $row['user_lastname'];
                                       $uniqueid = $row['user_id'];
            
                                        if(password_verify($password,$row['user_password'])){
           
                                                session_start();
                                                $_SESSION['loggedin']= true;
                                                $_SESSION['useremail']= $email;
                                                $_SESSION['uniqueid']=$uniqueid;
                                                $_SESSION['fullname']= $firstname ." " . $lastname ;
             
                                                header("Location: afterlogin.php?loginprocess=true");
        
                                        }else{
                                            
                                                 echo '
                                                    <div class="alert alert-danger alert-dismissible fade show">
                                                   <button type="button" class="close" data-dismiss="alert">×</button>
                                                   <strong>Password doesnot match !</strong> Check your password again.
                                                   </div>';
                                             }
                                   }

                                }else{
                                   echo '
                                     <div class="alert alert-danger alert-dismissible fade show">
                                     <button type="button" class="close" data-dismiss="alert">×</button>
                                     <strong>first make an account !</strong> 
                                     </div>';
                                    }
    
                    }
         }

?>


            <form action="" method="post">
                <div class="modal-body row">
                    <div class="form-group form-group col-md-6 offset-md-3">
                        <label for="loginemail">Email address</label>
                        <input type="text" class="form-control" id="loginemail" name="loginemail"
                            aria-describedby="emailHelp">
                        <span class="text-danger"><?php echo $emailErr;?></span>
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone
                            else.</small>
                    </div>
                    <div class="form-group form-group col-md-6 offset-md-3">
                        <label for="loginpassword"> Password</label>
                        <input type="password" class="form-control" id="loginpassword" name="loginpassword">
                        <span class="text-danger"><?php echo $loginErr;?></span>
                    </div>
                </div>
                <div class="form-group form-group col-md-6 offset-md-3">
                    <button type="submit" id="finallogin" name="finallogin" class="btn btn-primary">Log in</button>
                </div>

            </form>
        </div>
    </div>
</div>
<?php
            require('footer.php');
?>
<script>
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}
</script>