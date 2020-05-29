
document.querySelector('.contCartProducts__bodyCart').addEventListener('click', (evt) => {
    if (evt.target.className == 'contCartProducts__del') {
        let paramss = new FormData();
        paramss.append('id_product', evt.target.dataset['id'])
        paramss.append('id_user', evt.target.dataset['userid'])
        paramss.append('oper', '-')
        fetch('./controller/serv.php', {
            method: 'post',
            body: paramss
        })
            .then(data => data.json())
            .then((data) => {
                if (data.res == "-") {
                    document.querySelector('.contCartProducts__allSumm').innerHTML = "$" + data.allSum
                    document.querySelector('.contCartProducts__allQuantity').innerHTML = data.allQuant + " шт"
                    document.querySelector('.countCart').innerHTML = data.allQuant
                    let quant = document.querySelector(`span[data-quantId = "${evt.target.dataset['id']}"]`)
                    let price = document.querySelector(`span[data-priceId = "${evt.target.dataset['id']}"]`)
                    quant.innerHTML = (quant.dataset['quant'] - 1) + " шт"
                    price.innerHTML = "$" + (+quant.dataset['quant'] - 1) * price.dataset['price']
                    quant.setAttribute("data-quant", `${(+quant.dataset['quant'] - 1)}`)

                }
                if (data.res == "rel") {
                    window.location.reload()
                }
            })
    }
    if (evt.target.className == 'contCartProducts__add') {
        let paramss = new FormData();
        paramss.append('id_product', evt.target.dataset['id'])
        paramss.append('id_user', evt.target.dataset['userid'])
        paramss.append('oper', 'add')
        fetch('./controller/serv.php', {
            method: 'post',
            body: paramss
        })
            .then(data => data.json())
            .then((data) => {
                if (data.res == "add") {
                    document.querySelector('.contCartProducts__allSumm').innerHTML = "$" + data.allSum
                    document.querySelector('.contCartProducts__allQuantity').innerHTML = data.allQuant + " шт"
                    document.querySelector('.countCart').innerHTML = data.allQuant
                    let quant = document.querySelector(`span[data-quantId = "${evt.target.dataset['id']}"]`)
                    let price = document.querySelector(`span[data-priceId = "${evt.target.dataset['id']}"]`)
                    quant.innerHTML = (+quant.dataset['quant'] + 1) + " шт"
                    price.innerHTML = "$" + (+quant.dataset['quant'] + 1) * price.dataset['price']
                    quant.setAttribute("data-quant", `${(+quant.dataset['quant'] + 1)}`)

                }
            })
    }
    if (evt.target.className == 'contCartProducts__allClean') {
        let paramss = new FormData();
        paramss.append('id_user', evt.target.dataset['userid'])
        paramss.append('oper', 'alldel')
        fetch('./controller/serv.php', {
            method: 'post',
            body: paramss
        })
            .then(data => data.json())
            .then((data) => {
                if (data.res == "alldel") {
                    window.location.reload()
                }
            })
    }
})