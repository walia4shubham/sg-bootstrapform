<?php
require ('header.php');
require('db_connect.php');
if(!isset($_SESSION["loggedin"]) ){
    header("Location: bootstrapform.php");
}
?>

<?php
       $email = $firstname = $lastname = $lastnameErr = $emailErr = $firstnameErr = $emailerror =  $data =$passwordErr = $cpasswordErr =$signuppassword = $signupcpassword="";
      
    
       $uniqueidb = $_SESSION['uniqueid'];
       $mail = $_SESSION['useremail'];
       $sql = "SELECT * FROM user_all_info WHERE `user_id` = '$uniqueidb' ";
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
                       $databaseuserprofilephoto = $row['user_uploadimage'];
                       $databaseuserskill=$row['user_skills'];
                 }

        } else {
                echo "0 results";
            }
            $conn->close();
?>

 <h1 class="text-center my-3">Welcome <?php echo $_SESSION['fullname']  ?></h1>
<div class=" mb-5 container border border-info">
    <img class=" my-3 shadow-none p-1 mb-1 bg-dark rounded rounded-circle z-depth-2 mx-auto d-block" <?php  echo (isset($databaseuserprofilephoto)AND $databaseuserprofilephoto != NULL) ?  "src='upload/".$databaseuserprofilephoto."'" : "src='photo/images.png'" ;  ?> alt="fd" width="170rem"
        height="150rem">
    <hr>

    <div class="form-group row ">
        <label for="inputEmail3" class="col-sm-2 col-form-label ">
            <h4 class="text-primary">Email</h4>
        </label>
        <div class="col-sm-10 mt-2">
            <?php echo "<h5 >".$databaseusermail."</h5>" ?>
            
        </div>
    </div>
    <div class="form-group row">
        <label for="userfirstname" class="col-sm-2 col-form-label my-2">
            <h4 class="text-primary">First name</h4>
        </label>
        <div class="col-sm-10 mt-3">
            <?php echo "<h5>".$databaseuserfirstname."</h5>" ?>
           
        </div>
    </div>
    <div class="form-group row">
        <label for="userlastname" class="col-sm-2 col-form-label my-2">
            <h4 class="text-primary">Last name</h4>
        </label>
        <div class="col-sm-10 mt-3">
            <?php echo "<h5 >".$databaseuserlastname."</h5>" ?>
           
        </div>
    </div>
    <div class="form-group row">
        <label for="exampleFormControlTextarea1 " class="col-sm-2 col-form-label my-2">
            <h4 class="text-primary">About yourself</h4>
        </label>
        <div class="col-sm-10 mt-3">
            <?php echo "<h5 >".$databaseuserabout."</h5>" ?>
          
        </div>
    </div>
    <div class="form-group row ">
        <label for="datebirthday" class="col-sm-2 col-form-label ">
            <h4 class="text-primary">Skills</h4>
        </label>
        <div class="col-sm-10 mt-2">
            <?php echo "<h5 >".$databaseuserskill."</h5>" ?>
           
        </div>
    </div>

    <div class="form-group row ">
        <label for="datebirthday" class="col-sm-2 col-form-label ">
            <h4 class="text-primary">Gender</h4>
        </label>
        <div class="col-sm-10 mt-2">
            <?php echo "<h5 >".$databaseusergender."</h5>" ?>
           
        </div>
    </div>
   
    <div class="form-group row ">
        <label for="datebirthday" class="col-sm-2 col-form-label ">
            <h4 class="text-primary">Date Of Birth</h4>
        </label>
        <div class="col-sm-10 mt-2">
            <?php echo "<h5 >".$databaseuserdob."</h5>" ?>
           
        </div>
    </div>

    <div class="form-group row ">
        <label for="datebirthday" class="col-sm-2 col-form-label ">
            <h4 class="text-primary">City</h4>
        </label>
        <div class="col-sm-10 mt-2">
            <?php echo "<h5 >".$databaseusercity."</h5>" ?>
           
        </div>
    </div>
 
  
  <div class="form-group row  text-center">
    <div class="text-center mx-auto d-block">
        <a href="updatedetails.php"><button type="submit" class="btn btn-primary ">Update your details</button></a>
    </div>
  </div>
</div>

 <?php
 require ('footer.php');
 ?>