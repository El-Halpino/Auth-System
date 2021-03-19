<?php
	require "sqlFunctions.php";	
	require "sessionFunctions.php";
	require "verificationFunctions.php";
	
	checkSession();
	$token = isset($_SESSION['changePassToken']) ? $_SESSION['changePassToken'] : "";
	if(!$_SESSION['loggedIn'] == true)
	{
		header('location: login.php');
	}
	inactivityChecker();

if ($_SERVER["REQUEST_METHOD"] == "GET") // Check if GET has been sent
	{
		if($token != $_SESSION['changePassToken'])
		{
			DestroySession();
			header('location: login.php');
		}
		else {
			$pass = sanitise($_GET["password"]);
			$npass = sanitise($_GET["newpassword"]);
			$npass1 = sanitise($_GET["newpassword1"]);
			
			if(!$npass == $npass1) // Ensure passwords are equal
			{
				$_SESSION['error'] = "New passwords do not match";
				header('location: changepassword.php');
			}
			else if (!passwordComplexity($npass)) // Check Complexity
			{
				$_SESSION['error'] = "Password must be at least 8 characters long and must include at least one upper case letter, one number, and one special character.";
				header('location: changepassword.php');
			}
			else 
			{
				$username = $_SESSION['username'];
				if(loginVerifyPassword($username, $pass))
				{ // Password verified
					if(changePassword($username , $npass))
					{
						destroySession();
						header('location: login.php');
					} else {
						header('location: changepassword.php');
					}
				}
				else { // Password unverified
					$_SESSION['error'] = "Password could not be authenticated";
					header('location: changepassword.php');
				}
			}
		}
	}
	
?>