<?php

// Functions for sql creation

// Returns link for connecting to SQL
function createLink()
{
	$serverName = "localhost";
	$userName = 'root';
	$dbName = 'my_db';
	$link = mysqli_connect($serverName, $userName, '', $dbName);
	return $link;
}

// Creates users table
function createTable()
{
	$link = createLink();
	
	$sql = 'CREATE TABLE users (
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	username VARCHAR(50) NOT NULL UNIQUE,
	password VARCHAR(255) NOT NULL,
	salt VARCHAR(255) NOT NULL,
	created_at DATETIME DEFAULT CURRENT_TIMESTAMP)';
		
	if(mysqli_query($link, $sql))
		{
			echo "<br>Table users created successfully\n";
		} 
		else 
		{
			echo exit("Error creating table: " . mysqli_error($link) . "\n");
		}
	// Insert Test Data
	storeNewUser("Test" , "TestPass12@#");
	mysqli_close($link);
}

// Creates DB my_db
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
			echo "<br>Database my_db created successfully\n"; // Now make users table
			createTable();
		} else {
			echo exit("\nError creating database: " . mysqli_error($link) . "\n");
		}
		
	}
	mysqli_close($link);
}

// Checks connection to SQL & checks if DB exists
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

// Hashes password with salt and stores user in DB
function storeNewUser($username , $password)
{
	checkSQL();
	$link = createLink();
	$salt = random_bytes(mt_rand(20,50)); // create random salt
	$hashedPassword = md5($salt, $password); // created hashed password
	
	$sql = "INSERT INTO users (username, password, salt)
	VALUES ('$username', '$hashedPassword', '$salt')";
	if(mysqli_query($link, $sql))
		{
			echo "<br>User Added";
		}
		else 
		{
			exit("Error inserting user: " . mysqli_error($link) . "\n");
		}	
	mysqli_close($link);
}

// Checks if username exists
function checkIfUserExists($username)
{
	checkSQL();
	$link = createLink();
	$sql = "SELECT username FROM users";
	$result = $link->query($sql);
	if($result->num_rows > 0)
	{
		while($row = $result->fetch_assoc())
		{
			if($row['username'] == $username)
			{
				return false; // User Exists, return false
			}
		}
		return true; // user does not exist, return true
	}
	mysqli_close($link);
}

?>