<?php
require ('header.php');
require('db_connect.php');
if(!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]!==true ){
    header("Location: bootstrapform.php");
}

$projectnameErr=$projectname= $not_inserting =$userid=$projectname=$projectmember=$projectduration=$projecttechnologies= $projecttechnology=$uniqueidb =$editingtableidfromurl=$databaseprojectname= $databaseprojectmember=$databaseprojectduration= $databaseprojecttechnology=$checkboxskills=$skillscheckboxerror="";

$newa=[];
$not_inserting=false;

$uniqueidb = $_SESSION['uniqueid'];

if(empty($_SESSION["key"]))

    $_SESSION['key'] = bin2hex(random_bytes(32));


  $csrf = hash_hmac('sha256','updatedetails.php',$_SESSION['key']);



?>

<?php


if(isset($_GET['projectidedit'])){
    $editingtableidfromurl=$_GET['projectidedit'];

    $sql = "SELECT * FROM `project_info` WHERE `project_id` = '$editingtableidfromurl'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                 while($row = $result->fetch_assoc()) {
                    $databaseprojectname=$row['project_name'];
                    $databaseprojectmember=$row['project_member'];
                    $databaseprojectduration=$row['project_duration'];
                    $databaseprojecttechnology=$row['project_technologies'];
                    $sql1 = "SELECT * FROM `project_skills` WHERE  `project_id` = '$editingtableidfromurl' ";
                     $result1 = $conn->query($sql1);
            
                     if ($result1->num_rows > 0) {
                        while($row = $result1->fetch_assoc()) {
                         $user=$row['user_project_skill'];
                         $newa[] .=$user;
                          
                        }
                       
                     }

                  }
               
                }

        

                if(isset($_POST['updateprojects'])){
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
                      
                   if(empty($_POST["projectname"])){
                          $projectnameErr= "cannot set empty" ;
                          $not_inserting = true;
                     }
                    else{
                       $projectname = validate($_POST["projectname"]);
                        if (!preg_match("/^[a-zA-Z\S]/",$projectname)) {
                            $projectnameErr = "Only letters and white space allowed";
                             $not_inserting = true;
                         }
                      }
         
                    
                    $projectmember = $_POST["projectmember"];
                    $projectduration = $_POST["projectduration"];
                    $projecttechnology = $_POST["projecttechnology"];

              if($not_inserting == false){
                    $sql="UPDATE `project_info` SET `project_name`='$projectname', `project_member`='$projectmember', `project_duration`='$projectduration', `project_technologies`='$projecttechnology' WHERE `project_id` = '$editingtableidfromurl'";

                    if($conn->query($sql) === TRUE) {
                                           

                                            $checkboxskills = $_POST['skills']; 
                                            foreach ($checkboxskills as $value){
                                 
                                                $sql4="DELETE FROM `project_skills` WHERE  `project_id` = '$editingtableidfromurl' ";
                                                 echo "dd";
                                                if($conn->query($sql4) === TRUE) {
                                                   
                                                   echo "deleted";
                                                }else{
                                                    echo "Error: " . $sql4 . "<br>" . $conn->error;
                                                }
                                            }
     
                                         foreach ($checkboxskills as $value){
                                 
                                             $sql4="INSERT INTO `project_skills`(`project_id`, `user_project_skill`) VALUES ('$editingtableidfromurl','$value')  ";
                                              echo "dd";
                                             if($conn->query($sql4) === TRUE) {
                                                
                                             header("Location: project.php");
                                             }else{
                                                 echo "Error: " . $sql4 . "<br>" . $conn->error;
                                             }
                                         }
                                     
                   }else{
                       echo "Error: " . $sql . "<br>" . $conn->error;
                    }

                }
        }

}

if(isset($_POST['submitprojects'])){

    if(!empty($_POST['skills'])) {   
        
     
     }else{
         $skillscheckboxerror="choose at least one ";
         $not_inserting = true;
     }

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

          if(empty($_POST["projectname"])){
                 $projectnameErr= "cannot set empty" ;
                 $not_inserting = true;
            }
           else{
               
              $projectname = validate($_POST["projectname"]);
               if (!preg_match("/^[a-zA-Z\S]/",$projectname)) {
                   $projectnameErr = "Only letters and white space allowed";
                    $not_inserting = true;
                }
             }
           $projectmember = $_POST["projectmember"];
           $projectduration = $_POST["projectduration"];
           $projecttechnology = $_POST["projecttechnology"];
     
      
      if($not_inserting == false){
          $sql= "INSERT INTO `project_info`( `user_id`, `project_name`, `project_member`, `project_duration`, `project_technologies`) VALUES ('$uniqueidb','$projectname','$projectmember','$projectduration','$projecttechnology')" ;
          
            if($conn->query($sql) === TRUE) {
             
            $sql="SELECT `project_id` FROM `project_info` WHERE `user_id`='$uniqueidb'AND `project_name`='$projectname' AND `project_member`='$projectmember'AND  `project_duration`='$projectduration'AND `project_technologies`= '$projecttechnology'";
                   $result = $conn->query($sql);  
                               if($result->num_rows >0) { 
       
                                       while($row = $result->fetch_assoc()){
                                        $projectid= $row['project_id'];
                                        }
                                       $checkboxskills = $_POST['skills']; 

                                    foreach ($checkboxskills as $value){
                            
                                        $sql="INSERT INTO `project_skills`(`project_id`, `user_project_skill`) VALUES ('$projectid','$value')";
                                        
                                        if($conn->query($sql) === TRUE) {
                                        header("Location: project.php");
                                        }else{
                                            echo "Error: " . $sql . "<br>" . $conn->error;
                                        }
                                    }
                                }

           }else{
               echo "Error: " . $sql . "<br>" . $conn->error;
            }

        }             
        
}

