<form method="post" action="signup.php">
		<input type="submit" value="return" name="return"/><br>
</form>
<?php
	session_set_cookie_params(3600,"/");
	session_start();
	echo "<br>" , session_id();

	require "sqlFunctions.php";	
	require "sessionFunctions.php";
	require "verificationFunctions.php";

	checkSQL();

	if(!isset($_POST['username'], $_POST['password']) )
	{
		exit('Please fill in both username and password');
	}
	$uname = sanitise($_POST['username']);
	$pass = sanitise($_POST['password']);



?>

