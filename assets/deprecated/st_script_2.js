
let btns = document.getElementsByClassName('act-btn');

let forms = document.getElementsByClassName('my-form');

let classes = document.getElementById('classes');

let tableDiv = document.getElementById('table');

// Add student form..........
btns[0].onclick = function(event) {
	forms[0].style.display = 'block';
	forms[1].style.display = 'none';
	tableDiv.style.display = 'none';
}

// Searching Student Form.........
btns[1].onclick = function() {
	forms[0].style.display = 'none';
	forms[1].style.display = 'block';
	forms[1].reset();
}

// Ajax request for fetching students details table from database.
classes.onchange = function() {
	let str = "class=" + classes.value;
	let reqUrl = "http://localhost/srms/admin/st_table.php?"+str;

	$ajaxUtils.sendGetRequest(reqUrl,
		function(responseText) {
			// console.log(responseText);
			tableDiv.style.display = 'block';					
			tableDiv.innerHTML = responseText;
		},
		false );
}

// Update form is just for  testing......
btns[2].onclick = function() { 
	forms[0].style.display = 'none';
	forms[1].style.display = 'block';
	forms[1].reset();
	tableDiv.style.display = 'none';
}

// Class deletion/updation session.....
tableDiv.onclick = function(e) {
	var el = e.target;
	
	if (!el.matches('.rem-st')) {
		return;
	}
	let str = "class=" + classes.value + "&remove=" + el.value;
	let reqUrl = "http://localhost/srms/admin/st_table.php?"+str;

	if(!confirm("Do you really want to remove this student's record from database!!!"))
		return;
	else {
		$ajaxUtils.sendGetRequest(reqUrl,
		function(responseText) {
			// console.log(responseText);				
			tableDiv.innerHTML = responseText;
		},
		false );
	}
}
// -------------------------------------------------