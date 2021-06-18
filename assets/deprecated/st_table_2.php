<?php
session_start();
require 'pdo.php';

// To initially populate students table and start a class updation/deletion session.
if (isset($_GET['class'])) {
	$_SESSION['class'] = $_GET['class'];
	$class = check_input($_GET['class']);

	$sql = "SELECT * FROM students st WHERE st.class_id= :c_id";
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':c_id', $class);
	$stmt->execute();
	$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

}

// To delete student record and populate table with remaining data.
if (isset($_GET['remove'])) {
	$std = $_GET['remove'];
	$class = check_input($_SESSION['class']);

	$sql = "DELETE FROM students WHERE students.id= :st_id";
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':st_id', $std);
	$stmt->execute();

	$sql = "SELECT * FROM students st WHERE st.class_id= :c_id";
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':c_id', $class);
	$stmt->execute();
	$students = $stmt->fetchAll(PDO::FETCH_ASSOC);	
}

?>

<table class="st-table">
	<thead>
		<tr>
			<th>S No.</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Roll No.</th>
			<th>Date of Birth</th>
			<th>Mobile No.</th>
			<th>Email ID</th>
			<th>Action!!!</th>
		</tr>
	</thead>
	<tbody>
		<?php
			if (sizeof($students) > 0) {
				foreach ($students as $key => $student) {
					echo "<tr>"."\n";
					echo "<td>".($key+1)."</td>"."\n";
					echo "<td>".$student['firstName']."</td>"."\n";
					echo "<td>".$student['lastName']."</td>"."\n";
					echo "<td>".$student['rollNo']."</td>"."\n";
					echo "<td>".$student['dob']."</td>"."\n";
					echo "<td>".$student['mobNo']."</td>"."\n";
					echo "<td>".$student['email']."</td>"."\n";
					echo "<td>"."\n";
						echo "<form method='post' onsubmit='return false'>"."\n";
						echo "<button type='submit' class='rem-st' name='remove' value=".$student['id'].">Remove</button>"."\n";
						echo "</form>"."\n";
					echo "</td>"."\n";
				echo "</tr>";	
			}
			}
		?>
	</tbody>			
</table>