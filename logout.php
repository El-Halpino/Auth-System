<?php
	header("X-Frame-Options: SAMEORIGIN");
	require "sqlFunctions.php";	
	require "sessionFunctions.php";
	require "verificationFunctions.php";
	
	checkSession();
	if(!$_SESSION['loggedIn'] == true)
	{
		header('location: login.php');
	}
	inactivityChecker();
	if ($_SERVER["REQUEST_METHOD"] == "POST") // Check if POST has been sent
	{
		DestroySession(); // destroy session
		newEvent("Logout", "Successful");
		header('location: login.php'); // redirect user to login
	}
?>
<html>
	<head>
		<title>Logout</title>
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<div class = "formbox">
			<p>Are you sure you want to logout?<p>
			<form method="post" action="logout.php">
			<input type="submit" value="Logout" name="logout"/>
			</form>
			<a class="button" href="profile.php">No</button>
		</div>
	</body>
</html>