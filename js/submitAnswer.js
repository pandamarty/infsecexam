(() => {
	"use strict";

	const init = () => {
		$('button[name=submitAnswer]').addEventListener('click', submitAnswerClick);
	};

	const submitAnswerClick = (evt) => {
		evt.preventDefault();
		let formData = new FormData();
		formData.append('answer', $('textarea[name=answer]').value);
		formData.append('questionID', $('input[name=questionID]').value);
		formData.append('xsrf', $('meta[name=xsrf-token]').content);
		fetch('/api/submitAnswer.php',
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
				$('#answer-message').innerHTML = response.message;
				alert(response.message);
				if(response.status === 'ok') {
					window.location.reload();
				}
			}
		)
		.catch(
			error => $('#answer-message').innerHTML = error
		);
	};

	const $ = document.querySelector.bind(document);
	const $$ = document.querySelectorAll.bind(document);

	init();

})();
