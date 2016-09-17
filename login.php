<?php
include_once('includes/database.php');


if(isset($_SESSION['userid'])){
	header("Location: index.php");
	die();
}


if(isset($_POST["login"])){

$password = $_POST["password"];
$username = $_POST["username"];
$check = R::findOne('users', ' email = ? ', [ $username ] );

if($check["id"]!=""){

	$stored_hash = $check["password"];
	
	if ($stored_hash==$password) {
	$_SESSION['userid'] = $check["id"];
	
	$_SESSION['role'] = $check->role;
	
	header("Location: index.php");
	die();
} else{
$error=2;
}
} else{
$error=3;
}
}
if(isset($_POST["register-student"])){
	
	$name = $_POST["username"];
	$email = $_POST["email"];
	$password = $_POST["password"];
	$dob = $_POST["dob"];
	$degree = $_POST["degree"];
	$degree_status = $_POST["dStatus"];
	$degree_year = $_POST["dYear"];
	$semester = $_POST["dSem"];
	
	$new = R::dispense('users');
	$new->name = $name;
	$new->email = $email;
	$new->password = $password;
	$new->dob = $dob;
	$new->active = 1;
	$new->role = "student";
	$id = R::store($new);
	
	$details = R::dispense('student');
	$details->userid = $id;
	$details->degree_taken = $degree;
	$details->degree_status = $degree_status;
	$details->degree_year = $degree_year;
	$details->semester = $semester;
	$df = R::store($details);
	
	$_SESSION['userid']=$id;
	$_SESSION['role'] = "student";
	header("Location: index.php");
	die();

}
if(isset($_POST["register-faculty"])){
	
	$name = $_POST["username"];
	$email = $_POST["email"];
	$password = $_POST["password"];
	$dob = $_POST["dob"];
	$pos = $_POST["position"];
	$pro = $_POST["projects"];
	$exp = $_POST["experience"];
	
	
	$new = R::dispense('users');
	$new->name = $name;
	$new->email = $email;
	$new->password = $password;
	$new->dob = $dob;
	$new->active = 1;
	$new->role = "faculty";
	$id = R::store($new);
	
	$details = R::dispense('faculty');
	$details->userid = $id;
	$details->position = $pos;
	$details->projects = $pro;
	$details->experience = $exp;
	$df = R::store($details);
	
	$_SESSION['userid']=$id;
	$_SESSION['role'] = "faculty";
	header("Location: index.php");
	die();

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
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-4">
								<a href="#" class="active" id="login-form-link">Login</a>
							</div>
							<div class="col-xs-4">
								<a href="#" id="register-form-link">Student Register</a>
							</div>
							<div class="col-xs-4">
								<a href="#" id="faculty-form-link">Faculty Register</a>
							</div>
						</div>
						<hr>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<form id="login-form" action="login.php" method="post" role="form" style="display: block;">
									<div class="form-group">
										<input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Email address" value="">
									</div>
									<div class="form-group">
										<input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password">
									</div>
									
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="submit" name="login" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Log In">
											</div>
										</div>
									</div>
									
								</form>
								
								
								<form id="register-form" action="login.php" method="post" role="form" style="display: none;">
									<div class="form-group">
										<input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Name" value="">
									</div>
									<div class="form-group">
										<input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="Email Address" value="">
									</div>
									<div class="form-group">
										<input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password">
									</div>
									<div class="form-group">
									
										<div class="container">
										    <div class="row">
										        <div class='col-sm-6'>
										            <div class="form-group">
										                <div class='input-group date' id='datetimepicker1'>
										                    <input type='text' name='dob' placeholder='Date Of Birth' class="form-control" />
										                    <span class="input-group-addon">
										                        <span class="glyphicon glyphicon-calendar"></span>
										                    </span>
										                </div>
										            </div>
										        </div>
										        
										    </div>
										</div>
									</div>
									<div class="form-group">
										<input type="text" name="degree" id="degree" tabindex="1" class="form-control" placeholder="Degree Taken" value="">
									</div>
									<div class="form-group">
										<select name="dStatus" class="form-control">
											<option> - Status of Degree - </option>
											<option value="enrolled">Enrolled</option>
											<option value="received">Received</option>
										</select>
									</div>
									<div class="form-group">
										<select name="dYear" class="form-control">
											<option> - Year of your Degree - </option>
											<option value="year1"> Year 1</option>
											<option value="year2"> Year 2</option>
										    <option value="year3"> Year 3</option>
										    <option value="year4"> Year 4</option>
										    </select>
									</div>
									<div class="form-group">
										<select name="dSem" class="form-control">
											<option> - Semester - </option>
											<option value="sem1"> Fall</option>
											<option value="sem2"> Spring</option>
										    <option value="sem3"> Summer</option>
										    </select>
									</div>
									
									
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="submit" name="register-student" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Register Now">
											</div>
										</div>
									</div>
								</form>
								<form id="faculty-register-form" action="login.php" method="post" role="form" style="display: none;">
									<div class="form-group">
										<input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Name" value="">
									</div>
									<div class="form-group">
										<input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="Email Address" value="">
									</div>
									<div class="form-group">
										<input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password">
									</div>
									<div class="form-group">
									
										<div class="container">
										    <div class="row">
										        <div class='col-sm-6'>
										            <div class="form-group">
										                <div class='input-group date' id='datetimepicker2'>
										                    <input type='text' name='dob' placeholder='Date Of Birth' class="form-control" />
										                    <span class="input-group-addon">
										                        <span class="glyphicon glyphicon-calendar"></span>
										                    </span>
										                </div>
										            </div>
										        </div>
										        
										    </div>
										</div>
									</div>
									<div class="form-group">
										<input type="text" name="position" id="position" tabindex="1" class="form-control" placeholder="Position" value="">
									</div>
									<div class="form-group">
										<input type="text" name="projects" id="projects" tabindex="1" class="form-control" placeholder="Projects" value="">
									</div>
									<div class="form-group">
										<input type="text" name="experience" id="experience" tabindex="1" class="form-control" placeholder="Experience" value="">
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="submit" name="register-faculty" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Register Now">
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div><center><a href="search.php" class="btn btn-primary">Search Users</a></center>
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