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
$det = R::load('courses',$id);
$faculty = R::getAll("SELECT * FROM users WHERE role='faculty'");
$student = R::getAll("SELECT * FROM users WHERE role='student'");


if(isset($_POST["course-enter"])){
$course = $_POST["course"];

$new = R::load('courses',$_POST["courseid"]);
$new->course = $course;
$new->faculty = $_POST["faculty"];
$new->student = $_POST["student"];
R::store($new);

$check = R::findOne('groups',"courseid = ?",[$_POST["courseid"]]);
if(isset($check->id)){
	$neww = R::load('groups',$check->id);
	
	$neww->faculty = $_POST["faculty"];
	$neww->student = $_POST["student"];
	R::store($neww);
}

header("Location: manage-courses.php?edit=1");
die();
}

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
  
  
  <div class="panel-body">
						<div class="row">
							<div class="col-lg-6 well">
							<h3>Edit Course</h3>
								<form id="login-form" action="editcourse.php?id=<?php echo $id; ?>" method="post" role="form" style="display: block;">
									<div class="form-group">
										<input type="text" name="course" id="course" tabindex="1" class="form-control" value="<?php echo $det->course; ?>">
									</div>
									<div class="form-group">
										<select name="faculty" class="form-control">
											<option> - Select Prof for Moderation - </option>
											<?php
											foreach($faculty as $row){
											?>
											<option value="<?php echo $row["id"]; ?>" <?php if($det->faculty==$row["id"]){ echo "selected"; } ?>><?php echo $row["name"]; ?></option>
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
											<option value="<?php echo $row["id"]; ?>" <?php if($det->student==$row["id"]){ echo "selected"; } ?>><?php echo $row["name"]; ?></option>
											<?php
											}
											?>
											
										</select>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
											<input type="hidden" name="courseid" value="<?php echo $det->id; ?>">
												<input type="submit" name="course-enter" id="course-submit" tabindex="4" class="form-control btn btn-login btn-primary" value="Edit Course">
											</div>
										</div>
									</div>
									
								</form>
						</div>
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