const sliderItem = document.querySelectorAll('.slider-item')
const sliderControl = document.querySelectorAll('.slider-control-item')

const totalSliders = sliderItem.length - 1
let sliderActual = null
let sliderInterval = null

const sliderStart = () => {
	sliderItem.forEach((slider, actual) => {
		if (slider.classList.contains('active')) {
			slider.classList.remove('active')
			sliderControl[actual].classList.remove('active')
			sliderActual = actual + 1
			return
		}
	})

	if (sliderActual > totalSliders) sliderActual = 0
	sliderItem[sliderActual].classList.add('active')
	sliderControl[sliderActual].classList.add('active')
}

window.onload = () => {
	sliderInterval = setInterval(() => {
		sliderStart()
	}, 7000)

	sliderControl.forEach((control, actual) => {
		control.addEventListener('click', () => {
			window.clearInterval(sliderInterval)

			document
				.querySelector('.slider-control-item.active')
				.classList.remove('active')
			document.querySelector('.slider-item.active').classList.remove('active')

			sliderActual = actual
			sliderItem[sliderActual].classList.add('active')
			sliderControl[sliderActual].classList.add('active')

			sliderInterval = setInterval(() => {
				sliderStart()
			}, 7000)
			return
		})
	})
}
