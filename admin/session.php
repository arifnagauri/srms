<!-- To check evey time at start of each admin page if user already logged in previously in current browser session -->
<?php
	session_start();

	if (!isset($_SESSION['user'])) {
		header('location:../index.php');
	}
	else { ?>
		<script>
			window.addEventListener('load', function() {
				// Inserts logged in person's name in each admin pages (at an div element with id="admin" navigation.html)
 				document.getElementById('admin')
 							.innerHTML = "<?= $_SESSION['name']; ?>";
			});
		</script>
	<?php
	}
?>