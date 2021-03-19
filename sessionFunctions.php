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
	if(session_id() == '' || !isset($_SESSION))
	{
		session_set_cookie_params(3600,"/");
		session_start();
		$_SESSION['currentSession'] = session_id();
	}
	else {
		session_start();
	}
}

function checkAuthentication()
{
	
}
?>