(() => {
  "use strict";
  
	const init = () => {
		$('button[name=login]').addEventListener('click', loginClick);
		//$('button[name=register]').addEventListener('click', registerClick);
		$('#register-form').addEventListener('submit', registerClick);
	};
	
	const loginClick = () => { 
		window.location = "/?site=login"; 
	};

	const registerClick = (evt) => { 
		evt.preventDefault();
		let formData = new FormData();
		formData.append('nickname', $('input[name=nickname]').value);
		formData.append('password', $('input[name=psw]').value);
		formData.append('xsrf', $('meta[name=xsrf-token]').content);
		fetch('/api/register.php',
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
				$('#register-message').innerHTML = response.message;
				alert(response.message);
				if(response.status === 'ok') {
					window.location = '/?site=login';
				}
			}
		)
		.catch(
			error => $('#register-message').innerHTML = error
		);
	};

	const $ = document.querySelector.bind(document);
	const $$ = document.querySelectorAll.bind(document);
	
	init();
	
})();
