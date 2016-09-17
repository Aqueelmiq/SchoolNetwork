<?php
include_once('includes/database.php');

if(!isset($_SESSION['userid'])){
	header("Location: login.php");
	die();
}

if(isset($_GET["approve"])){
	if(isset($_GET["id"])){
		
			$id = $_GET["id"];
			
			$enroll = R::load('enrollgroup',$id);
			
			$enroll->accepted = 1;
			R::store($enroll);
			
			$success=1;
		
	}
} else{
$error=2;
}
$user = R::load('users',$_SESSION['userid']);
$check = R::findOne($user->role,"userid = ?",[$user->id]);
$coursee = R::getAll("SELECT * FROM enrollcourse WHERE completed=0 AND userid=".$_SESSION['userid']);

$grou = R::getAll("SELECT * FROM enrollgroup WHERE userid=".$_SESSION['userid']);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Main Page</title>

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
  <div class="alert alert-success" role="alert">Action Successfully performed</div>
  <?php
  }
  ?>
    <div class="col-md-12 col-xs-12">
      <div class="well panel panel-default">
        <div class="panel-body">
          <div class="row">
            
            <!--/col--> 
            <div class="col-xs-12 col-sm-8">
              <h2><?php echo $user->name; ?></h2>
              <p><strong>email: </strong> <?php echo $user->email; ?> </p>
              <p><strong>D.O.B: </strong> <?php echo $user->dob; ?> </p>
              <?php
              if($user->role=="faculty"){
              ?>
              <p><strong>Position: </strong><?php echo $check->position; ?> </p>
              <p><strong>Experience: </strong><?php echo $check->experience; ?> </p>
              <p><strong>Projects: </strong><?php echo $check->Projects; ?> </p>
 
              </div>
              <?php
              }
              ?>
              <?php
              if($user->role=="student"){
              ?>
              <p><strong>Degree: </strong><?php echo $check->degree_taken; ?> </p>
              <p><strong>Degree Status: </strong><?php echo $check->degree_status; ?> </p>
              <p><strong>Degree Year: </strong><?php echo $check->degree_year; ?> </p>
              <p><strong>Semester: </strong><?php echo $check->semester; ?> </p>
              
            </div>
            <!--/col-->          
            <div class="clearfix"></div>
            <div class="col-xs-12 col-sm-4">
              <h2><strong> <?php $sum = R::getAll("SELECT SUM(grades) AS value_sum FROM enrollcourse WHERE completed=1 AND userid=".$_SESSION['userid'] ); $counted =R::count('enrollcourse',"completed=? AND userid=?",[1,$_SESSION['userid']]);  echo $sum[0]["value_sum"]/$counted;  ?> </strong></h2>
              <p><small>CGPA</small></p>
             
            </div>
            <!--/col-->
            <div class="col-xs-12 col-sm-4">
              <h2><strong><?php echo R::count('enrollcourse',"userid = ? AND completed = ?",[$_SESSION['userid'],0]); ?></strong></h2>
              <p><small>Current Courses</small></p>
             
            </div>
            <!--/col-->
            <div class="col-xs-12 col-sm-4">
              <h2><strong><?php echo R::count('enrollgroup',"userid = ?",[ $_SESSION['userid']]); ?></strong></h2>
              <p><small>Interest Groups</small></p>
             
            </div>
            <!--/col-->
            <?php
              }
              ?>
          </div>
          <!--/row-->
        </div>
        <!--/panel-body-->
      </div>
      <!--/panel-->
    </div>
    <!--/col--> 
    <?php 
    if(isset($_SESSION['role']) && $_SESSION['role']=="student"){
    ?>
    <div class="col-md-6 col-xs-12">
    	<h3>Interest Groups Joined</h3>
    	<table class="table table-striped"> 
     <thead> 
     <tr> 
      
     <th>Group Name</th> 
     <th>Total Posts</th> 
     <th>Action</th> 
     </tr> 
     </thead> 
     
     <tbody> 
     <?php foreach($grou as $row){
     $grr = R::findOne('groups',"id=?",[ $row["groupid"] ]);
     if(isset($grr->id)){
     ?>
     <tr> 
     
     <td><?php $gr = R::load('groups',$row["groupid"]); echo $gr->name; ?></td> 
     <td><?php echo R::count('posts',"groupid = ?",[$row["groupid"]]); ?> </td> 
     <td><a href="viewgroups.php?id=<?php echo $row["groupid"]; ?>">View</a></td> 
     </tr> 
     <?php
     }}
     ?>
     
     </tbody> </table>
    </div>
    
     <div class="col-md-6 col-xs-12">
    	<h3>Current Courses</h3>
    	<table class="table table-striped"> 
     <thead> 
     <tr> 
      
     <th>Course</th> 
     <th>Faculty</th> 
    
     </tr> 
     </thead> 
     
     <tbody> 
     <?php foreach($coursee as $row){
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
    <?php 
    }
    ?>
    
    
    
      <?php
    if($_SESSION['role']=="faculty"){
    $modchk = R::findAll('courses',$user->role." = ?",[ $_SESSION['userid'] ]);
    
    ?>
    <div class="col-md-12 col-xs-12">
    	<h3>Courses Moderated</h3>
    	<table class="table table-striped"> 
     <thead> 
     <tr> 
      
     <th>Course</th> 

     <th>Action</th> 
     
     </tr> 
     </thead> 
    <tbody>
    <?php
    
    
    foreach($modchk as $a){
    ?>
     
    
     <tr> 
     
     <td><?php echo $a["course"]; ?></td> 
 
     
     <td><a href="grades.php?id=<?php echo $a["id"]; ?>">Assign Grades<a></td> 
     
     </tr> 
    
     
     
    <?php
    }
    ?>
    </tbody> </table>
    
    </div><?php
    }
    ?>
    
    
    
    
    
    <?php
    $modchk = R::findOne('groups',$user->role." = ?",[ $_SESSION['userid'] ]);
    if(isset($modchk->id)){
    ?>
    <div class="col-md-12 col-xs-12">
    	<h3>Group Moderation - Accept Users Joining Request</h3>
    	<table class="table table-striped"> 
     <thead> 
     <tr> 
      
     <th>Group</th> 
     <th>Student Name</th> 
     
     <th>Action</th> 
     
     </tr> 
     </thead> 
    <tbody>
    <?php
    $check = R::findAll('groups',$user->role." = ?",[ $_SESSION['userid'] ]);
    
    foreach($check as $a){
    ?>
     
     <?php
     $requests = R::getAll("SELECT * FROM enrollgroup WHERE accepted=0 AND groupid=".$a["id"]);
     ?>
      
     <?php foreach($requests as $row){
     ?>
     <tr> 
     
     <td><?php $grp = R::load('groups',$row["groupid"]); echo $grp->name; ?></td> 
     <td><?php $use = R::load('users',$row["userid"]); echo $use->name; ?></td> 
     
     <td><a href="index.php?approve=1&id=<?php echo $row["id"]; ?>">Approve<a></td> 
     
     </tr> 
     <?php
     }
     ?>
     
     
    <?php
    }
    ?>
    </tbody> </table>
    
    </div>
    <?php
    }
    ?>
    
    
    
    
    
    
  
      <?php
    if($_SESSION['role']=="admin"){
    
    $groups = R::getAll("SELECT * FROM groups");
    $students = R::getAll("SELECT * FROM users WHERE role='student'");
    $fac = R::getAll("SELECT * FROM users WHERE role='faculty'");
    ?>
    <div class="col-md-12 col-xs-12">
    	<h3>5 most recent discussions from a Group</h3>
    	
    
    <form action="query.php" method="post">
    <select name="group">
    <?php
    foreach($groups as $row){
    ?>
    <option value="<?php echo $row["id"] ?>"><?php echo $row["name"] ?></option>
    <?php
    }
    ?>
    </select>
    <input type="submit" name="query1" value="submit">
    </form>
    <hr/><br/>
    </div>
    
      <div class="col-md-12 col-xs-12">
    	<h3>5 most recent discussions participated by student</h3>
    	
    
    <form action="query.php" method="post">
    <select name="student">
    <?php
    foreach($students as $row){
    ?>
    <option value="<?php echo $row["id"] ?>"><?php echo $row["name"] ?></option>
    <?php
    }
    ?>
    </select>
    <input type="submit" name="hello2" value="submit">
    </form>
    <hr/><br/>
    </div>
    
    <div class="col-md-12 col-xs-12">
    	<h3>Past Average GPA of  all courses of faculty</h3>
    	
    
    <form action="query.php" method="post">
    <select name="faculty">
    <?php
    
    foreach($fac as $row){
    ?>
    <option value="<?php echo $row["id"] ?>"><?php echo $row["name"] ?></option>
    <?php
    }
    ?>
    </select>
    <input type="submit" name="hello3" value="submit">
    </form>
    <hr/><br/>
    </div>
    
    <div class="col-md-12 col-xs-12">
    	<h3>Most Commented Post on a Group</h3>
    	
    
    <form action="query.php" method="post">
    <select name="group">
    <?php
    
    foreach($groups as $row){
    ?>
    <option value="<?php echo $row["id"] ?>"><?php echo $row["name"] ?></option>
    <?php
    }
    ?>
    </select>
    <input type="submit" name="hello4" value="submit">
    </form>
    <hr/><br/>
    </div>
    
    <div class="col-md-12 col-xs-12">
    	<h3>All moderators and group/course moderated by them</h3>
    	
    
    <form action="query.php" method="post">
    
    <input type="submit" name="hello5" value="submit">
    </form>
    <hr/><br/>
    </div>
    
    <?php
    }
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