<?php
require_once 'pdo.php';
require_once "../session.php";

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>SRMS Admin</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/result_style.css">
</head>
<body>
	<?php
	require_once "navigation.html";
	?>

	<div class="main">
		<h1>Admin Portal</h1>
		<h3>Update student's result</h3>

		<form class="my-form" autocomplete="on">
			<label for="classes">Class:</label>
			<select name="class" id="classes" required> <!-- assuming only one section for class-->
				<option value="">---Please Select Class---</option>
				<?php 
					$sql = "SELECT * FROM classes ORDER BY id";
					$query = $pdo->prepare($sql);
					$query->execute();
					$results = $query->fetchAll(PDO::FETCH_ASSOC);

					if($query->rowCount() > 0){
						foreach($results as $result) { 	
							
							echo '<option value="'.htmlentities($result['id']).'"';

							if(isset($_POST['class']) && ( $_POST['class'] === $result['id']) ) {
								echo ' selected>';
							}
							else
								echo ' >';

							echo htmlentities($result['class']).'&nbsp'.htmlentities($result['section']);	
							echo '</option>';
						}
					}
				?>
			</select>
		</form>

		<!-- Student's tabel to be shown -->
		<div id="table">
			
		</div>

		<hr>
		<p>*Select class to see enrolled students</p>

		<!-- Result Table to be shown as a pop-up modal -->
		<div id="result-modal">
			
		</div>

	</div>

	<script type="text/javascript" src="js/ajax_utils.js"></script>
	<script type="text/javascript" src="js/result_script.js"></script>
</body>
</html>