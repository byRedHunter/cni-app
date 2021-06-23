const formsAjax = document.querySelectorAll('.formAjax')

const alertAjax = (alert) => {
	switch (alert.alert) {
		case 'simple':
			Swal.fire({
				icon: alert.type,
				title: alert.title,
				text: alert.text,
				confirmButtonText: 'Aceptar',
			})
			break

		case 'recargar':
			Swal.fire({
				icon: alert.type,
				title: alert.title,
				text: alert.text,
				confirmButtonText: 'Aceptar',
			}).then((result) => {
				if (result.value) {
					location.reload()
				}
			})
			break

		case 'limpiar':
			Swal.fire({
				icon: alert.type,
				title: alert.title,
				text: alert.text,
				confirmButtonText: 'Aceptar',
			}).then((result) => {
				if (result.value) {
					document.querySelector('.formAjax').reset()
				}
			})
			break

		case 'redireccionar':
			window.location.href = alert.url
			break
	}
}

const sendFormAjax = (form) => {
	const data = new FormData(form)
	const method = form.getAttribute('method')
	const action = form.getAttribute('action')
	const type = form.getAttribute('data-form')

	const headers = new Headers()

	const config = {
		method,
		headers,
		mode: 'cors',
		cache: 'no-cache',
		body: data,
	}

	let textAlert = 'Quieres realizar la operacion solicitada'

	if (type === 'save') textAlert = 'Los datos quedaran guardados en el sistema.'
	if (type === 'delete')
		textAlert = 'Los datos seran eliminados completamente del sistema.'
	if (type === 'update') textAlert = 'Los datos del sistema seran actualizados.'
	if (type === 'search')
		textAlert =
			'Se eliminara el termino de busqueda y tendra qeu escribir uno nuevo.'
	if (type === 'loans') textAlert = '¿Desea remover los datos seleccionados?.'

	Swal.fire({
		icon: 'question',
		title: '¿Estás Seguro?',
		text: textAlert,
		showCancelButton: true,
		confirmButtonColor: '#06368b',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Aceptar',
		cancelButtonText: 'Cancelar',
	}).then((result) => {
		if (result.value) {
			fetch(action, config)
				.then((response) => response.json())
				.then((alert) => {
					return alertAjax(alert)
				})
		}
	})
}

formsAjax.forEach((form) => {
	form.addEventListener('submit', (e) => {
		e.preventDefault()

		sendFormAjax(form)
	})
})
