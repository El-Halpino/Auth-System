<?php
	require "sqlFunctions.php";	
	require "sessionFunctions.php";
	require "verificationFunctions.php";
	
	checkSession();

	if(!isset($_POST['username'], $_POST['password']) )
	{
		exit('Please fill in both username and password');
	}
	$uname = sanitise($_POST['username']);
	$pass = sanitise($_POST['password']);
	
	if(loginVerifyPassword($uname,$pass))
	{
		header('location: profile.php');
	}
	else 
	{
		header('location: login.php');
	}
	
?>

