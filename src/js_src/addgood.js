


// скрипты для шаблона добавить товар // 

document.querySelector('.contItem__right').innerHTML = `<span> Изображение не выбранно </span>`

document.querySelector(`.contItem__inp.link`).addEventListener('input', (evt) => {

    if (evt.target.files[0]) {
        document.querySelector('.contItem__right').innerHTML = ` <img src=${"./src/img/" + evt.target.files[0].name} alt='img' class='contItem__img' height='300'>`
    } else {
        document.querySelector('.contItem__right').innerHTML = `<span> Изображение не выбранно </span>`
    }

})

document.querySelector('#addGood').addEventListener('submit', (evt) => {

    evt.preventDefault()

    fetch('./controller/serv.php', {
        method: 'post',
        body: new FormData(addGood)
    })
        .then(data => data.json())
        .then(data => {
            if (data.res == 'add') {
                document.querySelector('.messeg_inform').style.opacity = '1'
                evt.target.reset();
                setTimeout(() => { document.querySelector('.messeg_inform').style.opacity = '0' }, 5000);

            }
        })
})

