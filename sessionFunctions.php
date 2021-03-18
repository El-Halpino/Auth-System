<?php

// Destroys Current Session
function DestroySession() 
	{
	$_SESSION[] = array();
	session_destroy();
	echo "Session Destroyed<br>";
	}

// Generates New Session ID
function GenerateNewID() 
	{
		//$number = $_SESSION["count"];
		//$number++;
		//$_SESSION["count"] = $number;
		session_regenerate_id();
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
}

function checkAuthentication()
{
	
}
?>