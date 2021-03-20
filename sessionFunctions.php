<?php

// Destroys Current Session
function DestroySession() 
{
	$_SESSION[] = array();
	session_destroy();
	echo "Session Destroyed<br>";
}

// Checks if session has been started, if it hasn't start one	
function checkSession()
{
	header_remove("X-Powered-By"); 
	if(session_id() == '' || !isset($_SESSION))
	{
		session_set_cookie_params(3600,"/");
		session_start(['cookie_secure' => true, 'cookie_httponly' => true]);
		$_SESSION['currentSession'] = session_id();
	}
	else {
		session_start(['cookie_secure' => true, 'cookie_httponly' => true]);
	}
}

// Checks if user has been inactive for 10 minutes
function inactivityChecker()
{
	if(!isset($_SESSION['inactivityTimer']))
	{
		$_SESSION['inactivityTimer'] = time();
	}
	if(time() - $_SESSION['inactivityTimer'] > 600)
	{
		newEvent("Logout", "Timeout");
		DestroySession();
	}
	else {
		$_SESSION['inactivityTimer'] = time();
	}
}
?>