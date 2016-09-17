<?php
include_once('includes/database.php');
if(!isset($_SESSION['userid'])){
header("Location: index.php");
die();
}
$current = R::getAll("SELECT * FROM enrollcourse WHERE completed=0 AND userid=".$_SESSION['userid']);
$completed = R::getAll("SELECT * FROM enrollcourse WHERE completed=1 AND userid=".$_SESSION['userid']);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Courses</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
<?php
include_once('nav.php');
?>
<div class="container">
  <div class="row">
  <div class="col-md-12 col-xs-12">
    <center><h2>Current Courses</h2></center>
     <table class="table table-striped"> 
     <thead> 
     <tr> 
      
     <th>Course Name</th> 
     <th>Faculty</th> 
      
     </tr> 
     </thead> 
     
     <tbody> 
     
     <?php 
     foreach($current as $row){
     ?>
     <tr> 
     
     <td><?php $cour = R::load('courses',$row["courseid"]); echo $cour->course; ?></td>
     <td><?php $use = R::load('users',$cour->faculty); echo $use->name; ?></td> 
      
     </tr> 
     <?php
     }
     ?>
     
     </tbody> </table>
    </div>
    <hr/><hr/><br/><br/><br/>
    <div class="col-md-12 col-xs-12">
    <center><h2>Completed Courses</h2></center>
     <table class="table table-striped"> 
     <thead> 
     <tr> 
      
     <th>Course Name</th> 
     <th>Faculty</th> 
     <th>Grades</th> 
     </tr> 
     </thead> 
     
     <tbody> 
     
     <?php 
     foreach($completed as $row){
     ?>
     <tr> 
     
     <td><?php $cour = R::load('courses',$row["courseid"]); echo $cour->course; ?></td>
     <td><?php $use = R::load('users',$cour->faculty); echo $use->name; ?></td> 
     <td><?php echo $row["grades"]; ?></td> 
     </tr> 
     <?php
     }
     ?>
     
     </tbody> </table>
    </div>
    <!--/col--> 
  </div>
  <!--/row--> 
</div>
<!--/container-->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>