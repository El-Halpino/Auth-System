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
	
	echo "Welcome " , $_SESSION['username'];
	echo "<br>User ID: " , $_SESSION['userID']; 
?>
<html>
	<head>
		<title>Change Password</title>
		<link rel="stylesheet" href="style.css">
	</head>
<body>
<div class = "formbox">
	<h2>Change Password</h2>
	<?php if(isset($_SESSION['error'])) { ?>
	<p style="color: red;"><?= $_SESSION["error"];?></p>
	<?php unset($_SESSION["error"]); } ?>
	<form method="GET" action="changepass.php">
		<label for="password">Password:</lable>
		<input type="text" name="password" placeholder="Password" required /><br>
		<label for="newpassword">New Password:</lable>
		<input type="text" name="newpassword" placeholder="Password" required /><br>
		<label for="newpassword1">Confirm New Password:</lable>
		<input type="text" name="newpassword1" placeholder="Password" required /><br>
		<input type="submit" value="submit" name="changePass"/><br>
	<a href="profile.php">Return to Profile</a>
	</form>
</div>
</body>
</html>

