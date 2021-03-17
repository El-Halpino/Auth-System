<?php

function createDB($link, $dbName)
{	
	$serverName = "localhost";
	$userName = 'root';
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
			echo exit("\nError creating database: " . mysqli_error($link) . "\n");
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
		} 
		else 
		{
			echo exit("Error creating table: " . mysqli_error($link) . "\n");
		}
	// Insert Test Data
	$sql = "INSERT INTO users (username , password)
	VALUES ('Test' , 'Test')";
	
	if(mysqli_query($link, $sql))
		{
			echo "Test data inserted successfully";
		}
		else 
		{
			echo exit("Error inserting test data: " . mysqli_error($link) . "\n");
		}	
	mysqli_close($link);
}

function checkSQL()
{
$serverName = "localhost";
$userName = 'root';
$dbName = 'my_db';
$link = mysqli_connect($serverName, $userName, '');
$db_selected = mysqli_select_db($link, "my_db");

if (!$link) // Check if connection is valid
	{
		exit('<br>Failed to connect: ' . mysqli_connect_error());
	}
if(!$db_selected) // Check if DB exists
	{
		createDB($link, $dbName);
	}
}

?>