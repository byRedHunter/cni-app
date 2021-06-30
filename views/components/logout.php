<script>
  let btnSalir = document.querySelector('.btn-exit-system');

  btnSalir.addEventListener('click', (e) => {
    e.preventDefault()

    Swal.fire({
			title: '¿Quieres salir del sistema?',
			text: "La sesión actual se cerrara y saldras del sistema",
			icon: 'question',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Si, salir!',
			cancelButtonText: 'No, cancelar'
    }).then((result) => {
      if(result.value) {
				const url = '<?php echo SERVERURL; ?>ajax/loginAjax.php'
        const token = '<?php echo $loginController->encryption($_SESSION['token']); ?>'
        const username = '<?php echo $loginController->encryption($_SESSION['username']); ?>'

        const data = new FormData()
        data.append('token', token)
        data.append('username', username)

        fetch(url, {
          method: 'POST',
          body: data,
        })
        .then(response => response.json())
        .then(alert => {
          return alertAjax(alert)
        })
      }
    })
  })
</script>