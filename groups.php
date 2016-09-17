<?php
include_once('includes/database.php');
if(!isset($_SESSION['userid'])){
header("Location: index.php");
die();
}
if(isset($_GET["join"])){
	if(isset($_GET["id"])){
		$check = R::findOne('enrollgroup',"userid = ? AND groupid = ?",[ $_SESSION['userid'],$_GET["id"] ]);
		if(isset($check->id)){
			$error=1;
		} else{
			$id = $_GET["id"];
			
			$enroll = R::dispense('enrollgroup');
			$enroll->userid = $_SESSION['userid'];
			$enroll->groupid = $id;
			$enroll->accepted = 0;
			if($_SESSION['role']=="admin"){
			$enroll->accepted = 1;
			}
			$dd = R::store($enroll);
			
			$success=1;
		}
	}
} else{
$error=2;
}
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
  <div class="alert alert-success" role="alert">Group Joined Successfully. Please Wait for Moderator to approve your Joining</div>
  <?php
  }
  ?>
  <?php
  if(isset($error) && $error=="1"){
  ?>
  <div class="alert alert-danger" role="alert">Group Already Joined</div>
  <?php
  }
  ?>
   
  
  <div class="col-md-12 col-xs-12">
    <center><h2>Joined Interest Groups</h2></center>
     <table class="table table-striped"> 
     <thead> 
     <tr> 
      
     <th>Group Name</th> 
     <th>Total Posts</th> 
     <th>Action</th> 
     </tr> 
     </thead> 
     
     <tbody> 
     
     <?php 
     foreach($enrolled as $row){
     $grr = R::findOne('groups',"id=?",[ $row["groupid"] ]);
     if(isset($grr->id)){
     ?>
     <tr> 
     
     <td><h3><?php $grp = R::load('groups',$row["groupid"]); echo $grp->name; ?></h3></td> 
     <td><?php echo R::count('posts',"groupid = ?",[ $row["groupid"] ]); ?> Posts</td> 
     <?php if($row["accepted"]==1){
     ?>
     <td><a href="viewgroups.php?id=<?php echo $row["id"]; ?>">View</a></td> 
     <?php
     } else{
     ?>
     <td><font color="red">Awaiting Acceptance</font></td> 
     <?php
     }
     ?>
     </tr> 
     <?php
     }}
     ?>
     
     </tbody> </table>
    </div>
    <hr/><hr/><br/><br/><br/>
    <div class="col-md-12 col-xs-12">
    <center><h2>All Interest Groups</h2></center>
     <table class="table table-striped"> 
     <thead> 
     <tr> 
      
     <th>Group Name</th> 
     <th>Total Posts</th> 
     <th>Action</th> 
     </tr> 
     </thead> 
     
     <tbody> 
     
     <?php 
     foreach($group as $row){
     ?>
     <tr> 
     
     <td><h3><?php echo $row["name"]; ?></h3></td> 
     <td><?php echo R::count('posts',"groupid = ?",[ $row["id"] ]); ?> Posts</td> 
     <td><a href="groups.php?join=1&id=<?php echo $row["id"]; ?>">Request To Join</a></td> 
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