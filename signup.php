<?php
session_set_cookie_params(3600,"/");
session_start();
echo "<br>Current Session: " , session_id();
?>
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
	require "verificationFunctions.php";
	
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
				exit();
			}
			else
			{
				echo '<br>Password is strong.<br>'; // Now store username and password
				storeNewUser($uname, $pass);
			}
		}
		else 
		{
			exit("User Already Exists");
		}
	}
?>
	