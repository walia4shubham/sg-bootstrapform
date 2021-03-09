<?php
require ('header.php');
require ("db_connect.php");

$email = $firstname = $lastname = $lastnameErr = $emailErr = $firstnameErr = $emailerror =  $data =$passwordErr = $cpasswordErr =$oldpassword= $newpassword=$skillbox1= $skillbox2= $skillbox3= $skillbox4 = $doberror = $uniqueidb=$chk=$skilsconvertintostring=$newpasswordErr=$oldpasswordErr=$hash_newpassword= "";


if(empty($_SESSION["key"]))

    $_SESSION['key'] = bin2hex(random_bytes(32));


  $csrf = hash_hmac('sha256','updatedetails.php',$_SESSION['key']);









if(!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]!==true ){
    header("Location: bootstrapform.php");
}
 

     
      $uniqueidb = $_SESSION['uniqueid'];
      $not_inserting = false;
    if(isset($_POST["updateall"])){

               function validate($data){
                    $data = trim($data);
                    $data = htmlspecialchars($data);
                    $data = stripslashes($data);
                    return $data;
                 }


                 if(hash_equals($csrf,$_POST['csr'])){
                    echo "your name is valid";
                  }else{
                      echo "Token error";
                    $not_inserting = true;
                  }



            if(empty($_POST["firstname"])){
                 $firstnameErr= "cannot set empty" ;
                 $not_inserting = true;
             }
            else{
                 $firstname = validate($_POST["firstname"]);
                     if (!preg_match("/^[a-zA-Z-']*$/",$firstname)) {
                         $firstnameErr = "Only letters and white space allowed";
                         $not_inserting = true;
                        }
                }


            if(empty($_POST["lastname"])){
                   $lastnameErr= "cannot set empty" ;
                   $not_inserting = true;
              }
            else{
                 $lastname = validate($_POST["lastname"]);
                      if (!preg_match("/^[a-zA-Z-']*$/",$lastname)) {
                         $lastnameErr = "Only letters and white space allowed";
                         $not_inserting = true;
                        }
                }


            if(empty($_POST["email"])) {
                     $emailErr = "Email is required";
                     $not_inserting = true;
             } 
             else {
                  $email = validate($_POST["email"]);
                      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                          $emailErr = "Invalid email format";
                          $not_inserting = true;
                      }
                }

            if(empty($_POST["dob"])){
                    $doberror = "Cannot set empty";
                    $_POST["dob"]="0000-00-00";
                }


                  $fileerror = $_FILES['fileToUpload']['error'];
                  $filename= $_FILES['fileToUpload']['name'];
                  $filesize =$_FILES['fileToUpload']['size'];
                  $filetmp_name =$_FILES['fileToUpload']['tmp_name'];
                  $filetype =$_FILES['fileToUpload']['type'];
 
                  $target_dir = "upload/";
                  $pathname = $filename;
                  $target_file = $target_dir . basename($pathname);



                  $uploadOk = 1;
                  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
 


            if($filesize !== 0){
                       if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                               && $imageFileType != "gif" ) {
                           echo  "<h2 class='text-danger text-center'>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</h2>";
                           $uploadOk = 0;
                           $not_inserting = true;
                        }

                }
  

            if ($uploadOk == 0){
                    $not_inserting = true;
                }
             else{

              $uploaddirectory = 'upload';
              move_uploaded_file($filetmp_name,$uploaddirectory.'/'.$pathname);
             }
            if(!empty($_POST['lang'])) {    
                  $checkboxskills = $_POST['lang']; 
                  $chk = implode(",",$checkboxskills);
            }
            
            if(!empty($_POST["newpassword"])) {
               
                $newpassword = validate($_POST["newpassword"]);
                if (strlen($_POST["newpassword"]) < 7) {
                    $newpasswordErr = "Your Password Must Contain At Least 8 Characters!";
                    echo strlen($_POST["newpassword"]);
                    $not_inserting = true;
                }
                elseif(!preg_match("#[0-9]+#",$newpassword)) {
                    $newpasswordErr = "Your Password Must Contain At Least 1 Number!";
                    $not_inserting = true;
                }
                elseif(!preg_match("#[A-Z]+#",$newpassword)) {
                    $newpasswordErr = "Your Password Must Contain At Least 1 Capital Letter!";
                    $not_inserting = true;
                }
                elseif(!preg_match("#[a-z]+#",$newpassword)) {
                    $newpasswordErr = "Your Password Must Contain At Least 1 Lowercase Letter!";
                    $not_inserting = true;
                }
              }
               elseif(!empty($_POST["newpassword"])) {
               $cpasswordErr = "Please Check You've Entered Or Confirmed Your Password!";
               $not_inserting = true;
              } else {
                $newpasswordErr = "Please enter password   ";
                $not_inserting = true;
            }
            if(!empty($_POST["oldpassword"])) {
                $oldpassword = validate($_POST["oldpassword"]);
                
                if (strlen($_POST["oldpassword"]) < 7) {
                    $oldpasswordErr = "Your Password Must Contain At Least 8 Characters!";
                    
                    $not_inserting = true;
                }
                elseif(!preg_match("#[0-9]+#",$oldpassword)) {
                    $oldpasswordErr = "Your Password Must Contain At Least 1 Number!";
                    $not_inserting = true;
                }
                elseif(!preg_match("#[A-Z]+#",$oldpassword)) {
                    $oldpasswordErr = "Your Password Must Contain At Least 1 Capital Letter!";
                    $not_inserting = true;
                }
                elseif(!preg_match("#[a-z]+#",$oldpassword)) {
                    $oldpasswordErr = "Your Password Must Contain At Least 1 Lowercase Letter!";
                    $not_inserting = true;
                }
              }
               elseif(!empty($_POST["oldpassword"])) {
               $oldpasswordErr = "Please Check You've Entered Or Confirmed Your Password!";
               $not_inserting = true;
              } else {
                $oldpasswordErr = "Please enter password   ";
                $not_inserting = true;
            }




        if($not_inserting == false){
              
             $about = $_POST["about"];
             $gender = $_POST["optradio"];
             $dob = $_POST["dob"];
             $city =  $_POST["city"];
             $sql = "SELECT * FROM user_all_info WHERE `user_emailid` = '$email' AND user_id != $uniqueidb ";
            $result = $conn->query($sql);  
                   if ( $result->num_rows ==  0) { 
    

                       $sql = "SELECT * FROM `user_all_info` WHERE user_id = '$uniqueidb' ";
                        $resulta = $conn->query($sql);  
                       while($row = $resulta->fetch_assoc()){
                           
                           if(password_verify($oldpassword,$row['user_password'])){
                            //    echo "ddd";
                              $hash_newpassword = password_hash($newpassword,PASSWORD_DEFAULT);
                            //   echo $hash_newpassword;
                              $newsql = "UPDATE `user_all_info` SET `user_emailid`='$email' ,   `user_firstname`=      '$firstname' ,        `user_lastname`= '$lastname',   `user_about`= '$about',     `user_gender`='$gender',`user_dob`='$dob',         `user_city`='$city',     `user_uploadimage`='$pathname',`user_skills`='$chk',`user_password`= '$hash_newpassword' WHERE   `user_id` =             '$uniqueidb'";
                         
                               $resultagain = $conn->query($newsql); 

                               if ($conn->query($newsql) === TRUE) {
                                header("Location: afterlogin.php?loginprocess=true");
                                 echo "<h1 class='text-danger text-center'> Sucessfully updated your data  </h1>";
                                }else{
                                    echo $conn->error;
                                }
                            }else{
                                echo "<h1 class='text-center text-danger'>write your correct password</h1>";
                            }
                       }       
                   }else{
                          echo "<h1 class='text-danger  text-center '>sorry you cannot choose that email id as it has already been taken</h1>"; 
                          
                    }
          }
    }
             $uniqueidb = $_SESSION['uniqueid'];
            $sql = "SELECT * FROM user_all_info WHERE `user_id` = '$uniqueidb'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                 while($row = $result->fetch_assoc()) {
                      $databaseusermail=$row['user_emailid'];
                      $databaseuserfirstname = $row['user_firstname'];
                      $databaseuserlastname= $row['user_lastname'];
                      $databaseuserabout= $row['user_about'];
                      $databaseusergender= $row['user_gender'];
                      $databaseuserdob= $row['user_dob'];
                      $databaseusercity= $row['user_city'];
                      $databaseuserskill=$row['user_skills'];
                      $databaseuserprofilephoto=$row['user_uploadimage'];
                 }
                  $skilsconvertintostring = explode(",",$databaseuserskill);
            } else {
                 echo "0 results";
              }
             $conn->close();


