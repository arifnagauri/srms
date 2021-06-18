
window.addEventListener('load', function() {
	let classes = document.getElementById('classes');

	let tableDiv = document.getElementById('table');

	// Ajax request for fetching students details table from database.
	classes.onchange = function() {

		if (!classes.value > 0) {
			tableDiv.style.display = 'none';
			return;
		}

		let str = "class=" + classes.value +"&forResult=yes"; //to pass $_GET['forResult'] variable
		let reqUrl = "http://localhost/srms/admin/app/st_table.php?"+str;

		$ajaxUtils.sendGetRequest(reqUrl,
			function(responseText) {
				// console.log(responseText);
				tableDiv.style.display = 'block';
				tableDiv.innerHTML = responseText;
			},
			false );
	}

	let resModal = document.getElementById('result-modal');

	// This is event bubbling trick, so that dynamically entered html elements can be targeted efficiently
	// For updating result data for student in list...
	tableDiv.onclick = function(e) {
		el = e.target;

		if (!el.matches('.res-btn'))
			return;

		let reqUrl = "http://localhost/srms/admin/app/result_table.php";

		let form = el.parentNode;
		let entries = form.elements;
		
		let formData = new FormData();

		for (var i = 0; i < entries.length; i++) {
			formData.append(entries[i].name, entries[i].value);
		}

		$ajaxUtils.sendPostRequest(reqUrl,
					formData,
					function(responseText) {
						// console.log(responseText);
						resModal.style.display = 'block';
						resModal.innerHTML = responseText;
					});

	}

	window.onclick = function(event) {
		if (event.target == resModal) {
			resModal.style.display = "none";
		}
	}

	// This is event bubbling trick, so that dynamically entered html elements can be targeted efficiently
	// For Edit/entering result data...
	resModal.onclick = function(e) {
		el = e.target;

		if (el.matches('.close')) {
			resModal.style.display = 'none';
		}

		else if (el.matches('.edt')) {
			let reqUrl = "http://localhost/srms/admin/app/result_table.php";

			let form = el.parentNode;
			let entries = form.elements;
			
			let formData = new FormData();

			for (var i = 0; i < entries.length; i++) {
				formData.append(entries[i].name, entries[i].value);
			}

			$ajaxUtils.sendPostRequest(reqUrl,
						formData,
						function(responseText) {
							// console.log(responseText);
							resModal.style.display = 'block';
							resModal.innerHTML = responseText;
						});
		}

		else if (el.matches('.ent')) {
			let reqUrl = "http://localhost/srms/admin/app/result_table.php";

			let form = el.parentNode;
			let entries = form.elements;
			
			let formData = new FormData();

			for (var i = 0; i < entries.length; i++) {
				formData.append(entries[i].name, entries[i].value);
			}

			$ajaxUtils.sendPostRequest(reqUrl,
						formData,
						function(responseText) {
							// console.log(responseText);
							resModal.style.display = 'block';
							resModal.innerHTML = responseText;
						});
		}

		else
			return;

	}
});