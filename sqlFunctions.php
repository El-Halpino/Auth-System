<?php

// Functions for sql CRUD operations

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
	// Insert Admin
	storeNewUser("ADMIN" , "SAD_2021!");
	// Create Event Log
	// eventid , type , description , dataoccured
	$sql = 'CREATE TABLE eventlog (
	eventID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	type VARCHAR (25) NOT NULL,
	description VARCHAR(255) NOT NULL,
	date DATETIME DEFAULT CURRENT_TIMESTAMP)';
	if(mysqli_query($link, $sql))
		{
			echo "<br>Table eventlog created successfully\n";
		} 
		else 
		{
			echo exit("Error creating table: " . mysqli_error($link) . "\n");
		}
	//Insert first event
	newEvent("Table Created", "First Event");
	mysqli_close($link);
}

//Add to event log
function newEvent($eventType, $eventDescription)
{
	checkSQL();
	$link = createLink();
	$sql = "INSERT INTO eventlog (type , description)
	VALUES ('$eventType', '$eventDescription')";
	if(mysqli_query($link, $sql))
		{
			mysqli_close($link);
		}
		else 
		{
			exit("Error inserting user: " . mysqli_error($link) . "\n");
		}	
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
	$salt = random_bytes(24);// create random salt
	$hashedSalt = md5($salt);
	$hashedPassword = md5($hashedSalt.$password); // created hashed password
	$sql = "INSERT INTO users (username, password, salt)
	VALUES ('$username', '$hashedPassword', '$hashedSalt')";
	if(mysqli_query($link, $sql))
		{
			newEvent("Signup", "Successful");
		}
	else 
		{
			exit("Error inserting user: " . mysqli_error($link) . "\n");
		}	
	mysqli_close($link);
}

// Checks if passwords match
function loginVerifyPassword($username,$password)
{
	checkSQL();
	$link = createLink();
	$sql = "SELECT id , username, password , salt FROM users";
	$result = $link->query($sql);
	if($result->num_rows > 0)
	{
		while($row = $result->fetch_assoc())
		{
			if($row['username'] == $username)
			{
				$salt = $row['salt'];
				$hashToCheck = md5($salt.$password);
				if($row['password'] == $hashToCheck)
				{ // Password matches, login successful, create authenticated session.
					$_SESSION['username'] = $username;
					$_SESSION['loggedIn'] = true;
					$_SESSION['userID'] = $row['id'];
					$_SESSION['sesTimer'] = time();
					if($username == "ADMIN")
					{
						$_SESSION['admin'] = true;
					}
					else 
					{
						$_SESSION['admin'] = false;
					}
					mysqli_close($link);
					return true; // passwords match
				}
			}
		}
		mysqli_close($link);
		return false; // passwords don't match
	}
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

function changePassword($uname , $newpassword)
{
	checkSQL();
	$link = createLink();
	$salt = random_bytes(24);// create random salt
	$hashedSalt = md5($salt);
	$hashedPassword = md5($hashedSalt.$newpassword); // created hashed password
	$sql = "UPDATE users SET password='$hashedPassword' , salt='$hashedSalt' WHERE username='$uname'";
	
	if($link->query($sql) === TRUE)
	{
		newEvent("Password Change", "Successful");
		return true;
	} 
	else 
	{
		$_SESSION['error'] = "Error updating password: " . $link->error;
		return false;
	}
}

?>