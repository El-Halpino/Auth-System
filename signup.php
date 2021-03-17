<?php
session_set_cookie_params(3600,"/");
session_start();
echo "<br>" , session_id();
?>
<html>
<head><title>Signup</title></head>
<body>
<?php
	require "sqlFunctions.php";
	require "verificationFunctions.php";
	
	if(isset($_POST["signup"])) 
		{
			checkSQL();
			$uname = sanitise($_POST['username']);
			$pass = sanitise($_POST['password']);
			
		}
?>
	<form method="post" action="signup.php">
		Username:<input type="text" name="username" required /><br>
		Password:<input type="text" name="password" required /><br>
		<input type="submit" value="Signup" name="signup"/><br>
	</form>
</body>
</html>