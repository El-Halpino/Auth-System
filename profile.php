<?php
	require "sqlFunctions.php";	
	require "sessionFunctions.php";
	require "verificationFunctions.php";
	
	checkSession();
	if(!$_SESSION['loggedIn'] == true)
	{
		header('location: login.php');
	}
	inactivityChecker();
	
	echo "Welcome " , $_SESSION['username'];
	echo "<br>User ID: " , $_SESSION['userID']; 
?>
<html>
	<head>
		<title>Profile</title>
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
	<br>
	<a href="logout.php"> Logout Page </a> <br>
	<a href="changepassword.php"> Change Password</a>
	</body>
</html>

