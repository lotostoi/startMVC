window.onload=()=>{//  редaктирование текущего коталога
document.querySelector(".cont__cotalogAdmin").addEventListener("click",a=>{if("cotalog_admin_button"==a.target.className){let b=new FormData;b.append("start_admin",!0),b.append("id_good_admin",a.target.dataset.idGoodAdmin),fetch("./controller/serv.php",{method:"post",body:b}).then(a=>a.json()).then(a=>{a.id&&(document.querySelector(".admin_modelWindow").style.display="flex",document.querySelector(".admin_modelWindow").innerHTML=`
                        <form class='contItem' id="formEdit" method="POST"> 
                            <span class="close"> X </span>
                            <div class='contItem__left'>
                                <input name="id" type="hidden" value="${a.id}">
                                <input name="editGood" type="hidden" value="yes">
                                <label class='contItem__label'>ID продукта: 
                                    <span>${a.id}</span>
                                </label>
                                <label class='contItem__label'>Имя продуката: 
                                    <input type='text' name='name' class='contItem__inp' value='${a.name}'>
                                </label>
                                <label class='contItem__label'>Цена продукта: 
                                    <input type='text' name='price' class='contItem__inp' value='${a.price}'>
                                </label>
                                <label class='contItem__label'>Ссылка на изображение: 
                                    <input type='text'  name='link' class='contItem__inp' value='${a.linkImg}'>
                                </label>
                                <textarea name='description' class='contItem__inpText' value='${a.description}'> ${a.description} </textarea>
                              
                                <label class='contItem__lebDell'>
                                    <div>Удалить товар</div>
                                    <input type='checkbox' name='delete' class='contItem__inpDel'>
                                </label>
                                <label class='contItem__lebDell'>  
                                    <button type='submit'  class='contItem__inpDel'> Сохранить изменения </button>
                                    <span class='messeg_inform'> Изменения добавлены в базу данных </span>
                                </label>
                            </div>
                            <div class='contItem__right' data-contimg='name-${a.id}'>
                                <img src=${a.linkImg} alt='img' class='contItem__img' height='300'>
                            </div>
                        </form>      
                        `,document.querySelector("span.close").addEventListener("click",()=>{document.querySelector(".admin_modelWindow").style.display="none"}),document.querySelector(`input[name='link']`).addEventListener("input",a=>{document.querySelector(".contItem__right").innerHTML=` <img src=${a.target.value} alt='img' class='contItem__img' height='300'>`}),document.querySelector("#formEdit").addEventListener("submit",a=>{a.preventDefault(),fetch("./controller/serv.php",{method:"post",body:new FormData(formEdit)}).then(a=>a.json()).then(a=>{if("good"==a.res){let b=document.querySelector(`div[data-cont-id="${a.good[0].id}"]`);b.querySelector("img").src=a.good[0].linkImg,b.querySelector(".good_name").innerHTML=a.good[0].name,document.querySelector(".messeg_inform").style.opacity="1",setTimeout(()=>{document.querySelector(".messeg_inform").style.opacity="0"},5e3)}"dell"==a.res&&(document.querySelector(".contItem__left").style.display="none",document.querySelector(".contItem__right").style.display="none",document.querySelector(".contItem").innerHTML+=`<h2 style="color:red; font-size:30px; margin:auto;">Товар успешно удален из каталога!</h2>`,document.querySelector(`div[data-cont-id="${a.id}"]`).style.display="none",document.querySelector("span.close").addEventListener("click",()=>{document.querySelector(".admin_modelWindow").style.display="none"}))})}))})}})};