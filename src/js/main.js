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
    button_off = false;
    getCotalog(url, type, data) { // метод для отправки данных на сервер
        document.querySelector('.contCotalog__preloader').classList.toggle('active')
        return fetch(url, {
            method: type,
            body: data
        })
            .then(data => data.json())
            .then(data => {
                this.cotalog = data.cotalog
                this.id_user = data.id_user
                this.button_off = data.button_off
            })
            .then(data => {
                this.render(this.cotalog, this.button_off)
                document.querySelector('.contCotalog__preloader').classList.toggle('active')
                this.__getLastEl().classList.add('active')
            })
    }
    render(arrGoods, button_off) {
        let el = document.querySelector('.contCotalog')
        if (button_off) {
            document.querySelector('.load').style.display = 'none'
        } else {
            document.querySelector('.load').style.display = 'flex'
        }

        if (!arrGoods) {
            el.innerHTML = `<h3> По вашему запросу совпадений не найдено! </h3>`
        } else {
            arrGoods.forEach(e => {
              
                if (el) {
                    el.innerHTML += this.renderGood(e.id, e.name, e.linkImg, e.price, e.description)
                }
            });
        }

    }
    __getLastEl() {
        let arr = document.querySelectorAll('.cotalog')
        console.log(arr[arr.length - 1])
        return arr[arr.length - 1]
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
