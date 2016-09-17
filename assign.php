<?php
include_once('includes/database.php');
if(isset($_SESSION['role']) && $_SESSION['role']!="admin"){
header("Location: index.php");
die();
}

if(!isset($_GET["id"])){
header("Location: index.php");
die();
}
$id = $_GET["id"];

if(isset($_GET["delete"])){
$delete = R::load('enrollcourse',$_GET["row"]);
R::trash( $delete ); 
$delete =1;
}
if(isset($_POST["course-enter"])){
$student = $_POST["student"];
$course = $_POST["course"];

$chk = R::findOne('courses',"student = ? AND id = ?",[ $student,$course ]);
if(!isset($chk->id)){
	$new = R::dispense('enrollcourse');
	$new->courseid = $_POST["course"];
	$new->userid = $student;
	$new->completed = 0;
	$new->grades = 0.00;
	$ij = R::store($new);
	
	
	$success=1;
} else{
	$error=3;
}
}
$student = R::getAll("SELECT * FROM users WHERE role='student'");
$courses = R::getAll("SELECT * FROM courses");
$enroll = R::getAll("SELECT * FROM enrollcourse");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Assign Marks</title>

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
  <div class="alert alert-success" role="alert">Student enrolled Successfully</div>
  <?php
  }
  ?>
  <?php
  if(isset($error) && $error=="3"){
  ?>
  <div class="alert alert-danger" role="alert">A Student enrolled in a course cannot be TA (moderator) for same course</div>
  <?php
  }
  ?>
  <?php
  if(isset($delete) && $delete=="1"){
  ?>
  <div class="alert alert-success" role="alert">Enrollment deleted Successfully</div>
  <?php
  }
  ?>
  
  <div class="panel-body">
						<div class="row">
							<div class="col-lg-6 well">
							<h3>Add Student to Course : <?php $course = R::load('courses',$id); echo $course->course; ?></h3>
								<form id="login-form" action="assign.php?id=<?php echo $id; ?>" method="post" role="form" style="display: block;">
									<div class="form-group">
										<select name="student" class="form-control">
											<option> - Select Student - </option>
											<?php
											foreach($student as $row){
											?>
											<option value="<?php echo $row["id"]; ?>"><?php echo $row["name"]; ?></option>
											<?php
											}
											?>
											
										</select>
									</div>
									<input type="hidden" name="course" value="<?php echo $_GET["id"]; ?>">
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="submit" name="course-enter" id="course-submit" tabindex="4" class="form-control btn btn-login btn-primary" value="Enroll">
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
     <th>Action</th> 
     </tr> 
     </thead> 
     
     <tbody> 
     <?php
     foreach($enroll as $row){
     ?>
     <tr> 
     <td><?php $fc = R::load('users',$row["userid"]); echo $fc->name; ?></td>      
     <td><?php $course = R::load('courses',$row["courseid"]); echo $course->course; ?></td> 

     <td><a href="assign.php?delete=1&id=<?php echo $id; ?>&row=<?php echo $row["id"]; ?>">Delete</a>
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