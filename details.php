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

if(isset($_GET["vote"])){
$vote = R::dispense('votes');
$vote->userid = $_SESSION['userid'];
$vote->comment = $_GET["vote"];
$ff = R::store($vote);

$comm=1;

}

if(isset($_GET["delete"])){
$vote = R::load('comments',$_GET["delete"]);
R::trash( $vote ); 

$del=1;

}
$post = R::load('posts',$id);

if(isset($_POST["comment"])){

$comment = R::dispense('comments');
$comment->userid = $_SESSION['userid'];
$comment->date = date("Y-m-d");
$comment->content = $_POST["content"];
$comment->groupid = $post->groupid;
$comment->postid = $id;
$iff = R::store($comment);
 $success = 1;
 
}

$comments = R::getAll("SELECT * FROM comments WHERE postid=".$id);


$chk = R::findOne('groups',$user->role." = ?",[ $_SESSION['userid'] ]);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Post Details</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
.forum .forum-post-panel {
    margin-bottom: 1em;
}

.forum.media-list li img.avatar {
    display: block;
    margin: 0 auto;
}

.forum.media-list li .user-info {
    text-align: center;
    width: 8em;
}

@media (max-width: 760px) {
    .forum.media-list li .user-info {
        float: none;
        width: 100%;
        margin-bottom: 1em;
    }
}
    </style>
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
  <div class="alert alert-success" role="alert">Comment Posted Successfully</div>
  <?php
  }
  ?>
  <?php
  if(isset($comm) && $comm=="1"){
  ?>
  <div class="alert alert-success" role="alert">Comment Successfully Voted</div>
  <?php
  }
  ?>
  
  <?php
  if(isset($del) && $del=="1"){
  ?>
  <div class="alert alert-success" role="alert">Comment Successfully Deleted</div>
  <?php
  }
  ?>
  <div class="container">
  <h1 class="page-header"><i class="fa fa-pencil"></i> <?php echo $post->title; ?> <a class="btn btn-default" href="viewgroups.php?id=<?php echo $post->groupid; ?>"><i class="fa fa-backward"></i> Back to topics</a></h1>
 
  
  <ul class="media-list forum">
    <!-- Forum Post -->
    <li class="media well">
      <div class="pull-left user-info" href="#">
        
        <strong><?php $usr=R::load('users',$post->start_user); echo $usr->name; ?></strong><br>
        <small><?php echo $usr->role; ?></small>
        <br>
        
      </div>
      <div class="media-body">
        <!-- Post Info Buttons -->
        <div class="forum-post-panel btn-group btn-group-xs">
          <a href="#" class="btn btn-default"><i class="fa fa-clock-o"></i> Posted on <?php echo $post->date; ?></a>
          
        </div>
        <!-- Post Info Buttons END -->
        <!-- Post Text -->
        <p align="justify"><?php echo $post->content; ?></p>
        <!-- Post Text EMD -->
      </div>
    </li>
    <!-- Forum Post END -->
    
    <?php
    	foreach($comments as $row){
    ?>
    <!-- Forum Post -->
    <li class="media well">
      <div class="pull-left user-info" href="#">
        
        <strong><?php $usr=R::load('users',$row["userid"]); echo $usr->name; ?></strong>
        <small><?php echo $usr->role; ?></small>
        <br>
        <small class="btn-group btn-group-xs">
        <?php if(isset($chk->id) || $_SESSION['role']=="admin"){
          ?>
        <a class="btn btn-default" href="details.php?id=<?php echo $id; ?>&vote=<?php echo $row["id"]; ?>">+1 Point</a>
 	<?php
 	}
 	?>
        <strong class="btn btn-success">+<?php echo R::count('votes',"comment = ?",[ $row["id"] ]); ?> Points</strong>
        </small>
      </div>
      <div class="media-body">
        <!-- Post Info Buttons -->
        <div class="forum-post-panel btn-group btn-group-xs">
          <a href="#" class="btn btn-default"> Posted on <?php echo $row["date"]; ?></a>
          <?php if(isset($chk->id) || $_SESSION['role']=="admin"){
          ?>
          <a href="details.php?id=<?php echo $id; ?>&delete=<?php echo $row["id"]; ?>" class="btn btn-danger">Delete</a>
          <?php
          }
          ?>
        </div>
        <!-- Post Info Buttons END -->
        <!-- Post Text -->
        <p align="justify"><?php echo $row["content"]; ?></p>
        <!-- Post Text EMD -->
      </div>
    </li>
    <!-- Forum Post END -->
    <?php
    }
    ?>
    
    
  </ul>
</div>
  <div class="col-md-12 well">
  	<h3>Post Comment</h3>
  	<form action="details.php?id=<?php echo $id; ?>" method="post">
  	
  	<textarea name="content" style="width:100%;"></textarea>
  	<br/>
  	<input type="submit" name="comment" value="Post Comment" class="btn btn-primary">
  	</form>
  </div>
  
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