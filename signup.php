<?php
session_start();
/*checking that the button is clicked*/
if (isset($_POST['submit'])) {
	include 'connect.php';//Db $con variable coming from here.
	$error = "";// Local variable to report any errors.
	/* escaping the variables here and must provide the $con connection var */
	$first_name       = mysqli_real_escape_string($con, $_POST['first_name']);
	$last_name        = mysqli_real_escape_string($con, $_POST['last_name']);
	$email            = mysqli_real_escape_string($con, $_POST['email']);
	$password         = $_POST['password'];
	$confirm_password = $_POST['confirm_password'];

	/* Variable for absolute path to images dir. Killed me at first by not working with uploading the actual image to the designated file but was inserting image_name into the db. Was missing the beginning and ending '/' for the path. Duh... *Facepalm* */
	$images_path_dir = '/var/www/html/login_vid/images/';

	/*image is name attr from form, second array is attr from superglobal $_FILE*/
	$image_name = $_FILES['image']['name'];
	$tmp_image  = $_FILES['image']['tmp_name'];//temp image name
	$image_size = $_FILES['image']['size'];

	// Extracting the extension from the image, into an array
	$image_extract_extension = explode(".", $image_name);
	// Converting the extracted extension to lowercase for checking.
	$image_ext = strtolower($image_extract_extension['1']);
	// These image extensions are allowed
	$allowed_exts = array('png', 'jpg', 'jpeg');

	/* Formatting to  year month day for capatability with MySQL date column 2012-03-13 */
	$date = date("Y-m-d");

	// Validation starts here.
	if (strlen($first_name) < 3) {
		//$error = "First name is too short.";
		$error = print_r($first_name);
	} else if (strlen($last_name) < 3) {
		$error = "Last name is too short.";
	} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$error = "Email is not valid.";
	} else if (strlen($password) < 8) {
		$error = "Password must be greater than 8 characters.";
	}
	// Using !== for an exact match with case sensitivity and all.
	 else if ($password !== $confirm_password) {
		$error = "Password and confirm password fields must match exactly.";
	} else if ($image_file == " ") {
		$error = "Please upload an image.";
	} else if ($image_size > 1048576) {/*Image must be less than 1MB*/
		$error = "Image size must be less than 1MB.";
	} else if (!in_array(strtolower($image_ext), $allowed_exts)) {
		// Confirming the extension is allowed above
		$error = "That extension is not allowed.";
	} else {
		// Hashing the password here prior to insert
		//$password = md5($password);
		/* Hashing the password with password_hash as opposed to above after reading that it is not that secure for large tables. */
		$password = password_hash($password, PASSWORD_DEFAULT);
		/* Renaming the image here with multiple rand() functions, the time() function and then appending a "." and whatever the image extension was from the extraction above */
		$image_name  = rand(0, 100000).rand(0, 100000).rand(0, 100000).time().".".$image_ext;
		$insertQuery = "INSERT INTO users(first_name, last_name, email, password, image, date_registered) VALUES('$first_name', '$last_name', '$email', '$password', '$image_name', '$date');";
		if (mysqli_query($con, $insertQuery)) {
			if (move_uploaded_file($tmp_image, $images_path_dir.$image_name)) {
				$error = "You are succesfully registered.";
			} else {
				$error = "Image not uploaded";
			}
		}
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"><meta>
	<title>Registration Page</title>
	<link rel="stylesheet" href="css/styles.css">
</head>
<body>
	<div id="error"><?php echo $error;?></div>
	<div id="wrapper">
		<div id="menu">
			<a href="login.php">Login</a>
		</div>
		<div id="formDiv">
			<form action="signup.php" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
				<label>First Name</label><br/>
				<input type="text" name="first_name"><br/>
				<label>Last Name</label><br/>
				<input type="text" name="last_name"><br/>
				<label>Email</label><br/>
				<input type="email" name="email"><br/>
				<label>Password</label><br/>
				<input type="password" name="password"><br/>
				<label>Confirm Password</label><br/>
				<input type="password" name="confirm_password"><br/>
				<label>Image</label><br/>
				<input type="file" name="image"><br/>
				<input type="submit" name="submit"><br/>
			</form>
		</div>

	</div>

</body>
</html>


