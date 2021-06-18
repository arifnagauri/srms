<?php 
	require_once "pdo.php";
	session_start();

	if(isset($_POST['login'])){
		$username=check_input($_POST['username']);
		$password=md5(check_input($_POST['password'])); //using md5 algorithmic function for encryption and decryption of password

		$sql = "SELECT * from admins where u_name=:un and pwd=:pwd";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':un', $username);
		$stmt->bindParam(':pwd', $password);
		$stmt->execute();

		if ($stmt->rowCount() > 0){
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
			$_SESSION['user']=$row['id'];
			$_SESSION['name']=$row['f_name'];
		}
		else{
  			echo "<div style='font-size: 1.5em'> Login Failed. <span style='color:red'>User not Found.</span></div>";
  			exit();
		}
	}
	
	if (!isset($_SESSION['user']))
		header("location:../index.php");

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>SRMS Admin</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

	<?php
	require_once "navigation.html";
	?>

	<div class="main">
		<h1>Welcome to Admin Portal</h1>
		<h3><?= htmlentities($_SESSION['name']) ?></h3>
		<p>
			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
		</p>
	</div>

	<script type="text/javascript">
		document.getElementById('admin').innerHTML = "<?= $_SESSION['name']; ?>";
	</script>

</body>