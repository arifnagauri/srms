<?php

$username = "root";
$password = "";

try {
	$pdo = new pdo('mysql:host=localhost;port=3306;dbname=srms', $username, $password);

	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
	echo "Connection to DataBase failed: ".$e->getMessage();
}

// Function to validate input data.
function check_input($data){
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlentities($data);
	return $data;
}

?>