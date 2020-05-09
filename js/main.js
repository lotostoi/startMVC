class Good {
    renderGood(id_product, name_product, link_img, price, deck) {

        return `     
            <div class='cotalog__product'>
                <a href='index.php?page=good/${id_product}' data-id='${id_product}' class='cotalog__nameProduct'>
                    <img src='${link_img}' alt='${name_product}' class='cotalog__img' width='100' height='190'>
                </a>
                <a href='index.php?page=good/${id_product}' data-id='${id_product}' class='cotalog__nameProduct'> ${name_product} </a>
                <span class='cotalog__priceProduct'>$ ${price} </span>
                <button data-id='${id_product}'   class='cotalog__addCart'>Добавить в корзину</button>

            </div>
        
        `
    }
}


class Shop extends Good {
    cotalog = [];
    id_user = '';
    getCotalog(url, type, data) { // метод для отправки данных на сервер
        return fetch(url, {
            method: type,
            body: data
        })
            .then(data => data.json())
            .then(data => {
                this.cotalog = data.cotalog
                this.id_user = data.id_user
                console.log(this.id_user);
            })
            .then(data => this.render (this.cotalog))
    }
    render(arrGoods) {
        let el = document.querySelector('.contCotalog')
        arrGoods.forEach(e => {
            console.log(this)
            if (el) {
                el.innerHTML += this.renderGood(e.id, e.name, e.linkImg, e.price, e.description)
            }
        });
    }
}

let SH = new Shop
let st = 1
let fn = 8

let request = new FormData()
request.append('startN', `${st}`)
request.append('finishN', `${fn}`)

SH.getCotalog('./controller/serv.php', 'post', request)

document.querySelector('.load').addEventListener('click', () => {

    st += 8
    fn += 8
    let request = new FormData()
    request.append('startN', `${st}`)
    request.append('finishN', `${fn}`)

    SH.getCotalog('./controller/serv.php', 'post', request)

})


// обработчик кнопок добавить в корзину 

document.querySelector('.cotalog').addEventListener('click', function (evt) {
    if (evt.target.className == "cotalog__addCart") {
        let params = new FormData();
        params.append('id_product', evt.target.dataset['id'])
        params.append('id_user', SH.id_user)
        params.append('oper', 'add')
        fetch('./controller/serv.php', {
            method: 'post',
            body: params
        })
            .then(data => data.json())
            .then((data) => {
                if (data.res == "add") {
                    document.querySelector('.countCart').innerHTML = data.allQuant
                }
            })
    }
    // модальное окно с информацией о заказе
    if (evt.target.className == 'watchOrder') {

        document.querySelector('.modelWindow').classList.toggle('modelWindow-active')
        document.querySelector('.modelWindow__window').classList.toggle('modelWindow__window-active')
        document.querySelector(`div[data-idwin="${evt.target.dataset['id']}"]`).classList.toggle('modelWindow__show-active')
    }

    if (evt.target.className == "modelWindow__close") {
        document.querySelector('.modelWindow').classList.toggle('modelWindow-active')
        document.querySelector('.modelWindow__window').classList.toggle('modelWindow__window-active')
        let arr = [...document.querySelectorAll('.modelWindow__show')];
        arr.forEach(el => {
            el.classList.remove('modelWindow__show-active');
        })
    }

})