?>

<?php
 if(isset($editingtableidfromurl) && ($editingtableidfromurl !="")){
     echo '<h2 class="text-center p-4">Edit your project details</h2>

';
 }else{
    echo '<h2 class="text-center p-4">Please Add your project details</h2>';
 }
    ?>


<form action="" method="POST" class="container border border-info bg-dark text-white py-5">
    <div class="form-group row col-md-6 offset-md-3">
        <label for="projectname">Project name</label><span class="mx-4 text-danger">*</span>
        <input type="text" class="form-control" name="projectname" id="projectname" placeholder="Project name"
            value="<?php echo $databaseprojectname ?>"><span class="text-danger"><?php echo $projectnameErr;?></span>

    </div>
    <div>
        <input type="hidden" name="csr" value = "<?php echo $csrf ?>">
        </div>
    <div class="form-group row col-md-6 offset-md-3">
        <label for="projectmembers">Project Member</label><span class="mx-4 text-danger">*</span>
        <select class="form-control" id="projectmembers" name="projectmember">

            <option <?php echo ($databaseprojectmember == '1') ?  "SELECTED" : "" ;?> value="1">1</option>
            <option <?php echo ($databaseprojectmember == '2') ?  "SELECTED" : "" ;?> value="2">2</option>
            <option <?php echo ($databaseprojectmember == '3') ?  "SELECTED" : "" ;?> value="3">3</option>
            <option <?php echo ($databaseprojectmember == '4') ?  "SELECTED" : "" ;?> value="4">4</option>
            <option <?php echo ($databaseprojectmember == '5') ?  "SELECTED" : "" ;?> value="5">5</option>
        </select>
    </div>
    <div class="form-group row col-md-6 offset-md-3">
        <label for="projectdurations">Project Duration</label><span class="mx-4 text-danger">*</span>
        <select class="form-control" id="projectdurations" name="projectduration">
            <option <?php echo ($databaseprojectduration == '6 year') ?  "SELECTED" : "" ;?> value="6 months">6 months
            </option>
            <option <?php echo ($databaseprojectduration == '1 year') ?  "SELECTED" : "" ;?> value="1 year">1 year
            </option>
            <option <?php echo ($databaseprojectduration == '2 year') ?  "SELECTED" : "" ;?> value="2 year">2 year
            </option>
            <option <?php echo ($databaseprojectduration == '4 year') ?  "SELECTED" : "" ;?> value="4 year">4 year
            </option>
            <option <?php echo ($databaseprojectduration == '5 year') ?  "SELECTED" : "" ;?> value="5 year">5 year
            </option>
        </select>
    </div>
    <div class="form-group row col-md-6 offset-md-3">
        <label for="projecttechnologys">Project Technology</label><span class="mx-4 text-danger">*</span>
        <select class="form-control" id="projecttechnologys" name="projecttechnology">
            <option <?php echo ($databaseprojecttechnology == 'Laravel') ?  "SELECTED" : "" ;?> value="Laravel">Laravel
            </option>
            <option <?php echo ($databaseprojecttechnology == 'dot.net') ?  "SELECTED" : "" ;?> value="dot.net">dot.net
            </option>
            <option <?php echo ($databaseprojecttechnology == 'Django') ?  "SELECTED" : "" ;?> value="Django">Django
            </option>

        </select>
    </div>
    <div class="form-group row col-md-6 offset-md-3">
        <div class="control-group">
            <p class="pull-left">Skills<span class="mx-4 text-danger">*</span></p>
            <div class="controls span2 ">
                <label class="checkbox px-3">
                    <input type="checkbox" value="MY SQL" <?php echo (in_array("MY SQL",$newa)) ?  "checked" : "" ;  ?> name="skills[]"  id="inlineCheckbox1"> My SQL
                </label>
                <label class="checkbox px-3">
                    <input type="checkbox" value="PHP" name="skills[]" value="PHP"
                            <?php echo (in_array("PHP",$newa)) ?  "checked" : "" ;  ?> id="inlineCheckbox2"> PHP
                </label>
                <label class="checkbox px-3">
                    <input type="checkbox" value="JAVASCRIPT" name="skills[]" <?php echo (in_array("JAVASCRIPT",$newa)) ?  "checked" : "" ; ?> id="inlineCheckbox3"> JAVASCRIPT
                </label>
                <label class="checkbox px-3">
                    <input type="checkbox" value="HTML"  <?php echo (in_array("HTML",$newa)) ?  "checked" : "" ;  ?> name="skills[]"  id="inlineCheckbox3"> HTML
                </label>
            </div><span class="text-danger"><?php echo $skillscheckboxerror?></span>
        </div>
    </div>

    <?php
             if(isset($_GET['projectidedit'])){
                echo'<div class="form-group form-group col-md-6 offset-md-3">
                <button type="submit" name="updateprojects" class="btn btn-primary">Update</button>
            </div>';
             }else{
                 echo'<div class="form-group form-group col-md-6 offset-md-3">
                 <button type="submit" name="submitprojects" class="btn btn-primary">Submit</button>
             </div>';
             }

         ?>


</form>



<!-- </div> -->



<?php
require ('footer.php');
?>

<script>
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}
</script>