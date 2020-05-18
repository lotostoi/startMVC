document.querySelector('.orders').addEventListener('click', (evt) => {
    let e = evt.target
    if (e.className === 'ord__button' || e.className === 'ord__button base' || e.className === 'ord__button active') {
        document.querySelector(`div[data-id='${evt.target.dataset['id']}']`).classList.toggle('active')

        if (e.className == 'ord__button' || e.className == 'ord__button base') {
            e.classList.add('active')
            e.classList.remove('base')
            e.innerHTML = 'Cкрыть'
            console.log('rrr')
        } else {
            e.classList.remove('active')
            e.classList.add('base')
            e.innerHTML = 'Посмотреть заказ'
            console.log('rrr')
        }


    }

})