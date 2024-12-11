const _pgdown = (opt = {}) => 
{
	if ((typeof opt.id == 'undefined')) {
		throw "_pgdown() the element id is undefined!"
	}

	const container = document.getElementById(opt.id)

	let pages   = parseInt(container.getAttribute('data-pages'))
	let current = parseInt(container.getAttribute('data-current'))

	const select  = document.createElement('select')
	const next  = document.createElement('button')
	const prev  = document.createElement('button')
	const first = document.createElement('button')
	const last  = document.createElement('button')
	const text  = document.createElement('p')

	next.innerHTML  = (typeof opt.next == 'undefined') ? 'Next' : opt.next
	prev.innerHTML  = (typeof opt.prev == 'undefined') ? 'Prev' : opt.prev
	first.innerHTML = (typeof opt.first == 'undefined') ? 'First' : opt.first
	last.innerHTML  = (typeof opt.last == 'undefined') ? 'Last' : opt.last
	select.innerHTML += `<option selected value="${current}">${current}</option>`

	next.setAttribute('class', '__pgs_next __pgs_btn')
	prev.setAttribute('class', '__pgs_prev __pgs_btn')
	first.setAttribute('class', '__pgs_first __pgs_btn')
	last.setAttribute('class', '__pgs_last __pgs_btn')
	select.setAttribute('class', '__pgs_select')
	text.setAttribute('class', '__pgs_text')

	container.appendChild(first)
	container.appendChild(prev)
	container.appendChild(select)
	container.appendChild(next)
	container.appendChild(last)
	container.appendChild(text)

	for (let i = 1; i <= pages; i++) {
		let option = document.createElement('option')
		option.value = i
		option.innerHTML = i
		select.appendChild(option)
	}

	first.addEventListener('click', function () {
		current = 1
		container.setAttribute('data-current', current)
		select.selectedIndex = current
		_pgdown_actions_change(pages, current, first, last, next, prev, text)
	})	

	last.addEventListener('click', function () {
		current = pages
		container.setAttribute('data-current', current)
		select.selectedIndex = current
		_pgdown_actions_change(pages, current, first, last, next, prev, text)
	})	

	next.addEventListener('click', function () {
		if (current < pages) {
			current++
		}

		container.setAttribute('data-current', current)
		select.selectedIndex = current
		_pgdown_actions_change(pages, current, first, last, next, prev, text)
	})

	prev.addEventListener('click', function () {
		if (current > 1) {
			current--
		}

		container.setAttribute('data-current', current)
		select.selectedIndex = current
		_pgdown_actions_change(pages, current, first, last, next, prev, text)
	})

	select.addEventListener('change', function () {
		current = this.value
		container.setAttribute('data-current', current)
		_pgdown_actions_change(pages, current, first, last, next, prev, text)
	})

	_pgdown_actions_change(pages, current, first, last, next, prev, text)
}

const _pgdown_actions_change = (pages, current, first, last, next, prev, text) => 
{
	if (current >= pages) {
		last.disabled = true
		next.disabled = true
	} else {
		last.disabled = false
		next.disabled = false
	}

	if (current <= 1) {
		first.disabled = true
		prev.disabled = true
	} else {
		first.disabled = false
		prev.disabled = false
	}

	text.innerHTML = `Page ${current} of ${pages}`
}

/*
$(document).ready(function () {

	$('.__pgs_btn').on('click', function () {
		let page = $('#_pgs').attr('data-current')
		alert(page)
	})

	$('.__pgs_select').on('change', function () {
		let page = $('#_pgs').attr('data-current')
		alert(page)
	})
})
*/