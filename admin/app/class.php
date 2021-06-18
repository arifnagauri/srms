<?php
require_once 'pdo.php';
require_once "../session.php";

// Class/section updation part of srms(admin side), leaving it...
// If Classes handling is to be done by all admin users than add logic here....

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>SRMS Admin</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/class_style.css">
</head>
<body>
	<?php
	require_once "navigation.html";
	?>

	<div class="main">
		<h1>Admin Portal</h1>
		<h3>Add, remove or update Classes/Sections</h3>

		<h3 style="color:red">*Leaving it because I used the logic that only root admin can alter classes/section table in database itself</h3>

		<!-- Classes/sections handling page -->
	</div>

</body>
</html>