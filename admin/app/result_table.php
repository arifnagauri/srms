<?php
require_once 'pdo.php';
require_once '../session.php';

$rollNo = "";
$class = "";
$student = array();
$subjects = array();
$result = array();

// echo "<pre style=margin-left:300px>";
// print_r($_SESSION);
// echo "</pre>";

if (isset($_POST['class'])) {
	if(isset($_POST['rollNo']) || isset($_POST['edit']) || isset($_POST['enter'])){

		// print_r($_POST['rollNo']);
		$rollNo = check_input($_POST['rollNo']);
		
		$class = check_input($_POST['class']);

		// Fetching Student's details--------
		$sql = "SELECT st.id, st.rollNo, st.firstName, st.lastName, st.dob, st.class_id FROM students st WHERE st.rollNo= :rollNo AND st.class_id= :class_id";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':rollNo', $rollNo);
		$stmt->bindParam(':class_id', $class);
		$stmt->execute();

		$student = $stmt->fetch(PDO::FETCH_ASSOC);
		// print_r($student);

		// Fetching Student's subjects-------
		$sql = "SELECT sb.id, sb.sub_code, sb.name FROM subjects sb JOIN class_sub cs ON sb.id = cs.subject_id WHERE cs.class_id= :class_id ORDER BY sb.id";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':class_id', $student['class_id']);
		$stmt->execute();

		$subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
		// print_r($subjects);

		if (isset($_POST['edit']) || isset($_POST['enter'])) {
			
			$marks = $_POST['marks'];
			$maxMarks = $_POST['maxMarks'];

			if (isset($_POST['edit'])) {
				$subId = $_POST['edit'];
				
				$sql = "UPDATE results SET marks=:m, max_marks=:mm WHERE results.student_id= :st AND results.subject_id = :sb";
			}
			elseif (isset($_POST['enter'])) {
				$subId = $_POST['enter'];

				$sql = "INSERT INTO results (student_id, subject_id, marks, max_marks) VALUES (:st, :sb, :m, :mm)";
			}

			$stmt = $pdo->prepare($sql);
			$stmt->bindParam(':m', $marks);
			$stmt->bindParam(':mm', $maxMarks);
			$stmt->bindParam(':st', $student['id']);
			$stmt->bindParam(':sb', $subId);
			$stmt->execute();
		}

		// Fetching Marks of student in different subjects-----
		$sql = "SELECT r.marks, r.max_marks FROM results r WHERE r.student_id= :student_id AND r.subject_id = :subject_id ORDER BY r.subject_id";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':student_id', $student['id']);
		
		foreach ($subjects as $subject) {
			$stmt->bindParam(':subject_id', $subject['id']);
			$stmt->execute();

			$result[] = $stmt->fetch(PDO::FETCH_ASSOC);		
		}
	}
}

?>

<div class="result-container">
	<div class="header">
		<div>Name: <span><?= $student['firstName']." ".$student['lastName'];?></span></div>
		<div>Roll No.: <span><?= $student['rollNo'];?></span></s></div>
		<div>Class: <span><?= $class?></span></div>
		<div>DoB: <span><?= $student['dob'];?></span></div>
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
				<th></th> <!-- for edit or enter column -->
			</tr>
		</thead>
		<tbody>
			<?php
				foreach ($subjects as $sNo => $subject) {
					echo "<tr>";
					echo "<td>".($sNo+1)."</td>";
					echo "<td>".$subject['sub_code']."</td>";
					echo "<td>".$subject['name']."</td>";
					
					if (!empty($result[$sNo])) {
						echo "<td><input type='number' max='100' name='marks' value=".$result[$sNo]['marks']." form='score-".($sNo+1)."' required></td>";
						echo "<td><input type='number' max='100' name='maxMarks' value=".$result[$sNo]['max_marks']." form='score-".($sNo+1)."' required></td>";
						echo "<td>\n<form id='score-".($sNo+1)."' onsubmit='return false'>\n";
						echo "<input type='hidden' name='rollNo' value=".$student['rollNo'].">";
						echo "<input type='hidden' name='class' value=".$student['class_id'].">";
						echo "<button type='submit' class='edt' name='edit' value=".$subject['id']." >Edit</button>\n</form></td>";
					}
					else {
						echo "<td><input type='number' max='100' name='marks' form='score-".($sNo+1)."' autofocus required></td>";
						echo "<td><input type='number' max='100' name='maxMarks' form='score-".($sNo+1)."' required></td>";
						echo "<td>\n<form id='score-".($sNo+1)."' onsubmit='return false'>\n";
						echo "<input type='hidden' name='rollNo' value=".$student['rollNo'].">";
						echo "<input type='hidden' name='class' value=".$student['class_id'].">";
						echo "<button type='submit' class='ent' name='enter' value=".$subject['id']." >Enter</button>\n</form>\n</td>";
					}				
					echo "</tr>";
				}
			?>
		</tbody>
	</table>
</div>
