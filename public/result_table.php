<!-- This table markup will be requested through ajax from result.php page -->

<?php
require_once "pdo.php";

$rollNo = "";
$class = ""; // Untill now assuming only one section for a class
$student = "";
$subjects = array();
$result = array();
$found = 1;

if(isset($_POST['rollNo']) && isset($_POST['class']) ){
	$rollNo = check_input($_POST['rollNo']);
	$class = check_input($_POST['class']);

	// Fetching Student's details--------
	$sql = "SELECT st.id, st.rollNo, st.firstName, st.lastName, st.dob, st.class_id FROM students st WHERE st.rollNo= :rollNo AND st.class_id= :class_id";
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':rollNo', $rollNo);
	$stmt->bindParam(':class_id', $class);
	$stmt->execute();

	// check if student exist or not with inserted details...
	if($stmt->rowCount() < 1)
		$found = NULL;

	$student = $stmt->fetch(PDO::FETCH_ASSOC);
	// print_r($student);

	// Fetching Student's subjects-------
	$sql = "SELECT sb.id, sb.sub_code, sb.name FROM subjects sb JOIN class_sub cs ON sb.id = cs.subject_id WHERE cs.class_id= :class_id ORDER BY sb.id";
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':class_id', $student['class_id']);
	$stmt->execute();

	$subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
	// print_r($subjects);

	// Fetching Marks of student in different subjects-----
	$sql = "SELECT r.marks, r.max_marks FROM results r WHERE r.student_id= :student_id AND r.subject_id = :subject_id ORDER BY r.subject_id";
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':student_id', $student['id']);
	
	foreach ($subjects as $subject) {
		$stmt->bindParam(':subject_id', $subject['id']);
		$stmt->execute();

		if ($stmt->rowCount() < 1)
			$result[] = ['marks'=>NULL, 'max_marks'=>NUll];
		else
			$result[] = $stmt->fetch(PDO::FETCH_ASSOC);	
	}

}

?>

<!-- --------------------------------------------------------------------- -->

<div class="res-container">
	<div class="header">
		<?php
			if (!$found) {
				echo "<div style='text-align:center;'>";
				echo "<div> Student for requested roll number and class does not exist !!!</div>";
				echo "<div> Kindly insert class and roll number correctly...</div>";
				echo "</div>";
				echo "<div class='close'>&times;</div>";
				exit();
			}
		?>
		<div>Name: <span><?= $student['firstName']." ".$student['lastName'];?></span></div>
		<div>Roll No.: <span><?= $student['rollNo']; ?></span></s></div>
		<div>Class: <span><?= $class ?></span></div>
		<div>DoB: <span><?= $student['dob']; ?></span></div>
	</div>
	<div class="close">&times;</div>
	<hr>
	<table class="result">
		<thead>
			<tr>
				<th>S. No.</th>
				<th>Code</th>
				<th>Subject</th>
				<th>Marks</th>
				<th>Maximum Marks</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$totalMarks = 0;
				$totalMaxMarks = 0;
				$per = 0;
				foreach ($subjects as $sNo => $subject) {
					echo "<tr>";
					echo "<td>".($sNo+1)."</td>";
					echo "<td>".$subject['sub_code']."</td>";
					echo "<td>".$subject['name']."</td>";
					echo "<td>".$result[$sNo]['marks']."</td>";
					$totalMarks = $totalMarks + $result[$sNo]['marks'];
					echo "<td>".$result[$sNo]['max_marks']."</td>";
					$totalMaxMarks = $totalMaxMarks + $result[$sNo]['max_marks'];
					echo "</tr>";
				}
				if ($totalMaxMarks!=0)
					$per = ($totalMarks/$totalMaxMarks)*100;
			?>
			<tr>
				<td></td>
				<td></td>
				<td>Total</td>
				<td><?= $totalMarks ?></td>
				<td><?= $totalMaxMarks ?></td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<td></td>
				<td></td>
				<td>Percentage</td>
				<td><?= $per ?></td>
				<td></td>
			</tr>
		</tfoot>
	</table>
</div>