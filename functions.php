<?php
include 'connect.php';// Had to include this here too to get to work
function emailExists($email, $con) {
	/* Note per the docs, do not add terminating ; to the end of the SQL query. This email function works with prepared statement*/
	$query = "SELECT id FROM users WHERE email = ?";
	$stmt  = mysqli_stmt_init($con);
	if (!mysqli_stmt_prepare($stmt, $query)) {
		echo "SQL statement failed.";
	} else {
		/* The second arg is the data type of the param we want to bind to, not the data type of what we want returned.*/
		mysqli_stmt_bind_param($stmt, "s", $email);
		mysqli_stmt_execute($stmt);
		$retrieved_id = mysqli_stmt_get_result($stmt);
		if (mysqli_num_rows($retrieved_id) == 1) {
			return true;
		} else {
			return false;
		}
	}
}

function verifyPassword($password, $email, $con) {
	$password_query = "SELECT password FROM users WHERE email = ?";
	$stmt           = mysqli_stmt_init($con);
	if (!mysqli_stmt_prepare($stmt, $password_query)) {
		echo "SQL statement failed.";
	} else {
		mysqli_stmt_bind_param($stmt, "s", $email);
		mysqli_stmt_execute($stmt);
		$retrieved_result = mysqli_stmt_get_result($stmt);
		/*The 1st param is the password from the $_POST superglobal, the 2nd is the variable retrieved from the DB.*/
		if (mysqli_num_rows($retrieved_result) == 1 && password_verify($password, $retrieved_result['password'])) {
			return true;
			//$error = "Matched and logged in.";
		} else {
			return false;
			//$error = "Issue with that password.";
		}
		//$result           = mysqli_query($con, $password_query);
	}
}
