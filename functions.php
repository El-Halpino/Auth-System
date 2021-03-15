<?php

function sanitise($val)
{
	$arr1 = str_split($val) ;
	
	for($x = 0; $x < count($arr1); $x ++)
		{
			switch ($arr1[$x]) 
			{
				case "<":
					$arr1[$x] = "&#x0003C;";
					break;
				case ">":
					$arr1[$x] = "&#x0003E;";
					break;
				case "(":
					$arr1[$x] = "&#x00028;";
					break;
				case ")":
					$arr1[$x] = "&#x00029;";
					break;
				case "/":
					$arr1[$x] = "&#x0002F;";
					break;
				case "$";
					$arr1[$x] = "&#x00024;";
					break;
				case "&";
					$arr1[$x] = "&#x00026;";
					break;
				default:	
					break;
			}
		}
	$cleanVal = implode($arr1); 
	return $cleanVal ;
}

function createDB()
{	
	$serverName = "localhost";
	$userName = 'root';
	$link = mysqli_connect($serverName, $userName, '');
	
	$dbName = 'my=_db';
	$db_selected = mysqli_select_db($link, $dbName);
	
	if(!$db_selected) 
	{
		// Create DB
		$sql = 'CREATE DATABASE my_db';
		
		if(mysqli_query($link, $sql)) 
		{
			echo "Database my_db created successfully\n"; // Now make users table
			createTable($serverName, $userName, $dbName);
		} else {
			echo "\nError creating database: " . mysqli_error($link) . "\n";
		}
	}
	mysqli_close($link);
}

function createTable($serverName, $userName, $dbName)
{
	$link = mysqli_connect($serverName, $userName, '', $dbName);
	
	// Create Table
	$sql = 'CREATE TABLE users (
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	username VARCHAR(50) NOT NULL UNIQUE,
	password VARCHAR(255) NOT NULL,
	created_at DATETIME DEFAULT CURRENT_TIMESTAMP)';
		
	if(mysqli_query($link, $sql))
		{
			echo "Table users created successfully\n";
		} else {
			echo "Error creating table: " . mysqli_error($link) . "\n";
		}
	mysqli_close($link);
}

?>