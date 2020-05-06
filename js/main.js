class Good {
    renderGood(id_product, name_product, link_img, price, deck) {

        return `     
            <div class='cotalog__product'>
                <a href='E-Shop.php?page=${id_product}&name=${name_product}&link=${link_img}&price=${price}&text=${deck}' data-id='${id_product}' class='cotalog__nameProduct'>
                    <img src='${link_img}' alt='${name_product}' class='cotalog__img' width='100' height='190'>
                </a>
                <a href='E-Shop.php?page=${id_product}&name=${name_product}&link=${link_img}&price=${price}&text=${deck}' data-id='${id_product}' class='cotalog__nameProduct'> ${name_product} </a>
                <span class='cotalog__priceProduct'>$ ${price} </span>
                <button data-id='${id_product}' class='cotalog__addCart'>Добавить в корзину</button>

            </div>
        
        `
    }
}


class Shop extends Good {
    cotalog = [];
    getCotalog(url, type, data) { // метод для отправки данных на сервер
        return fetch(url, {
            method: type,
            body: data
        })
            .then(data => data.json())
            .then(data => this.cotalog = data)
            .then(data => this.render(data))
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

SH.getCotalog('./controller/server.php', 'post', request)

document.querySelector('.load').addEventListener('click', () => {

    st += 8
    fn += 8
    let request = new FormData()
    request.append('startN', `${st}`)
    request.append('finishN', `${fn}`)

    SH.getCotalog('./controller/server.php', 'post', request)

})