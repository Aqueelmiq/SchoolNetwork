<?php
include_once('includes/database.php');
if(isset($_SESSION['role']) && $_SESSION['role']!="admin"){
header("Location: index.php");
die();
}



if(isset($_POST["query1"])){
$qq = R::getAll("SELECT * FROM posts WHERE groupid=".$_POST["group"]." ORDER BY date DESC LIMIT 5");
$data = "<h3>5 most recent discussions from a Group</h3><br/>";
foreach($qq as $row){
$data = $data."<br/>".$row["title"];
}
}

if(isset($_POST["hello2"])){
$qq = R::getAll("SELECT * FROM comments WHERE userid=".$_POST["student"]." ORDER BY date DESC LIMIT 5");
$data = "<h3>5 most recent discussions participated by student</h3><br/>";
foreach($qq as $row){
$data = $data."<br/>".$row["content"];
}
}

if(isset($_POST["hello3"])){
$qq = R::getAll("SELECT * FROM courses WHERE faculty=".$_POST["faculty"]);

$data = "<h3>Past Average GPA of  all courses of faculty</h3><br/>";
foreach($qq as $row){

$sum = R::getAll("SELECT SUM(grades) AS value_sum FROM enrollcourse WHERE completed=1 AND courseid=".$row["id"] ); 

$counted =R::count('enrollcourse',"completed=? AND courseid=?",[1,$row["id"]]);

$data = $data."<br/>Average GPA of Course ".$row["course"].": ".$sum[0]["value_sum"]/$counted;


}
}

if(isset($_POST["hello4"])){
$qq = R::getAll("SELECT postid, COUNT(postid) AS total FROM comments WHERE groupid=".$_POST["group"]." GROUP BY postid ORDER BY total DESC LIMIT 1");

$g = R::load('groups',$_POST["group"]);
$data = "<h3>Most Commented Post on a Group:".$g->name."</h3><br/>";
foreach($qq as $row){
$ps = R::load('posts',$row["postid"]);
$data = $data."<br/>".$ps->title;
}
}

if(isset($_POST["hello5"])){
$qq = R::getAll("SELECT * FROM courses");


$data = "<h3>All moderators and group/course moderated by them</h3><br/>";
foreach($qq as $row){

$st = R::load('users',$row["student"]);
$fc = R::load('users',$row["faculty"]);
$data = $data."Course Name".$qq["course"]." | Student Moderator:".$st->name." | Faculty Moderator:".$fc->name."<br/>";
}
$q1 = R::getAll("SELECT * FROM groups");
foreach($q1 as $row){

$st = R::load('users',$row["student"]);
$fc = R::load('users',$row["faculty"]);
$data = $data."Group Name".$qq["name"]." | Student Moderator:".$st->name." | Faculty Moderator:".$fc->name."<br/>";
}


}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Queries</title>

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
  echo $data;
  ?>
  
  
  
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