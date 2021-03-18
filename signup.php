<html>
<head><title>Signup</title></head>
<body>
<form method="post" action="signup.php">
		Username:<input type="text" name="username" required /><br>
		Password:<input type="text" name="password" required /><br>
		<input type="submit" value="Signup" name="signup"/><br>
	</form>
</body>
</html>
<?php
	require "sqlFunctions.php";	
	require "sessionFunctions.php";
	require "verificationFunctions.php";
	
	checkSession();
	
	if(isset($_POST["signup"])) 
	{
		checkSQL();
		$uname = sanitise($_POST['username']);
		$pass = sanitise($_POST['password']);
		if(checkIfUserExists($uname))
		{
			if(!passwordComplexity($pass))
			{
				echo '<script>alert("Password must be at least 8 characters long and must include at least one upper case letter, one number, and one special character.")</script>';
				header('location: signup.php');
			}
			else
			{
				echo '<br>Password is strong.<br>'; // Now store username and password
				storeNewUser($uname, $pass);
				header('location: login.php');
			}
		}
		else 
		{
			echo '<script>alert("User already exists")</script>';
		}
	}
?>
	