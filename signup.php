<?php
require ('header.php');
require ('db_connect.php');
?>

<?php
    $email = $firstname = $lastname = $lastnameErr = $emailErr = $firstnameErr = $emailerror =  $data = $passwordErr = $cpasswordErr = $signuppassword = $signupcpassword = "";
    $not_inserting = false;
  if(isset($_POST["signup"])){
     function validate($data){
        $data = trim($data);
        $data = htmlspecialchars($data);
        $data = stripslashes($data);
        return $data;
      }
     if(empty($_POST["signupfirstname"])){
         $firstnameErr= "cannot set empty" ;
         $not_inserting = true;
     }
     else{
         $firstname = validate($_POST["signupfirstname"]);
         $firstname = $conn ->real_escape_string($firstname);
             if (!preg_match("/^[a-zA-Z-']*$/",$firstname)) {
                  $firstnameErr = "Only letters and white space allowed";
                  $not_inserting = true;
           }
        }
     if(empty($_POST["signuplastname"])){
          $lastnameErr= "cannot set empty" ;
          $not_inserting = true;
     }
     else{
         $lastname = validate($_POST["signuplastname"]);
         $lastname = $conn ->real_escape_string($lastname);
             if (!preg_match("/^[a-zA-Z-']*$/",$lastname)) {
                $lastnameErr = "Only letters and white space allowed";
                $not_inserting = true;
      }
     }
      if(empty($_POST["emailid"])) {
           $emailErr = "Email is required";
           $not_inserting = true;
      } else {
           $email = validate($_POST["emailid"]);
           $email = $conn ->real_escape_string($email);
           if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
               $emailErr = "Invalid email format";
               $not_inserting = true;
        }
      }
      if(!empty($_POST["signuppassword"]) && ($_POST["signuppassword"] == $_POST["signupcpassword"])) {
        $signuppassword = validate($_POST["signuppassword"]);
        $signupcpassword = validate($_POST["signupcpassword"]);
        if (strlen($_POST["signuppassword"]) < 7) {
            $passwordErr = "Your Password Must Contain At Least 8 Characters!";
            echo strlen($_POST["signuppassword"]);
            $not_inserting = true;
        }
        elseif(!preg_match("#[0-9]+#",$signuppassword)) {
            $passwordErr = "Your Password Must Contain At Least 1 Number!";
            $not_inserting = true;
        }
        elseif(!preg_match("#[A-Z]+#",$signuppassword)) {
            $passwordErr = "Your Password Must Contain At Least 1 Capital Letter!";
            $not_inserting = true;
        }
        elseif(!preg_match("#[a-z]+#",$signuppassword)) {
            $passwordErr = "Your Password Must Contain At Least 1 Lowercase Letter!";
            $not_inserting = true;
        }
      }
       elseif(!empty($_POST["signupcpassword"])) {
       $cpasswordErr = "Please Check You've Entered Or Confirmed Your Password!";
       $not_inserting = true;
      } else {
        $passwordErr = "Please enter password   ";
        $not_inserting = true;
    }
?>
<?php
        if($not_inserting == false){
               $sql = "SELECT user_emailid   FROM user_all_info WHERE user_emailid = '$email'";
               $result = $conn->query($sql);  
                      if ($result->num_rows ==  0) {  
                      $hash_password = password_hash($signuppassword,PASSWORD_DEFAULT);
                            $sql = "INSERT INTO user_all_info( user_firstname, user_lastname, user_emailid, user_password )VALUES ('$firstname','$lastname','$email','$hash_password')";
                              if($conn->query($sql) === TRUE) {
           
                                   echo "<h3> you (".$firstname ." ".$lastname ." ) have successfully submitted your form </h3>";
?>
<?php 
                                    $firstname = $lastname = $email = $company = $position = $phoneno = $gender = $state = $country ="";
                                }else{
                                     echo "Error: " . $sql . "<br>" . $conn->error;
                                }
                                 mysqli_close($conn);
                                  
                        }else{
                         $emailErr = "Email already exist";
                        }
        }else{
             echo "<h2 class='text-danger text-center'>Some Error has been occured</h2>";
         }
    }   
?>

            <form action="" method="POST">
                <div class="modal-body  row">
                    <div class="form-group col-md-6 offset-md-3">
                        <label for="signupfirstname">First name</label><span class="mx-4 text-danger">*</span>
                        <input type="text" class="form-control" id="signupfirstname" name="signupfirstname"
                            aria-describedby="emailHelp"  value="<?php echo $firstname;?>">
                        <span class="text-danger"><?php echo $firstnameErr;?></span>
                    </div>
                    <div class="form-group col-md-6 offset-md-3">
                        <label for="signuplastname">Last name</label><span class="mx-4 text-danger">*</span>
                        <input type="text" class="form-control" id="signuplastname" name="signuplastname"
                            aria-describedby="emailHelp" value="<?php echo $lastname ;?>" >
                        <span class="text-danger"><?php echo $lastnameErr;?></span>

                    </div>
                    <div class="form-group col-md-6 offset-md-3">
                        <label for="signupemail">Email address</label><span class="mx-4 text-danger">*</span>
                        <input type="email" class="form-control" id="signupemail" name="emailid"
                            aria-describedby="emailHelp"  value="<?php echo $email;?>" >
                        <span class="text-danger"><?php echo $emailErr;?></span>
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone
                            else.</small>
                    </div>
                    <div class="form-group col-md-6 offset-md-3">
                        <label for="signuppassword"> Password</label><span class="mx-4 text-danger">*</span>
                        <input type="password" class="form-control" id="signuppassword" name="signuppassword">
                        <span class="text-danger"><?php echo $passwordErr;?></span>
                        <small id="emailHelp" class="form-text text-muted">password must contain at least one small
                            character , one large character , one word and above 7 in length</small>
                    </div>
                    <div class="form-group col-md-6 offset-md-3">
                        <label for="signupcpassword">Confirm Password</label><span class="mx-4 text-danger">*</span>
                        <input type="password" class="form-control" id="signupcpassword" name="signupcpassword">
                        <span class="text-danger"><?php echo $cpasswordErr;?></span>
                        <small id="emailHelp" class="form-text text-muted">Password and Confirm password must be
                            same.</small>
                    </div>
                    
                    </div>
                    <div class="form-group col-md-6 offset-md-3">
                    <button  name="signup" id="finalclick" data-toggle="modal"
                      data-backdrop="static" data-keyboard = "false"  data-show = "true"   data-target="#signupmodal" class="btn btn-primary">Sign up</button>
                      </div>
                

            </form>
<?php
            require('footer.php');
?>
<script>
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}
</script>