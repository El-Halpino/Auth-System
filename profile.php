<?php
	require "sqlFunctions.php";	
	require "sessionFunctions.php";
	require "verificationFunctions.php";
	
	checkSession();
	if(!$_SESSION['loggedIn'] == true)
	{
		header('location: login.php');
	}
	inactivityChecker();
	
	echo "Welcome " , $_SESSION['username'];
	echo "<br>User ID: " , $_SESSION['userID']; 
?>
<html>
	<head>
		<title>Profile</title>
		<link rel="stylesheet" href="style.css">
	</head>
<body>
	<br>
	<a href="logout.php"> Logout Page </a> <br>
	<a href="changepassword.php"> Change Password</a><br>
</body>
<?php
if ($_SESSION['admin'] == true)
{
	checkSQL();
	$link = createLink();
	$sql = "SELECT eventID , type , description, date FROM eventlog";
	$result = $link->query($sql);
	
	if($result->num_rows > 0) 
	{
		echo "<br>Event Log<br>";
		while($row = $result->fetch_assoc()) 
		{
			echo "<br>EventID: " . $row['eventID'] . " - Type: " . $row['type'] . " - Description: " . $row['description'] . " - Date: " . $row['date'] . "<br>";
		}
	}
	else {
		echo "No Events";
	}
}
?>
</html>

