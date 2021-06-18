
window.onload = function() {
	let form = document.getElementsByClassName('my-form')[0];

	let btn = document.getElementById('see-res');

	let resModal = document.getElementById('res-modal');

	btn.onclick = function() {
		let reqUrl = "http://localhost/srms/public/result_table.php";

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

	resModal.onclick = function(e) {
		el = e.target;

		if (!el.matches('.close'))
			return;
		else
			resModal.style.display = "none";
	}

	window.onclick = function(event) {
		if (event.target == resModal) {
			resModal.style.display = "none";
		}
	}
}