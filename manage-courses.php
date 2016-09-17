<?php
include_once('includes/database.php');
if(isset($_SESSION['role']) && $_SESSION['role']!="admin"){
header("Location: index.php");
die();
}
$faculty = R::getAll("SELECT * FROM users WHERE role='faculty'");
$student = R::getAll("SELECT * FROM users WHERE role='student'");

if(isset($_POST["course-enter"])){
$course = $_POST["course"];

$new = R::dispense('courses');
$new->course = $course;
$new->faculty = $_POST["faculty"];
$new->student = $_POST["student"];
$id = R::store($new);

$neww = R::dispense('groups');
$neww->name = $course;
$neww->courseid = $id;
$neww->faculty = $_POST["faculty"];
$new->student = $_POST["student"];
$is = R::store($neww);

$success=1;
}
$courses = R::getAll("SELECT * FROM courses");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Manage Courses</title>

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
  if($success=="1"){
  ?>
  <div class="alert alert-success" role="alert">Course Added Successfully</div>
  <?php
  }
  ?>
  <?php
  if(isset($_GET['edit'])){
  ?>
  <div class="alert alert-success" role="alert">Course Edited Successfully</div>
  <?php
  }
  ?>
  <div class="panel-body">
						<div class="row">
							<div class="col-lg-6 well">
							<h3>Enter New Course</h3>
								<form id="login-form" action="manage-courses.php" method="post" role="form" style="display: block;">
									<div class="form-group">
										<input type="text" name="course" id="course" tabindex="1" class="form-control" placeholder="Enter Course Name" value="">
									</div>
									<div class="form-group">
										<select name="faculty" class="form-control">
											<option> - Select Prof for Moderation - </option>
											<?php
											foreach($faculty as $row){
											?>
											<option value="<?php echo $row["id"]; ?>"><?php echo $row["name"]; ?></option>
											<?php
											}
											?>
											
										</select>
									</div>
									<div class="form-group">
										<select name="student" class="form-control">
											<option> - Select Student for Moderation - </option>
											<?php
											foreach($student as $row){
											?>
											<option value="<?php echo $row["id"]; ?>"><?php echo $row["name"]; ?></option>
											<?php
											}
											?>
											
										</select>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="submit" name="course-enter" id="course-submit" tabindex="4" class="form-control btn btn-login btn-primary" value="Create Course">
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
      
     <th>Course Name</th> 
     <th>Moderator Name</th>
     <th>Student Name</th> 
     <th>Action</th> 
     </tr> 
     </thead> 
     
     <tbody> 
     <?php
     foreach($courses as $row){
     ?>
     <tr> 
     
     <td><?php echo $row["course"]; ?></td> 
     <td><?php $fc = R::load('users',$row["faculty"]); echo $fc->name; ?></td> 
     <td><?php $fc = R::load('users',$row["student"]); echo $fc->name; ?></td> 
     <td><a href="editcourse.php?id=<?php echo $row["id"]; ?>">Edit</a> | <a href="assign.php?id=<?php echo $row["id"]; ?>">Add Students</a> </td> 
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