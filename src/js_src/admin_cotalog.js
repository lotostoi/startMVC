window.onload = () => {

    //  редaктирование текущего коталога


    document.querySelector('.cont__cotalogAdmin').addEventListener('click', (evt) => {

        if (evt.target.className == 'cotalog_admin_button') {

            let paramss = new FormData();
            paramss.append('start_admin', true)
            paramss.append('id_good_admin', evt.target.dataset.idGoodAdmin)
            fetch('./controller/serv.php', {
                method: 'post',
                body: paramss
            })
                .then(data => data.json())
                .then(data => {
                    if (data.id) {
                        document.querySelector('.admin_modelWindow').style.display = 'flex'
                        document.querySelector('.admin_modelWindow').innerHTML = `
                        <form class='contItem' id="formEdit" method="POST"> 
                            <span class="close"> X </span>
                            <div class='contItem__left'>
                                <input name="id" type="hidden" value="${data.id}">
                                <input name="editGood" type="hidden" value="yes">
                                <label class='contItem__label'>ID продукта: 
                                    <span>${data.id}</span>
                                </label>
                                <label class='contItem__label'>Имя продуката: 
                                    <input type='text' name='name' class='contItem__inp' value='${data.name}'>
                                </label>
                                <label class='contItem__label'>Цена продукта: 
                                    <input type='text' name='price' class='contItem__inp' value='${data.price}'>
                                </label>
                                <label class='contItem__label'>Ссылка на изображение: 
                                    <input type='text'  name='link' class='contItem__inp' value='${data.linkImg}'>
                                </label>
                                <textarea name='description' class='contItem__inpText' value='${data.description}'> ${data.description} </textarea>
                              
                                <label class='contItem__lebDell'>
                                    <div>Удалить товар</div>
                                    <input type='checkbox' name='delete' class='contItem__inpDel'>
                                </label>
                                <label class='contItem__lebDell'>  
                                    <button type='submit'  class='contItem__inpDel'> Сохранить изменения </button>
                                    <span class='messeg_inform'> Изменения добавлены в базу данных </span>
                                </label>
                            </div>
                            <div class='contItem__right' data-contimg='name-${data.id}'>
                                <img src=${data.linkImg} alt='img' class='contItem__img' height='300'>
                            </div>
                        </form>      
                        `
                        document.querySelector('span.close').addEventListener('click', (evt) => {
                            document.querySelector('.admin_modelWindow').style.display = 'none'
                        })

                        document.querySelector(`input[name='link']`).addEventListener('input', (evt) => {

                            document.querySelector('.contItem__right').innerHTML = ` <img src=${evt.target.value} alt='img' class='contItem__img' height='300'>`

                        })

                        document.querySelector('#formEdit').addEventListener('submit', (evt) => {

                            evt.preventDefault()

                            fetch('./controller/serv.php', {
                                method: 'post',
                                body: new FormData(formEdit)
                            })
                                .then(data => data.json())
                                .then(data => {
                                    if (data.res == 'good') {

                                        let par = document.querySelector(`div[data-cont-id="${data.good[0].id}"]`)

                                        par.querySelector('img').src = data.good[0].linkImg
                                        par.querySelector('.good_name').innerHTML = data.good[0].name


                                        document.querySelector('.messeg_inform').style.opacity = '1'
                                        setTimeout(() => { document.querySelector('.messeg_inform').style.opacity = '0' }, 5000);
                                    }
                                    if (data.res == 'dell') {
                                        document.querySelector('.contItem__left').style.display = 'none'
                                        document.querySelector('.contItem__right').style.display = 'none'
                                        document.querySelector('.contItem').innerHTML += `<h2 style="color:red; font-size:30px; margin:auto;">Товар успешно удален из каталога!</h2>`
                                        document.querySelector(`div[data-cont-id="${data.id}"]`).style.display = 'none'
                                        document.querySelector('span.close').addEventListener('click', (evt) => {
                                            document.querySelector('.admin_modelWindow').style.display = 'none'
                                        })
                                    }


                                })

                        })

                    }


                })
        }
    })



}

