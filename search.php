<?php
include_once('includes/database.php');

if(isset($_POST["search"])){
	$user = $_POST["username"];
	$chk = R::findOne('users',"email = ?",[$user]);
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="css/datepicker.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
    body {
    padding-top: 90px;
}
.panel-login {
	border-color: #ccc;
	-webkit-box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.2);
	-moz-box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.2);
	box-shadow: 0px 2px 3px 0px rgba(0,0,0,0.2);
}
.panel-login>.panel-heading {
	color: #00415d;
	background-color: #fff;
	border-color: #fff;
	text-align:center;
}
.panel-login>.panel-heading a{
	text-decoration: none;
	color: #666;
	font-weight: bold;
	font-size: 15px;
	-webkit-transition: all 0.1s linear;
	-moz-transition: all 0.1s linear;
	transition: all 0.1s linear;
}
.panel-login>.panel-heading a.active{
	color: #029f5b;
	font-size: 18px;
}
.panel-login>.panel-heading hr{
	margin-top: 10px;
	margin-bottom: 0px;
	clear: both;
	border: 0;
	height: 1px;
	background-image: -webkit-linear-gradient(left,rgba(0, 0, 0, 0),rgba(0, 0, 0, 0.15),rgba(0, 0, 0, 0));
	background-image: -moz-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
	background-image: -ms-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
	background-image: -o-linear-gradient(left,rgba(0,0,0,0),rgba(0,0,0,0.15),rgba(0,0,0,0));
}
.panel-login input[type="text"],.panel-login input[type="email"],.panel-login input[type="password"] {
	height: 45px;
	border: 1px solid #ddd;
	font-size: 16px;
	-webkit-transition: all 0.1s linear;
	-moz-transition: all 0.1s linear;
	transition: all 0.1s linear;
}
.panel-login input:hover,
.panel-login input:focus {
	outline:none;
	-webkit-box-shadow: none;
	-moz-box-shadow: none;
	box-shadow: none;
	border-color: #ccc;
}
.btn-login {
	background-color: #59B2E0;
	outline: none;
	color: #fff;
	font-size: 14px;
	height: auto;
	font-weight: normal;
	padding: 14px 0;
	text-transform: uppercase;
	border-color: #59B2E6;
}
.btn-login:hover,
.btn-login:focus {
	color: #fff;
	background-color: #53A3CD;
	border-color: #53A3CD;
}
.forgot-password {
	text-decoration: underline;
	color: #888;
}
.forgot-password:hover,
.forgot-password:focus {
	text-decoration: underline;
	color: #666;
}

.btn-register {
	background-color: #1CB94E;
	outline: none;
	color: #fff;
	font-size: 14px;
	height: auto;
	font-weight: normal;
	padding: 14px 0;
	text-transform: uppercase;
	border-color: #1CB94A;
}
.btn-register:hover,
.btn-register:focus {
	color: #fff;
	background-color: #1CA347;
	border-color: #1CA347;
}


    </style>
  </head>
  <body>
   <div class="container">
    	<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-login">
					
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<form id="login-form" action="search.php" method="post" role="form" style="display: block;">
									<div class="form-group">
										<input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Enter Email address" value="">
									</div>
									
									
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="submit" name="search" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Search User">
											</div>
										</div>
									</div>
									
								</form>
								
								
								
							</div>
							
							<?php
								if(isset($chk->id)){
							?>
							
							<div class="container">
							  <div class="row">
							    <div class="col-md-8 col-xs-10">
							      <div class="well panel panel-default">
							        <div class="panel-body">
							          <div class="row">
							            
							            <!--/col--> 
							            <div class="col-xs-12 col-sm-8">
							              <h2><?php echo $chk->name; ?></h2>
							              <p><strong>Email </strong> <?php echo $chk->email; ?> </p>
							              <p><strong>Role: </strong> <?php echo $chk->role; ?> </p>
							              <?php
							              if($chk->role=="student"){
							              $fnd = R::findOne('student',"userid = ?",[$chk->id]);
							              ?>
							              <p><strong>Degree: </strong> <?php echo $fnd->degree_taken; ?> </p>
							              <p><strong>Degree Year: </strong> <?php echo $fnd->degree_year; ?> </p>
							              <p><strong>Degree Status: </strong> <?php echo $fnd->degree_status; ?> </p>
							              <p><strong>Degree Semester: </strong> <?php echo $fnd->semester; ?> </p>
							              <?php
							              }
							              ?>
							              <?php
							              if($chk->role=="faulty"){
							              $fnd = R::findOne('faculty',"userid = ?",[$chk->id]);
							              ?>
							              <p><strong>Experience: </strong> <?php echo $fnd->experience; ?> </p>
							              <p><strong>Projects: </strong> <?php echo $fnd->Projects; ?> </p>
							              <p><strong>Position: </strong> <?php echo $fnd->position; ?> </p>
							             
							              <?php
							              }
							              ?>
							            </div>
							            <!--/col-->          
							            <div class="clearfix"></div>
							            
							            <!--/col-->
							          </div>
							          <!--/row-->
							        </div>
							        <!--/panel-body-->
							      </div>
							      <!--/panel-->
							    </div>
							    <!--/col--> 
							  </div>
							  <!--/row--> 
							</div>
							<!--/container-->
								
							<?php
								} else{
							?>	
							<p>No User Find</p>	
							<?php	
								}
							?>
							
						</div>
					</div><center><a href="index.php" class="btn btn-primary">Back to Website</a></center>
				</div>
			</div>
			
		</div>
	</div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>    
    <script src="js/bootstrap.min.js"></script>
 
    <script src="js/date.js"></script>
    <script type="text/javascript">
										            $(function () {
										                $('#datetimepicker1').datetimepicker({
                format: 'YYYY-MM-DD'
            });
										            });
										        </script>
    <script>
     <script type="text/javascript">
										            $(function () {
										                $('#datetimepicker2').datetimepicker({
                format: 'YYYY-MM-DD'
            });
										            });
										        </script>
    <script>
	    $(function() {
	
	    $('#login-form-link').click(function(e) {
			$("#login-form").delay(100).fadeIn(100);
	 		$("#register-form").fadeOut(100);
			$('#register-form-link').removeClass('active');
			$("#faculty-register-form").fadeOut(100);
			$('#faculty-form-link').removeClass('active');
			$(this).addClass('active');
			e.preventDefault();
		});
		$('#register-form-link').click(function(e) {
			$("#register-form").delay(100).fadeIn(100);
	 		$("#login-form").fadeOut(100);
			$('#login-form-link').removeClass('active');
			$("#faculty-register-form").fadeOut(100);
			$('#faculty-form-link').removeClass('active');

			$(this).addClass('active');
			e.preventDefault();
		});
		$('#faculty-form-link').click(function(e) {
			$("#faculty-register-form").delay(100).fadeIn(100);
	 		$("#login-form").fadeOut(100);
			$('#login-form-link').removeClass('active');
			$("#register-form").fadeOut(100);
			$('#register-form-link').removeClass('active');
			$(this).addClass('active');
			e.preventDefault();
		});
		
	
	});


    </script>
  </body>
</html>