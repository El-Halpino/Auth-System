<?php
	require "sqlFunctions.php";	
	require "sessionFunctions.php";
	require "verificationFunctions.php";
	checkSession();
	
	if(isset($_SESSION['locked'])) // Check if user is locked
	{
		$difference = time() - $_SESSION['locked'];
		if ($difference > 180)
		{
			unset($_SESSION['locked']);
			unset($_SESSION['loginAttempts']);
		}
	}
	
	if(!isset($_SESSION['loginAttempts'])) 
	{
		$_SESSION['loginAttempts'] = 0; // Initialise Variable 
	}
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") // Check if POST has been sent
	{
		if(!isset($_POST['username'], $_POST['password']) )
		{
			exit('Please fill in both username and password');
		}
		$uname = sanitise($_POST['username']);
		$pass = sanitise($_POST['password']);
		
		if(loginVerifyPassword($uname,$pass) == true)
		{
			unset($_SESSION['locked']);
			unset($_SESSION['loginAttempts']);
			header('location: profile.php');
		}
		else
		{
			$_SESSION['loginAttempts'] +=1;
			$_SESSION['error'] = "The username " . $uname . " and password could not be authenticated";
		}
	}

?>
<html>
	<head>
		<title>Login</title>
		<link rel="stylesheet" href="style.css">
	</head>
<body>
<div class = "formbox">
	<h2>Login</h2>
	<form method="post" action="login.php">
	<?php if(isset($_SESSION['error'])) { ?>
	<p style="color: red;"><?= $_SESSION["error"];?></p>
	<?php unset($_SESSION["error"]); } ?>
		<label for="username">Username:</lable>
		<input type="text" name="username" placeholder="Username" required /><br>
		<label for="password">Password:</lable>
		<input type="text" name="password" placeholder="Password" required /><br>
		<?php
			if($_SESSION['loginAttempts'] > 4) {
				$_SESSION['locked'] = time();
				echo "<p>Too many failed logins, Please wait 3 minutes</p>";
			} else {
		?>
		<input type="submit" value="Login" name="login"/><br>
			<?php } ?>
		<a href="signup.php"> Signup Page </button>
	</form>
</div>
</body>
</html>