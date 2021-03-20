<?php
	header("X-Frame-Options: SAMEORIGIN");
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
				$_SESSION['error'] = "Password must be at least 8 characters long and must include at least one upper case letter, one number, and one special character.";
				newEvent("Signup", "Denied");
			}
			else
			{
				echo '<br>Password is strong.<br>'; // Now store username and password
				storeNewUser($uname, $pass);
				newEvent("Signup", "Successful");
				header('location: login.php');
			}
		}
		else 
		{
			newEvent("Signup", "Denied");
			$_SESSION['error'] = "User already exists";
		}
	}
?>
<html>
<head><title>Signup</title></head>
<link rel="stylesheet" href="style.css">
<body>
	<div class="formBox">
		<h2>Signup</h2>
		<?php if(isset($_SESSION['error'])) { ?>
		<p style="color: red;"><?= $_SESSION["error"];?></p>
		<?php unset($_SESSION["error"]); } ?>
		<form method="post" action="signup.php">
			<label for="username">Username:</lable>
			<input type="text" name="username" placeholder="Username" required /><br>
			<label for="password">Password:</lable>
			<input type="text" name="password" placeholder="Password" required /><br>
			<input type="submit" value="Signup" name="signup"/><br>
			<a href="login.php"> Login Page </button>
		</form>
	</div>
</body>

</html>