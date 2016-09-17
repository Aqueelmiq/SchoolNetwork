<?php
include_once('includes/database.php');
if(!isset($_SESSION['userid'])){
header("Location: index.php");
die();
}

if(!isset($_GET["id"])){
header("Location: index.php");
die();
}

$id = $_GET["id"];
$chk = R::load('courses',$id);
if($chk->faculty!=$_SESSION['userid']){
header("Location: index.php");
die();
}


if(isset($_GET["delete"])){
$delete = R::load('enrollcourse',$_GET["row"]);
$delete->grades = 0;
$delete->completed=0;
R::store( $delete ); 
$delete =1;
}

if(isset($_POST["grades-enter"])){

$student = $_POST["student"];
$grade = $_POST["grade"];

$new = R::load('enrollcourse',$student);
$new->completed=1;
$new->grades = $grade;
R::store($new);


$success=1;
}

$enroll = R::getAll("SELECT * FROM enrollcourse WHERE completed=0 AND courseid=".$id);
$cmp = R::getAll("SELECT * FROM enrollcourse WHERE completed=1 AND courseid=".$id);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Assign Grades</title>

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
  
  <?php
  if(isset($success) && $success=="1"){
  ?>
  <div class="alert alert-success" role="alert">Student grades Successfully Entered</div>
  <?php
  }
  ?>
  <?php
  if(isset($delete) && $delete=="1"){
  ?>
  <div class="alert alert-success" role="alert">Grades Reset Successfully</div>
  <?php
  }
  ?>
  
  <div class="panel-body">
						<div class="row">
							<div class="col-lg-6 well">
							<h3>Assign Grades to Student : <?php $course = R::load('courses',$id); echo $course->course; ?></h3>
								<form id="login-form" action="grades.php?id=<?php echo $id; ?>" method="post" role="form" style="display: block;">
									<div class="form-group">
										<select name="student" class="form-control">
											<option> - Select Student - </option>
											<?php
											foreach($enroll as $row){
											?>
											<option value="<?php echo $row["id"]; ?>"><?php $usr=R::load('users',$row["userid"]); echo $usr->name; ?></option>
											<?php
											}
											?>
											
										</select>
									</div>
									<div class="form-group">
										<input type="text" name="grade" class="form-control" placeholder="Enter Grades">
									</div>
									
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="submit" name="grades-enter" id="course-submit" tabindex="4" class="form-control btn btn-login btn-primary" value="Assign Marks">
											</div>
										</div>
									</div>
									
								</form>
						</div>
</div>



    <div class="col-md-12 col-xs-12">
     <table class="table table-striped"> 
     <thead> 
     <tr> 
      
     <th>Student Name</th> 
     <th>Course</th> 
     <th>Grades</th> 
     <th>Action</th> 
     </tr> 
     </thead> 
     
     <tbody> 
     <?php
     foreach($cmp as $row){
     ?>
     <tr> 
     <td><?php $fc = R::load('users',$row["userid"]); echo $fc->name; ?></td>      
     <td><?php $course = R::load('courses',$row["courseid"]); echo $course->course; ?></td> 
	<td><?php echo $row["grades"]; ?></td> 
     <td><a href="grades.php?delete=1&id=<?php echo $id; ?>&row=<?php echo $row["id"]; ?>">Reset</a>
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