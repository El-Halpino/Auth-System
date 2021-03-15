<?php

function DestroySession() 
	{
	$_SESSION[] = array();
	session_destroy();
	echo "Session Destroyed<br>";
	}
	
function GenerateNewID() 
	{
		//$number = $_SESSION["count"];
		//$number++;
		//$_SESSION["count"] = $number;
		session_regenerate_id();
	}
?>