document.querySelector('.orders').addEventListener('click', (evt) => {
    let e = evt.target
    if (e.className === 'ord__button' || e.className === 'ord__button base' || e.className === 'ord__button active') {

        let el = document.querySelector(`div[data-id='${evt.target.dataset['id']}']`);

        el.classList.toggle('active')

        if (e.className == 'ord__button' || e.className == 'ord__button base') {

            e.classList.add('active')
            e.classList.remove('base')
            e.innerHTML = 'Cкрыть'

        } else {
            e.classList.remove('active')
            e.classList.add('base')
            e.innerHTML = 'Посмотреть заказ'

        }


    }

})