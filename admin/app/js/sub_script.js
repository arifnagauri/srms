
window.addEventListener('load', function() {

	let classes = document.getElementById('classes');
	let form = document.getElementsByClassName('my-form');
	let tableDiv = document.getElementById('table');

	// Ajax request for fetching subjects table for class from database.
	classes.onchange = function () {

		if (!classes.value > 0) {
			tableDiv.style.display = 'none';
			return;
		}

		let str = "class=" + classes.value;
		let reqUrl = "http://localhost/srms/admin/app/sub_table.php?"+str;

		$ajaxUtils.sendGetRequest(reqUrl,
			function(responseText) {
				// console.log(responseText);
				tableDiv.style.display = 'block';
				tableDiv.innerHTML = responseText;
			},
			false );
	};

	let addBtn = document.querySelector('.my-form > button');

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
	// For removing/adding subjects...
	tableDiv.onclick = function(e) {
		el = e.target;

		if (el.matches('.rem-sub')) {

			const str = "Do you really want to remove this subject record from database!!!\nThis may have cascading effect on other data also!!!";
			if(!confirm(str))
				return;

			else {
				let str = "class=" + classes.value + "&remove=" + el.value;
				let reqUrl = "http://localhost/srms/admin/app/sub_table.php?"+str;

				$ajaxUtils.sendGetRequest(reqUrl,
					function(responseText) {
						// console.log(responseText);
						tableDiv.style.display = 'block';
						tableDiv.innerHTML = responseText;
					},
					false );
			}
		}

		else if (el.matches('#add')) {

			let reqUrl = "http://localhost/srms/admin/app/sub_table.php";

			let entries = document.querySelectorAll('#hid-row input');
			
			let formData = new FormData();

			for (var i = 0; i < entries.length; i++) {
				formData.append(entries[i].name, entries[i].value);
			}
			formData.append('class', classes.value);

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

});
