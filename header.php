
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
        <style type="text/css">
          body { background: skyblue !important; } /
        </style>
    <title>Form by bootstrap</title>
</head>
<body>
   <?php
     $userlogin = false;
     session_start();
     if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]==true )
     {
     $userlogin = true;
     }
     echo '
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="bootstrapform.php">Form Website</a>
        
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#"> </span></a>
                </li>
            </ul>
            <ul 
                class="nav navbar-nav navbar-right">';
               if($userlogin == true){
                    echo' 
                    <li class="mx-2"> <a class="btn btn-outline-success sm-4 row-xl" href="afterlogin.php?loginprocess=true">Profile<a></li>

                  <li class="mx-2"><a class="btn btn-outline-success sm-4 row-xl" href="project.php">Projects</a></li>

                   <li class="mx-2"><a class="btn btn-outline-success sm-4 row-xl" href="logout.php">Log out</a></li>'
    
                ;

                }else{
                    echo' <li class="mx-2" ><a class="btn btn-outline-success sm-4 row-xl" href="signup.php?loginprocess=true">Sign up<a></li>
    
                    <li class="mx-2"><a class="btn btn-outline-success sm-4 row-xl" href="login.php">Log in</a></li>';
                }     
           echo        '</ul>
           
               </div>
               </nav>' ; 
                       
    ?>