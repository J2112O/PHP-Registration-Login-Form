<?php
include 'connect.php';// Had to include this here too to get to work
function emailExists($email, $con) {
	/* Note per the docs, do not add terminating ; to the end of the SQL query*/
	$stmt  = mysqli_stmt_init($con);
	$query = "SELECT id FROM users WHERE email = ?";
	mysqli_stmt_prepare($stmt, $query);
	// "i" param is for integer type
	mysqli_stmt_bind_param($stmt, "i", $email);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $retrieved_id);
	$retrieved_id = mysqli_stmt_fetch($stmt);
	//$returned_result = mysqli_stmt_fetch($stmt);
	if (mysqli_num_rows($retrieved_id) == 1) {
		return true;
	} else {
		return false;
	}

	/*
$query  = "SELECT id FROM users WHERE email = '$email'";
$result = mysqli_query($con, $query);
if (mysqli_num_rows($result) == 1) {
return true;
} else {
return false;
}
 */

}
