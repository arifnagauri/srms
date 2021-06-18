<?php
require_once "pdo.php";

$rollNo = "";
$class = ""; // Untill now assuming only one section for a class

if($_SERVER['REQUEST_METHOD'] == "POST"){
	$rollNo = check_input($_POST['rollNo']);
	$class = check_input($_POST['class']);
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>SRMS student</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<h1>Welcome to Student Portal</h1>
	
	<h3>To check Student's result:<br>Kindly provide Roll No. and Class below</h3>

	<div class="form-container">
		<form class="my-form" onsubmit="return false" autocomplete="on">
			<label for="roll-no">Roll No.:</label>
			<input type="text" name="rollNo" id="roll-no" maxlength="4" value="<?= htmlentities($rollNo) ?>" autofocus required><br>
			<label for="class">Class:</label>
			<select name="class" id="class" required> <!-- assuming only one section for class-->
				<option value="">---Please Select Class---</option>  <!--Learning: To make select a 'required' tag, value attribute of default selected option should be empty.-->
				<?php 
					$sql = "SELECT * FROM classes";
					$query = $pdo->prepare($sql);
					$query->execute();
					$results = $query->fetchAll(PDO::FETCH_OBJ);

					if($query->rowCount() > 0){
						foreach($results as $result) { 	?>
							<option value="<?= htmlentities($result->id); ?>"><?= htmlentities($result->class); ?>&nbsp;<?= htmlentities($result->section); ?>		
							</option>							
				<?php	}
					}	?>	
			</select>

			<input type="submit" value="See Result" id="see-res">
		</form>
	</div>

	<div id="res-modal">
			
	</div>

	<div class="footer-bottom">
		This Website is for Educational Purpose, not for Commercial use.
	</div>

	<script type="text/javascript" src="js/ajax_utils.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
</body>
</html>