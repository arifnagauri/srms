<?php
require_once 'pdo.php';

$firstName = "";
$lastName = "";
$rollNo = "";
$dob = "";
$class = "";
$mobNo = "";
$email = "";
$found = "";

if (isset($_POST['add']) ) {
	// echo "<pre style=margin-left:300px>";
	// print_r($_POST);
	// echo "</pre>";

	$firstName = check_input($_POST['firstName']);
	$lastName = check_input($_POST['lastName']);
	$rollNo = check_input($_POST['rollNo']);
	$dob = $_POST['dob'];
	$class = check_input($_POST['class']);
	$mobNo = check_input($_POST['mobNo']);
	$email = check_input($_POST['email']);

	// For checking if student already present
	$sql = "SELECT * FROM students st WHERE st.rollNo= :rn and st.class_id= :c_id";
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':rn', $rollNo);
	$stmt->bindParam(':c_id', $class);
	$stmt->execute();
	$found = $stmt->fetch(PDO::FETCH_ASSOC);

	if (!$found) {
		$sql = "INSERT INTO students (firstName, lastName, rollNo, dob, class_id, mobNo, email) VALUES (:fn, :ln, :rn, :dob, :c_id, :mn, :em)";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':fn', $firstName);
		$stmt->bindParam(':ln', $lastName);
		$stmt->bindParam(':rn', $rollNo);
		$stmt->bindParam(':dob', $dob);
		$stmt->bindParam(':c_id', $class);
		$stmt->bindParam(':mn', $mobNo);
		$stmt->bindParam(':em', $email);
		$stmt->execute();

		echo "<script>";
		echo "window.alert('Student added successfully');";
		echo "</script>";		
	}
	else {
		echo "<script>";
		echo "window.alert('Student already present with this roll no.!!!');";
		echo "</script>";
	}
}

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>SRMS Admin</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/st_style_2.css">
</head>
<body>
	<?php
	require_once "navigation.html";
	?>

	<!-- Page content -->
	<div class="main">

		<h1>Admin Portal</h1>
		<h3>Add, Remove or Update student's details</h3>

		<div class="ask">
			<button type="button" class="act-btn">Add Student</button>
			<button type="button" class="act-btn">Remove Student</button>
			<!-- Update form button is just for testing -->
			<button type="button" class="act-btn">Update Details</button>
		</div>

		<div class="form-container">

			<!-- Form 1 for adding student to the records -->
			<form action="<?= htmlentities($_SERVER['PHP_SELF']); ?>" method="post" class="my-form" autocomplete="on">

				<label for="classes">Class:</label>
				<select name="class" required> <!-- assuming only one section for class-->
					<option value="">---Please Select Class---</option>
					<?php 
						$sql = "SELECT * FROM classes";
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

				<label for="first-name">First Name:</label>
				<input type="text" name="firstName" id="first-name" value="" required><br>
				
				<label for="last-name">Last Name:</label>
				<input type="text" name="lastName" id="last-name" value="" required><br>
				<!-- Roll no. is just for testing... In real world it is auto incremented and assigned by computer to student -->
				<label for="roll-no">Roll No.:</label>
				<input type="text" name="rollNo" id="roll-no" value="" required><br>
				
				<label for="dob">Date of Birth:</label>
				<input type="date" name="dob" id="dob" value="" required><br>

				<label for="mob">Mobile No.:</label>
				<input type="text" name="mobNo" id="mob" value="" required><br>

				<label for="email">Email ID:</label>
				<input type="text" name="email" id="email" value=""><br>
				
				<input type="submit" name="add" value="Add Student">
			</form>

			<!-- Form 2 for searching students in class -->
			<form action="<?= htmlentities($_SERVER['PHP_SELF']); ?>" class="my-form" autocomplete="on">
				<label for="classes">Class:</label>
				<select name="class" id="classes" required> <!-- assuming only one section for class-->
					<option value="">---Please Select Class---</option>
					<?php 
						$sql = "SELECT * FROM classes";
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
		</div>
				
		<!-- Table for showing student -->
		<div id="table">
			
		</div>

	</div>

	<script type="text/javascript" src="js/ajax_utils.js"></script>
	<script type="text/javascript" src="js/st_script_2.js"></script>
</body>
</html>