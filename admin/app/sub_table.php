<?php
require_once "pdo.php";
require_once "../session.php";

$class = "";
$subjects = array();
$found = NULL;

if(isset($_GET['class'])){
	$class = check_input($_GET['class']);

	if (isset($_GET['remove'])) {
		$subId = check_input($_GET['remove']);

		$sql = "DELETE FROM subjects WHERE subjects.id = :sub_id";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':sub_id', $subId);
		$stmt->execute();
	}

	$sql = "SELECT * FROM subjects sb RIGHT JOIN class_sub cs ON sb.id = cs.subject_id WHERE cs.class_id = :class_id";
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':class_id', $class);
	$stmt->execute();

	$subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
	// echo "<pre style= margin-left:300px>";
	// print_r($subjects);
	// echo "</pre>";
}

if (isset($_POST['addNew'])) {

	$class = $_POST['class'];
	$subCode = $_POST['subCode'];
	$subName = $_POST['subName'];
	$subContent = $_POST['subContent'];

	$sql = "SELECT id FROM subjects WHERE subjects.sub_code=:sc";
	$stmt1 = $pdo->prepare($sql);
	$stmt1->bindParam(':sc', $subCode);
	$stmt1->execute();

	if (!$stmt1->rowCount()>0) {
		$sql = "INSERT INTO subjects (sub_code, name, content) VALUES (:sc, :sn, :con)";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':sc', $subCode);
		$stmt->bindParam(':sn', $subName);
		$stmt->bindParam(':con', $subContent);
		$stmt->execute();

		$sql = "SELECT id FROM subjects WHERE subjects.sub_code=:sc";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':sc', $subCode);
		$stmt->execute();
		$subId = $stmt->fetch(PDO::FETCH_ASSOC)['id'];

		$sql = "INSERT INTO class_sub (class_id, subject_id) VALUES (:c_id, :sub_id)";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':c_id', $class);
		$stmt->bindParam(':sub_id', $subId);
		$stmt->execute();	
	}
	else
		$found = 1;

	$sql = "SELECT * FROM subjects sb RIGHT JOIN class_sub cs ON sb.id = cs.subject_id WHERE cs.class_id = :class_id";
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':class_id', $class);
	$stmt->execute();

	$subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>

<table class="sub-table">
	<thead>
		<tr>
			<th>S. No.</th>
			<th>Code</th>
			<th>Subject</th>
			<th>Course Content</th>
			<th>Action!</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$index = 0;
			foreach ($subjects as $sNo => $subject) {
				echo "<tr>"."\n";
				echo "<td>".($sNo+1)."</td>"."\n";
				echo "<td>".$subject['sub_code']."</td>"."\n";
				echo "<td>".$subject['name']."</td>"."\n";
				echo "<td>".$subject['content']."</td>"."\n"; //Course content to be uploaded......
				echo "<td>"."\n";
				echo "<form onsubmit='return false'>"."\n";
				echo "<button class='rem-sub' type='submit' name='remove' value=".$subject['id']." >Remove</button>"."\n";
				echo "</form>"."\n";
				echo "</td>"."\n";
				echo "</tr>";
				$index = $sNo+1;
			}
			if ($found) { ?>
				<script> window.alert("Subject already exist with same Subject Code")</script>
		<?php }
		?>
		<tr id="hid-row">
			<td><?= $index+1; ?></td>
			<td><input type="text" name="subCode" form="add-sub" required></td>
			<td><input type="text" name="subName" form="add-sub" required></td>
			<td><input type="text" name="subContent" form="add-sub"></td>
			<td>
				<form id="add-sub" onsubmit="return false">
					<input id="add" type="submit" name="addNew" value="Add">
				</form>
			</td>
		</tr>
	</tbody>
</table>