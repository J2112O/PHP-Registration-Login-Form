<?php
if (isset($_FILES['file'])) {/*Here file is name not the type*/
	//echo 'File does exist.';
	$file = $_FILES['file']['tmp_name'];
	echo $file;
} else {
	echo 'Something is wrong.';
}

/*
$image_file  = $_FILES['image']['name'];
$image_name  = $image_file['name'];
$tmp_image   = $image_file['tmp_name'];
$image_size  = $image_file['size'];
$image_error = $image_file['error'];
$error       = $_FILES['image']['error'];
 */