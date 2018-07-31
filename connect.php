<?php

include_once ('constants.php');
// Creating a connection
$con = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

if (mysqli_connect_errno()) {
	echo "Error occured while connecting: ".mysqli_connect_errno();
}
session_start();