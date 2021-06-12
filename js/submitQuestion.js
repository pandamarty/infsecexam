(() => {
	"use strict";

	const init = () => {
		$('button[name=submitQuestion]').addEventListener('click', submitQuestionClick);
	};

	const submitQuestionClick = (evt) => {
		evt.preventDefault();
		let formData = new FormData();
		formData.append('question', $('textarea[name=question]').value);
		formData.append('xsrf', $('meta[name=xsrf-token]').content);
		fetch('/api/submitQuestion.php',
			{
				method: 'POST',
				body: formData
			}
		)
		.then(
			response => response.json()
		)
		.then(
			response => {
				$('#question-message').innerHTML = response.message;
				alert(response.message);
				if(response.status === 'ok') {
					window.location = '/?site=question&id='+response.id;
				}
			}
		)
		.catch(
			error => $('#question-message').innerHTML = error
		);
	};

	const $ = document.querySelector.bind(document);
	const $$ = document.querySelectorAll.bind(document);

	init();

})();
