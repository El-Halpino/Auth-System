<?php
//cleans value of any unwanted characters
function sanitise($val)
{ // Santise any chars that might cause problems
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
				case "\\":
					$arr1[$x] = "&#x0005C;";
					break;
				case "$";
					$arr1[$x] = "&#x00024;";
					break;
				case "&";
					$arr1[$x] = "&#x00026;";
					break;
				case ":";
					$arr1[$x] = "&#x0003A;";
					break;
				case ";";
					$arr1[$x] = "&#x0003B;";
					break;
				case "\"";
					$arr1[$x] = "&#x00022;";
					break;
				case "'";
					$arr1[$x] = "&#x00060;";
					break;
				default:	
					break;
			}
		}
	$cleanVal = implode($arr1); 
	return $cleanVal ;
}

//Checks if password satifies password complexity rules
function passwordComplexity($password) // Boolean Function
{
	$uppercase = preg_match('@[A-Z]@', $password);
	$lowercase = preg_match('@[a-z]@', $password);
	$number    = preg_match('@[0-9]@', $password);
	$specialChars = preg_match('@[^\w]@', $password);

	if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) 
		{
			return false;
		}
	else
		{
			return true;
		}
}

?>