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
	<link rel="stylesheet" type="text/css" href="css/sub_style.css">
</head>
<body>
	<?php
	require_once "navigation.html";
	?>

	<!-- Page content -->
	<div class="main">

		<h1>Admin Portal</h1>
		<h3>See, Add or Remove Subjects</h3>

		<div class="form-container">
			<!-- Form for taking class input -->
			<form class="my-form" onsubmit="return false" autocomplete="on">

				<label for="classes">Class:</label>
				<select name="class" id="classes"> <!-- assuming only one section for class-->
					<option value="">---Please Select Class---</option>
					<?php 
						$sql = "SELECT * FROM classes ORDER BY id";
						$query = $pdo->prepare($sql);
						$query->execute();
						$results = $query->fetchAll(PDO::FETCH_OBJ);

						if($query->rowCount() > 0){
							foreach($results as $result) { 	
								
								echo '<option value="'.htmlentities($result->id).'"';

								if(isset($_POST['class']) && ( $_POST['class'] === $result->id) ) {
									echo ' selected>';
								}
								else
									echo ' >';

								echo htmlentities($result->class).'&nbsp'.htmlentities($result->section);	
								echo '</option>';
							}
						}
					?>
				</select>

				<button type="button" >Add New Subject</button>
			</form>
			
		</div>

		<!-- Table for showing subjects of current class. -->
		<div id="table">
			
		</div>
		
		<hr>
		<p>*Select Class to see available subjects</p>

	</div><!-- Main content ends-->

	<script type="text/javascript" src="js/ajax_utils.js"></script>
	<script type="text/javascript" src="js/sub_script.js"></script>
</body>
</html>