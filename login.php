<?php
include 'functions.php';
/*checking that the button is clicked*/
$error = "";// Variable to report any errors.
if (isset($_POST['submit'])) {
	include 'connect.php';//Db $con variable coming from here.
	$email    = mysqli_real_escape_string($con, $_POST['email']);
	$password = mysqli_real_escape_string($con, $_POST['password']);
	if (emailExists($email, $con)) {
		$error = "Email Exists";
		/*
		$password_query   = "SELECT password FROM users WHERE email = '$email'";
		$result           = mysqli_query($con, $password_query);
		$retrieved_result = mysqli_fetch_assoc($result);
		/*The 1st param is the password from the $_POST superglobal, the 2nd is the variable retrieved from the DB.*/
		/*
	if (password_verify($password, $retrieved_result['password'])) {
	$error = "Matched and logged in.";
	} else {
	$error = "Issue with that password.";
	}
	 */

	} else {
		$error = "Email Does Not Exists.";
	}

}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"><meta>
	<title>Login Page</title>
	<link rel="stylesheet" href="css/styles.css">
</head>
<body>
	<div id="error"><?php echo $error;?></div>
	<div id="wrapper">
		<div id="menu">
			<a href="signup.php">Sign up</a>
			<a href="login.php">Login</a>
		</div>
		<div id="formDiv">
			<form action="login.php" method="POST" accept-charset="utf-8">
				<label>Email</label><br/>
				<input type="email" name="email"><br/>
				<label>Password</label><br/>
				<input type="password" name="password"><br/>
				<input type="checkbox" name="keep" value="Remember Me!">
				<label>Remember Me</label><br/>
				<input type="submit" name="submit" value="Login"><br/>
			</form>
		</div>
	</div>

</body>
</html>