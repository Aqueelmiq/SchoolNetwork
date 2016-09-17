<?php
include_once('includes/database.php');
if(!isset($_SESSION['userid'])){
header("Location: index.php");
die();
}


if(!isset($_GET["id"])){
header("Location: groups.php");
die();
}
$id = $_GET["id"];


if(isset($_POST["post-enter"])){


$new = R::load('posts',$_POST["courseid"]);

$new->title = $_POST["title"];
$new->content = $_POST["content"];
$new->groupid = $id;
$new->start_user = $_SESSION['userid'];
$new->date = date("Y-m-d");

$dd = R::store($new);



header("Location: details.php?id=".$dd);
die();
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Post</title>

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
								<form id="login-form" action="new.php?id=<?php echo $id; ?>" method="post" role="form" style="display: block;">
									<div class="form-group">
										<input type="text" name="title" id="title" tabindex="1" class="form-control" placeholder="Enter Post Title">
									</div>
									<div class="form-group">
										<textarea name="content" rows="10" cols="25"></textarea>
									</div>
									
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
											<input type="hidden" name="courseid" value="<?php echo $det->id; ?>">
												<input type="submit" name="post-enter" id="course-submit" tabindex="4" class="form-control btn btn-login btn-primary" value="Post">
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