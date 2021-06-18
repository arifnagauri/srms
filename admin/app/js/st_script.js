
window.addEventListener('load', function () {

	let classes = document.getElementById('classes');
	let tableDiv = document.getElementById('table');
	let addBtn = document.querySelector('.my-form > button');

	// Ajax request for fetching students details table from database.
	classes.onchange = function() {

		if (!classes.value > 0) {
			tableDiv.style.display = 'none';
			return;
		}

		let str = "class=" + classes.value;
		let reqUrl = "http://localhost/srms/admin/app/st_table.php?"+str;

		$ajaxUtils.sendGetRequest(reqUrl,
			function(responseText) {
				// console.log(responseText);
				tableDiv.style.display = 'block';
				tableDiv.innerHTML = responseText;
			},
			false );
	}

	// Showing student addition form.
	addBtn.onclick = function() {
		if(classes.value > 0){
			document.getElementById('hid-row').style.display = "table-row";
			document.querySelector('#hid-row input').focus();
		}
		else {
			alert("Please select class first.");
		}
	};

	// This is event bubbling trick, so that dynamically entered html elements can be targeted efficiently
	// For Student add/delete submission buttons.....
	tableDiv.onclick = function(e) {
		var el = e.target;
		
		// Edit student handler
		if (el.matches('.edit-st')) {

			let str = "class=" + classes.value + "&edit=" + el.value;
			let reqUrl = "http://localhost/srms/admin/app/st_table.php?"+str;

			$ajaxUtils.sendGetRequest(reqUrl,
						function(responseText) {
							// console.log(responseText);				
							tableDiv.innerHTML = responseText;
						},
						false );

		}

		// Deletion handler
		else if (el.matches('.rem-st')) {

			if(!confirm("Do you really want to remove this student's record from database!!!"))
				return;

			else {
				let str = "class=" + classes.value + "&remove=" + el.value;
				let reqUrl = "http://localhost/srms/admin/app/st_table.php?"+str;
			
				$ajaxUtils.sendGetRequest(reqUrl,
							function(responseText) {
								// console.log(responseText);				
								tableDiv.innerHTML = responseText;
							},
							false );
			}
		}

		// Addition handler
		else if (el.matches('#add-new')) {
			let reqUrl = "http://localhost/srms/admin/app/st_table.php";

			let entries = document.querySelectorAll('#hid-row input');
			
			let formData = new FormData();

			for (var i = 0; i < entries.length; i++) {
				formData.append(entries[i].name, entries[i].value);
			}

			$ajaxUtils.sendPostRequest(reqUrl,
						formData,
						function(responseText) {
							// console.log(responseText);		
							tableDiv.innerHTML = responseText;
						});
		}

		// Editing and saving student's detail
		else if (el.matches('#save-st')) {

			let reqUrl = "http://localhost/srms/admin/app/st_table.php";

			let form = document.getElementById('ed-st');
			let entries = form.elements;
			
			let formData = new FormData();

			for (var i = 0; i < entries.length; i++) {
				formData.append(entries[i].name, entries[i].value);
			}
			
			$ajaxUtils.sendPostRequest(reqUrl,
						formData,
						function(responseText) {
							// console.log(responseText);		
							tableDiv.innerHTML = responseText;
						});
		}

		else 
			return;
		
	}

})
