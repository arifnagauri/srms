<!-- Common student's details table php file for different purpose requests through ajax from different admin pages (i.e. from students and results pages) -->
<?php
require_once 'pdo.php';
require_once '../session.php';

$students = array();
$class = "";

// To populate students table (for both student and result page)
if (isset($_GET['class'])) {

	$class = check_input($_GET['class']);

	// if remove get request is sent by ajax (only called in students page). 
	if (isset($_GET['remove'])) {
		$std = $_GET['remove'];

		$sql = "DELETE FROM students WHERE students.id= :st_id";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':st_id', $std);
		$stmt->execute();
	}

	$sql = "SELECT * FROM students st WHERE st.class_id= :c_id";
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':c_id', $class);
	$stmt->execute();
	$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

}

// To add new student or edit student's details and then populate with updated table (only called in students page)
if (isset($_POST['class'])) {
	// echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";

	$class = $_POST['class'];
	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$rollNo = $_POST['rollNo'];
	$dob = $_POST['dob'];
	$mobNo = $_POST['mobNo'];
	$email = $_POST['email'];

	// Add new student 
	if (isset($_POST['addNew'])) {
		$sql = "INSERT INTO students (firstName, lastName, rollNo, dob, class_id, mobNo, email) VALUES (:fn, :ln, :rn, :dob, :c_id, :mn, :em)";
	}

	// Save edited student's detail
	elseif (isset($_POST['save'])) {
		$stId = $_POST['save'];
		$sql = "UPDATE students SET firstName=:fn, lastName=:ln, rollNo=:rn, dob=:dob, class_id=:c_id, mobNo=:mn, email=:em WHERE students.id=".$stId;
	}

	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':fn', $firstName);
	$stmt->bindParam(':ln', $lastName);
	$stmt->bindParam(':rn', $rollNo);
	$stmt->bindParam(':dob', $dob);
	$stmt->bindParam(':c_id', $class);
	$stmt->bindParam(':mn', $mobNo);
	$stmt->bindParam(':em', $email);
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
			<?php
				if (isset($_GET['forResult']))
					echo "<th>Result</th>";
				else
					echo "<th>Action!!!</th>";
			?>		
		</tr>
	</thead>
	<tbody>
		<?php
			$index = 0;
			if (sizeof($students) > 0) {
				foreach ($students as $sNo => $student) {

					// if student's edit details button is pressed, show form
					if ( isset($_GET['edit']) && ($student['id']===$_GET['edit']) ) {
						echo "<tr>\n";
						echo "<td>".($sNo+1)."</td>"."\n";
						echo "<td><input type='text' name='firstName' value='".$student['firstName']."' form='ed-st' size='12' required></td>";
						echo "<td><input type='text' name='lastName' value='".$student['lastName']."' form='ed-st' size='12' required></td>";
						echo "<td><input type='text' name='rollNo' value='".$student['rollNo']."' form='ed-st' size='4' maxlength='4' required></td>";
						echo "<td><input type='date' name='dob' value='".$student['dob']."' form='ed-st' size='4' required></td>";
						echo "<td><input type='text' name='mobNo' value='".$student['mobNo']."' form='ed-st' size='4' maxlength='10' required></td>";
						echo "<td><input type='text' name='email' value='".$student['email']."' form='ed-st' size='4' ></td>";
						echo "<td>";
						echo "<form id='ed-st' name='ed-st' method='post' onsubmit='return false'>\n";
						echo "<input type='hidden' name='class' value=".$student['class_id']." >";
						echo "<button type='submit' id='save-st' name='save' value=".$student['id']." >Save</button>\n";
						echo "</form></td>"."\n";
						echo "</tr>";
					}
					// To populate for both students and result pages
					else {
						echo "<tr>"."\n";
						echo "<td>".($sNo+1)."</td>"."\n";
						echo "<td>".$student['firstName']."</td>"."\n";
						echo "<td>".$student['lastName']."</td>"."\n";
						echo "<td>".$student['rollNo']."</td>"."\n";
						echo "<td>".$student['dob']."</td>"."\n";
						echo "<td>".$student['mobNo']."</td>"."\n";
						echo "<td>".$student['email']."</td>"."\n";
						echo "<td>"."\n";
						// If ajax request from results page...
						if (isset($_GET['forResult'])) {
							echo "<form onsubmit='return false'>"."\n";
							echo "<input type='hidden' name='class' value=".$class." >";
							echo "<button type='submit' class='res-btn' name='rollNo' value=".$student['rollNo'].">Update</button>"."\n";
							echo "</form>"."\n";
						}
						// If ajax request from students page...
						else {
							echo "<form method='post' onsubmit='return false'>"."\n";
							echo "<button type='submit' class='edit-st' name='edit' value=".$student['id'].">Edit</button>"."\n";
							echo "<button type='submit' class='rem-st' name='remove' value=".$student['id'].">Unenroll</button>"."\n";
							echo "</form>"."\n";
						}	
						echo "</td>"."\n";
						echo "</tr>";
					}

					$index = $sNo+1;
				}
			}
		?>
		<!--will only be displayed in students page -->
		<tr id="hid-row">
			<td><?= $index+1; ?></td>
			<td><input type="text" name="firstName" form="add-st" size="12" required></td>
			<td><input type="text" name="lastName" form="add-st" size="12" required></td>
			<td><input type="text" name="rollNo" form="add-st" size="4" maxlength="4" required></td>
			<td><input type="date" name="dob" form="add-st" size="4" required></td>
			<td><input type="text" name="mobNo" form="add-st" size="10" maxlength="10" required></td>
			<td><input type="text" name="email" form="add-st"></td>
			<td>
				<form id="add-st" name="add-st" onsubmit="return false">
					<input type="hidden" name="class" value=<?= $class ?> >
					<input type="button" name="addNew" value="Enroll" id="add-new" >
				</form>
			</td>
		</tr>
	</tbody>
</table>