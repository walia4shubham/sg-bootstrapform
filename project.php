<?php

require ('header.php');
require('db_connect.php');
if(!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]!==true ){
    header("Location: bootstrapform.php");
}
         $uniqueidb=$user_projectname=$user_projectmember=$user_projectduration=$user_projecttechnology=$gettingidfromurl=$user=$offset =$limit=$page= $sortvalue=$orderbyfromurl=$no="";
         $no=1;
         $newa=[];
         $uniqueidb = $_SESSION['uniqueid'];
         $noindex=0;

         if(isset($_GET['flow'])){
             $sortvalue=$_GET['flow'];
         }else{
            $sortvalue= "DESC";
         }
         if(isset($_GET['orderby'])){
             $orderbyfromurl = $_GET['orderby'];
            //  echo $orderbyfromurl;
         }else{
             $orderbyfromurl = 'project_name';
         }
         if(isset($_GET['page'])){
             $no=$_GET['page'];
         }else{
            $no=1;
         }





 
?>

<?php
 if(isset($_POST['deletebutton'])){
     $gettingidfromurl=$_GET['projectid'];
   
    $sqls = " DELETE FROM `project_info` WHERE project_id = '$gettingidfromurl' ";

    $results =$conn -> query($sqls);  
    if ( $conn -> affected_rows >  0) { 
      echo "<h1 class='text-success text-center'>You have deleted your project</h1>";
    } else {
      echo "Sorry no record found" ;

    }
 }

 if(isset($_POST['editbutton'])){
     $gettingidfromurl=$_GET['projectid'];
   
     

     header("Location: createproject.php?projectidedit=$gettingidfromurl");
 }



?>






<div class=" m-5  py-2container border border-danger  bg-dark text-white ">


    <div class="d-flex justify-content-between align-item-center p-3">
        <a href="createproject.php"><button type="button" class="btn btn-info add-new"><i class="fa fa-plus"></i> Add
                New Project</button></a>

        <p class="text-center"><?php echo $_SESSION['fullname']  ?> Dashboard</p>
    </div>
    <div class="table-responsive">
        <table class="table table-success   table-striped text-dark">
            <thead>
                <tr>
