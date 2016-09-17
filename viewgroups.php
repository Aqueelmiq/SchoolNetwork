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
$top = R::getAll("SELECT postid, COUNT(postid) AS total FROM comments WHERE groupid=".$_GET["id"]." GROUP BY postid ORDER BY total DESC LIMIT 5");
$all = R::getAll("SELECT * FROM posts WHERE groupid=".$_GET["id"]);

$group = R::getAll("SELECT * FROM groups");
$enrolled = R::getAll("SELECT * FROM enrollgroup WHERE userid=".$_SESSION['userid']);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Interst Groups</title>

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
    .forum.table > tbody > tr > td {
    vertical-align: middle;
}

.forum .fa {
    width: 1em;
    text-align: center;
}

.forum.table th.cell-stat {
    width: 6em;
}

.forum.table th.cell-stat-2x {
    width: 14em;
}
    </style>
  </head>
  <body>
<?php
include_once('nav.php');
?>
<div class="container">
  <div class="row">
  <div class="container" style="margin-top: 35px">
  <div class="page-header page-heading">
    <h1 class="pull-left">Forums <small> - <a href="new.php?id=<?php echo $id; ?>">Start New Topic</a></small></h1>
    <ol class="breadcrumb pull-right where-am-i">
      <li><a href="#">Forums</a></li>
      <li class="active">List of topics</li>
    </ol>
    <div class="clearfix"></div>
  </div>
  
  <table class="table forum table-striped">
    <thead>
      <tr>
        
        <th>
          <h3>Top Posts</h3>
        </th>
        <th class="cell-stat text-center hidden-xs hidden-sm">Comments</th>
        
        <th class="cell-stat-2x hidden-xs hidden-sm">Last Post</th>
      </tr>
    </thead>
    <tbody>
      <?php 
      foreach($top as $a){
   
      $pst = R::load('posts',$a["postid"]);
    ?>
      <tr>
        
        <td>
          <h4><a href="details.php?id=<?php echo $pst->id; ?>"><?php echo $pst->title; ?></a></h4>
        </td>
        <td class="text-center hidden-xs hidden-sm"><a href="details.php?id=<?php echo  $pst->id; ?>"><?php echo R::count('comments',"postid = ?",[  $pst->id ]); ?></a></td>
        
        <td class="hidden-xs hidden-sm">by <?php $one = R::findOne('comments',"postid = ?",[  $pst->id ]); if(isset($one->id)){ $usr = R::load('users',$one->userid); echo $usr->name; ?><br><small><i class="fa fa-clock-o"></i> <?php echo $one->date; } ?></small></td>
      </tr>
      
      <?php
      }
      ?>
      
    </tbody>
  </table>
  <table class="table forum table-striped">
    <thead>
      <tr>
        
        <th>
          <h3>All Posts</h3>
        </th>
        <th class="cell-stat text-center hidden-xs hidden-sm">Comments</th>
        
        <th class="cell-stat-2x hidden-xs hidden-sm">Last Post</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach($all as $row){
    ?>
      <tr>
        
        <td>
          <h4><a href="details.php?id=<?php echo $row["id"]; ?>"><?php echo $row["title"]; ?></a></h4>
        </td>
        <td class="text-center hidden-xs hidden-sm"><a href="details.php?id=<?php echo $row["id"]; ?>"><?php echo R::count('comments',"postid = ?",[ $row["id"] ]); ?></a></td>
        
        <td class="hidden-xs hidden-sm">by <?php $one = R::findOne('comments',"postid = ?",[ $row["id"] ]); if(isset($one->id)){ $usr = R::load('users',$one->userid); echo $usr->name; ?><br><small><i class="fa fa-clock-o"></i> <?php echo $one->date; } ?></small></td>
      </tr>
      
      <?php
      }
      ?>
    </tbody>
  </table>
  
</div>
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