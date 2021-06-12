(() => {
  "use strict";
  
	const init = () => {
		//$('button[name=login]').addEventListener('click', loginClick);
		$('button[name=register]').addEventListener('click', registerClick);
		$('#login-form').addEventListener('submit', loginClick);
	};
	
	const loginClick = (evt) => { 
		evt.preventDefault();
		let formData = new FormData();
		formData.append('nickname', $('input[name=nickname]').value);
		formData.append('password', $('input[name=psw]').value);
		formData.append('xsrf', $('meta[name=xsrf-token]').content);
		fetch('/api/login.php',
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
				$('#login-message').innerHTML = response.message;
				alert(response.message);
				if(response.status === 'ok') {
					window.location = '/';
				}
			}
		)
		.catch(
			error => $('#login-message').innerHTML = error
		);
	};

	const registerClick = () => { 
		window.location = "/?site=register"; 
	};

	const $ = document.querySelector.bind(document);
	const $$ = document.querySelectorAll.bind(document);
	
	init();
	
})();