<!-- 
                    <th scope="col">
                        <div><button class=" text-align: center btn btn-link p-0 m-0 d-inline align-middle"><a
                                    href='project.php?flow=DESC'><i class="bi bi-sort-up"></i></a></button></div>
                        S.no
                        <div><button class="btn btn-link p-0 m-0 d-inline align-middle"><a href='project.php?flow=ASC'><i
                                        class="bi bi-sort-down-alt"></i></a></button></div>
                    </th> -->

                    <th scope="col">
                        <div><button class="btn btn-link p-0 m-0 d-inline"><a href='project.php?page=<?php echo $no ?>&orderby=project_id&flow=DESC'><i
                                        class="bi bi-sort-up"></i></a></button></div>
                        Project id
                        <div><button class="btn btn-link p-0 m-0 d-inline"><a href='project.php?page=<?php echo $no ?>&orderby=project_id&flow=ASC'><i
                                        class="bi bi-sort-down-alt"></i></a></button></div>
                    </th>

                    <th scope="col">
                        <div><button class="btn btn-link p-0 m-0 d-inline"><a href='project.php?page=<?php echo $no ?>&orderby=project_name&flow=DESC'><i
                                        class="bi bi-sort-up"></i></a></button></div>
                        Project name
                        <div><button class="btn btn-link p-0 m-0 d-inline"><a href='project.php?page=<?php echo $no ?>&orderby=project_name&flow=ASC'><i
                                        class="bi bi-sort-down-alt"></i></a></button></div>
                    </th>

                    <th scope="col">
                        <div><button class="btn btn-link p-0 m-0 d-inline"><a href='project.php?page=<?php echo $no ?>&orderby=project_member&flow=DESC'><i
                                        class="bi bi-sort-up"></i></a></button></div>
                        Project member
                        <div><button class="btn btn-link p-0 m-0 d-inline"><a href='project.php?page=<?php echo $no ?>&orderby=project_member&flow=ASC'><i
                                        class="bi bi-sort-down-alt"></i></a></button></div>
                    </th>

                    <th scope="col">
                        <div><button class="btn btn-link p-0 m-0 d-inline"><a href='project.php?page=<?php echo $no ?>&orderby=project_duration&flow=DESC'><i
                                        class="bi bi-sort-up"></i></a></button></div>
                        Project duration
                        <div><button class="btn btn-link p-0 m-0 d-inline"><a href='project.php?page=<?php echo $no ?>&orderby=project_duration&flow=ASC'><i
                                        class="bi bi-sort-down-alt"></i></a></button></div>
                    </th>

                    <th scope="col">
                        <div><button class="btn btn-link p-0 m-0 d-inline"><a href='project.php?page=<?php echo $no ?>&orderby=project_technologies&flow=DESC'><i
                                        class="bi bi-sort-up"></i></a></button></div>
                        Project technology
                        <div><button class="btn btn-link p-0 m-0 d-inline"><a href='project.php?page=<?php echo $no ?>&orderby=project_technologies&flow=ASC'><i
                                        class="bi bi-sort-down-alt"></i></a></button></div>
                    </th>

                    <th scope="col">
                      
                        Skills
                   
                    </th>

                    <th scope="col">
                        
                        Actions
                       
                    </th>
                </tr>
            </thead>
            <tbody>

                <?php
      $limit = 3;
      if(isset($_GET['page'])){
        $page = $_GET['page'];
       }else{
        $page = 1;
       }
       $offset = ($page -1) * $limit;
 

     $sql2 = "SELECT * FROM project_info WHERE `user_id` = '$uniqueidb' ORDER BY `$orderbyfromurl` ".$sortvalue." LIMIT ".$offset.",".$limit;

   
     $results = $conn->query($sql2);

         if ($results->num_rows > 0) {
            $a=$offset;
            $a++;
       
            while($row = $results->fetch_assoc()) {
                $user_projectid=$row['project_id'];
                $user_projectname=$row['project_name'];
                $user_projectmember=$row['project_member'];
                $user_projectduration=$row['project_duration'];
                $user_projecttechnology=$row['project_technologies'];
                
                $noindex =$a++;
                $sql1 = "SELECT * FROM `project_skills` WHERE  `project_id` = '$user_projectid'  ";
                $result1 = $conn->query($sql1);
        
                 if ($result1->num_rows > 0) {
                    while($row = $result1->fetch_assoc()) {
                     $user=$row['user_project_skill'];
                     $newa[] .=$user;
                      
                    }
                   
                 }
                
                ?>



                <tr>


                    <!-- <td><?php echo $noindex;?></td> -->
                    <td><?php echo $user_projectid;?></td>
                    <td><?php echo $user_projectname;?></td>
                    <td><?php echo $user_projectmember;?></td>
                    <td><?php echo $user_projectduration;?></td>
                    <td><?php echo $user_projecttechnology;?></td>
                    <td><?php echo implode(",",$newa); $newa=[];?></td>
                    <td>
                        <form action="project.php?projectid=<?php echo $user_projectid?>" method="post">

                            <button name="editbutton" class="p-0 m-0"><a class="edit" title="Edit"
                                    data-toggle="tooltip"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                        <path
                                            d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5L13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175l-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                                    </svg></a></button>

                            <button name="deletebutton" class="p-0 m-0"><a class="edit" title="Delete"
                                    data-toggle="tooltip"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-trash2" viewBox="0 0 16 16">
                                        <path
                                            d="M14 3a.702.702 0 0 1-.037.225l-1.684 10.104A2 2 0 0 1 10.305 15H5.694a2 2 0 0 1-1.973-1.671L2.037 3.225A.703.703 0 0 1 2 3c0-1.105 2.686-2 6-2s6 .895 6 2zM3.215 4.207l1.493 8.957a1 1 0 0 0 .986.836h4.612a1 1 0 0 0 .986-.836l1.493-8.957C11.69 4.689 9.954 5 8 5c-1.954 0-3.69-.311-4.785-.793z" />
                                    </svg></a></button>
                            <a href="pdf.php?userprojectid=<?php echo $user_projectid?> " title="Download"
                                target="_blank"><i class="bi bi-download"></i></a>

                        </form>
                    </td>
                </tr>


                <?php
            }
         }



    ?>

            </tbody>
        </table>

        <?php
     
        $sql4 = "SELECT * FROM `project_info` WHERE `user_id` = '$uniqueidb' ";
                        $resu = $conn->query($sql4);
      
                        if($resu->num_rows > 0){
                          $rowscount = $resu->num_rows;
                        //   echo $rowscount;
                          $start = $offset + 1 ; 
                         
                          $end = $offset + $limit;

                          $total_pages = ceil($rowscount/$limit);

                          if($page == $total_pages){
                            $end = $rowscount;
                          }
                         
                          echo " showing(" . $start." to ".$end.")" . " out of ". $rowscount;
                          echo '<ul style = "list-style:none; display:flex; justify-content:center; ">';

                         for($i=1; $i<= $total_pages;$i++){

                          echo '<li >
                         <a style = "text-decoration:none;" class="text-danger mx-3" href="project.php?page='.$i.'">'.$i.'</a>
                         </li>';
       

                         }
                         echo '</ul>';
                        }
                         ?>
    </div>


</div>




<?php
require ('footer.php');
?>
<script>
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}
</script>