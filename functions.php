<?php
include 'connect.php';
function emailExists($email, $con) {
	/* Note per the docs, do not add terminating ; to the end of the SQL query*/
	$query  = "SELECT id FROM users WHERE email = '$email'";
	$result = mysqli_query($con, $query);
	if (mysqli_num_rows($result) == 1) {
		return true;
	} else {
		return false;
	}
}
