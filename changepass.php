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
		{ // if the current token is not equal to the one created at login, destroy session.
			DestroySession();
			header('location: login.php');
		}
		else {
			$pass = sanitise($_GET["password"]);
			$npass = sanitise($_GET["newpassword"]);
			$npass1 = sanitise($_GET["newpassword1"]);
			
			if(!$npass == $npass1) // Ensure new passwords are equal
			{
				$_SESSION['error'] = "New passwords do not match";
				newEvent("Password Change", "Denied");
				header('location: changepassword.php');
			}
			else if($npass == $pass) // New password cannot equal old
			{
				$_SESSION['error'] = "New password cannot match old one";
				newEvent("Password Change", "Denied");
				header('location: changepassword.php');
			}
			else if (!passwordComplexity($npass)) // Check Complexity
			{
				$_SESSION['error'] = "Password must be at least 8 characters long and must include at least one upper case letter, one number, and one special character.";
				newEvent("Password Change", "Denied");
				header('location: changepassword.php');
			}
			else // Passwords are fine, now verify password
			{
				$username = $_SESSION['username'];
				if(loginVerifyPassword($username, $pass))
				{ // Password verified
					if(changePassword($username , $npass))
					{
						destroySession();
						newEvent("Logout", "Successful");
						header('location: login.php');
					} else {
						header('location: changepassword.php');
					}
				}
				else { // Password unverified
					$_SESSION['error'] = "Password could not be authenticated";
					newEvent("Password Change", "Denied");
					header('location: changepassword.php');
				}
			}
		}
	}
?>