<html>
<head><title>Signup</title></head>
<body>
<?php
	require "functions.php";
	
	if(isset($_POST["signup"])) 
		{
			// Connect to sql
			$link = mysqli_connect('127.0.0.1', 'root', '');
			// Check if connection is good
			if (!$link) 
			{
					die('Failed to connect: ' . mysqli_connect_error());
			}
			
			$db_selected = mysqli_select_db($link, "my_db");
			//Check if DB exists
			if(!$db_selected) 
			{
				createDB();
			}
			
			$uname = sanitise($_POST['username']);
			$pass = sanitise($_POST['password']);
			echo $uname;
			mysqli_close($link);
		}
?>
	<form method="post" action="signup.php">
		Username:<input type="text" name="username"/><br>
		Password:<input type="text" name="password"/><br>
		<input type="submit" value="Signup" name="signup"/><br>
	</form>
</body>
</html>