<?php
session_start();
$database_name = "";
$database_user = "";
$database_password = "";
include_once('rb.php');
R::setup( 'mysql:host=localhost;dbname='.$database_name,$database_user, $database_password ); 

if(isset($_SESSION['userid'])){
	$user = R::load('users', $_SESSION['userid']);
}
?>