<?php
include 'connect.php';
function emailExists($email, $con) {
	/* Note per the docs, do not add terminating ; to the end of the SQL query*/
	$query = "SELECT id FROM users WHERE email = ?'";
	$stmt  = mysqli_prepare($con, $query);
	mysqli_stmt_bind_param($stmt, "s", $email);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $results_set);
	$result = mysqli_stmt_get_result($stmt);
	return $result;
}

$email = 'home@home.net';
$id    = emailExists($email, $con);
echo $id;
?>