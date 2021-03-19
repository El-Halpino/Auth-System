<?php
	require "sqlFunctions.php";	
	require "sessionFunctions.php";
	require "verificationFunctions.php";
	
	checkSession();
	
	if(!$_SESSION['loggedIn'] == true)
	{
		header('location: login.php');
	}
	
	echo "Welcome " , $_SESSION['username'];
	echo "<br>User ID: " , $_SESSION['userID']; 
?>