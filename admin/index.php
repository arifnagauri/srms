<?php
	session_start();

	if(isset($_SESSION['user'])){
		//if user had already logged in previously in current browser session, then land him to admin protal home page.
		header('location:app/admin.php');
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>SRMS Admin</title>
	<script src="jquery.min.js"></script>
	<script src="bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="login_style.css">
</head>
<body>

	<h1>Admin Portal</h1>

	<div class="form-container">
		<h3>Login for administration staff only</h3>

		<form action="<?= htmlentities('app/admin.php') ?>" id="login-form" method="post" autocomplete="on">
			<label for="username">Username:</label>
			<input type="text" name="username" id="username" placeholder="Enter Username" autofocus required><br>
			<label for="password">Password:</label>
			<input type="password" name="password" id="password" placeholder="Enter Password" required><br>

			<input type="submit" name="login" value="Login" id="login-btn">
		</form>
	</div>

	<div class="footer-bottom">
		This Website is for Educational Purpose, not for Commercial use.
	</div>

	<script src="custom.js"></script>
</body>
</html>