<?php
require ("header.php");
?>



<div class="container-fluid d-flex  flex-column justify-content-center align-items-center">
  
  <h1 class="my-4 text-success">
  <?php
  if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]==true ){
  echo "Yup ! finally you logged in";
  }else{
    echo "Just sign up to get more features!"; 
  }
 ?>   
</h1>
</div>
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
<ol class="carousel-indicators">
<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
</ol>
<div class="carousel-inner">
<div class="carousel-item active col-md-12">
 <img class="d-block w-100 img-responsive" src="photo/1.jpg" alt="First slide">
</div>
<div class="carousel-item">
 <img class="d-block w-100 img-responsive" src="photo/2.jpg" alt="Second slide">
</div>
<div class="carousel-item">
 <img class="d-block w-100 img-responsive" src="photo/3.jpg" alt="Third slide">
</div>
</div>
<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
<span class="carousel-control-prev-icon" aria-hidden="true"></span>
<span class="sr-only">Previous</span>
</a>
<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
<span class="carousel-control-next-icon" aria-hidden="true"></span>
<span class="sr-only">Next</span>
</a>
</div>


<?php
require ("footer.php");
?>

