?>
<form class="my-5 container border border-info" action="" method="POST" enctype="multipart/form-data">
    <div class="form-row  ">
        <div class="form-group col-md-6">
            <label for="inputEmail3">Email</label><span class="mx-4 text-danger">*</span>

            <input type="email" class="form-control" id="inputEmail3" name="email" placeholder="Email"
                value="<?php echo $databaseusermail ?>"> <span class="text-danger"><?php echo $emailErr;?></span>
        </div>

        <div>
        <input type="hidden" name="csr" value = "<?php echo $csrf ?>">
        </div>

        <div class="form-group col-md-6">
            <label for="userfirstname">First name</label><span class="mx-4 text-danger">*</span>
            <input type="text" class="form-control" id="userfirstname" name="firstname" placeholder="First name"
                value="<?php echo $databaseuserfirstname ?>"><span
                class="text-danger"><?php echo $firstnameErr;?></span>
        </div>
    </div>
    <div class="form-row  ">
        <div class="form-group col-md-6">
            <label for="userlastname">Last name</label><span class="mx-4 text-danger">*</span>

            <input type="text" class="form-control" id="userlastname" name="lastname" placeholder="Last name"
                value="<?php echo $databaseuserlastname ?>"> <span class="text-danger"><?php echo $lastnameErr;?></span>
        </div>
        <div class="form-group col-md-6">
            <label for="exampleFormControlTextarea1">About yourself</label>

            <textarea class="form-control" id="exampleFormControlTextarea1" name="about" rows="1"
                value=""><?php echo $databaseuserabout ?></textarea>
        </div>
    </div>
    <div class="form-row  ">
        <div class="form-group col-md-6">

            <label for="inputAddress">Skills</label>
            <div class="checkbox">
                <div>
                    <label><input type="checkbox" name="lang[]" value="PHP"
                            <?php echo (in_array("PHP",$skilsconvertintostring)) ?  "checked" : "" ;  ?>>PHP</label>
                </div>
                <div>
                    <label><input type="checkbox" name="lang[]" value="MY SQL"
                            <?php echo (in_array("MY SQL",$skilsconvertintostring)) ?  "checked" : "" ;  ?>>My
                        sql</label>
                </div>
                <div>
                    <label><input type="checkbox" name="lang[]" value="JAVA SCRIPT"
                            <?php echo (in_array("JAVA SCRIPT",$skilsconvertintostring)) ?  "checked" : "" ; ?>>Javascript</label>
                </div>
                <div>
                    <label><input type="checkbox" name="lang[]" value="HTML"
                            <?php echo (in_array("HTML",$skilsconvertintostring)) ?  "checked" : "" ;  ?>>html</label>
                </div>
            </div>
        </div>
        <div class="form-group col-md-6">
            <label for="optradio">Gender</label>
            <div class="radio">
                <label><input type="radio" name="optradio" value="MALE"
                        <?php echo ($databaseusergender== 'MALE') ?  "checked" : "" ;  ?>>Male</label>
            </div>
            <div class="radio">
                <label><input type="radio" name="optradio" value="FEMALE"
                        <?php echo ($databaseusergender== 'FEMALE') ?  "checked" : "" ;  ?>>Female</label>
            </div>
            <div class="radio ">
                <label><input type="radio" name="optradio" value="OTHER"
                        <?php echo ($databaseusergender== 'OTHER') ?  "checked" : "" ;  ?>>Other</label>
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="datebirthday">Date Of Birth</label>
            <input type="date" class="form-control" name="dob" value="<?php echo $databaseuserdob ?>" id="datebirthday">
        </div>
        <div class="form-group col-md-6">
            <label for="inputState">City</label>
            <select id="inputState" class="form-control" name="city">
                <option <?php echo ($databaseusercity == 'MOHALI') ?  "SELECTED" : "" ;?> value="MOHALI">Mohali</option>

                <option <?php echo ($databaseusercity == 'CHANDIGARH') ?  "SELECTED" : "" ;?> value="CHANDIGARH">
                    Chandigarh</option>

                <option <?php echo ($databaseusercity == 'PANCHKULA') ?  "SELECTED" : "" ;?> value="PANCHKULA">Panchkula
                </option>
            </select>
        </div>

    </div>
    <div class="form-row">
        <div class="form-group  col-md-5">
            <label for="Image" value="frrfe">Upload your profile pic</label>
            <input type="file" class="form-control" name="fileToUpload" onchange="readURL(this);" id="fileToUpload">
        </div>
        <div class="form-group col-md-6" id="preview">
            <img class="my-3 shadow-none  bg-dark rounded rounded-circle z-depth-2 "   style= "width:10rem  " height="80rem" <?php  echo (isset($databaseuserprofilephoto)AND $databaseuserprofilephoto != NULL) ?  "src='upload/".$databaseuserprofilephoto."'" : "src='photo/images.png'" ;  ?> id="thumb" />
        </div>
    </div>

    <!-- <div>
    <label for="inputState"><h5 class="">Want to update the password</h5></label>
    <select id="test" name="form_select" onchange="showDiv('hidden_div', this)">
   <option  value="0">No</option>
   <option  value="1">Yes</option>
   </select> -->
   <div id="hidden_div" style=" display: non;">
   <div class="form-row  ">
        <div class="form-group col-md-6">
            <label for="oldpassword">Old password</label><span class="mx-4 text-danger">*</span>

            <input type="password" class="form-control" id="oldpassword" name="oldpassword" placeholder="Old password"
                > <span class="text-danger"><?php echo $oldpasswordErr;?></span>
        </div>
        <div class="form-group col-md-6">
            <label for="newpassword">New password </label><span class="mx-4 text-danger">*</span>
            <input type="text" class="form-control" id="newpassword" name="newpassword" placeholder="New password"
                ><span
                class="text-danger"><?php echo $newpasswordErr;?></span>
        </div>
    </div>
   
   </div>
    
    </div>

    <button type="submit" style="width:12rem" class="btn btn-danger text-center" name="updateall">Update </button>
</form>
<?php
require ('footer.php');
?>
<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#thumb').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<script>
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}
</script>

<script>
function showDiv(divId, element)
{
    document.getElementById(divId).style.display = element.value == 1 ? 'block' : 'none';
}
</script>
