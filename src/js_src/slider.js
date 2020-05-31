window.onload = () => {
    let d = document;
    // *********************** Slider ************************************ //
    // *********************** Slider ************************************ //
    // *********************** Slider ************************************ //
    let count = 1;
    d.querySelector(".slider").addEventListener("click", workClick);

    function workClick(evt) {
        let target = evt.target;
        d.querySelector(".slider").removeEventListener("click", workClick);
        clickHandler(target, add);

        function add() {
            d.querySelector(".slider").addEventListener("click", workClick);
        }

        function clickHandler() {
            if (target.dataset["number"]) {
                d.querySelectorAll(".bunner").forEach((el, i) => {
                    if (el.dataset["id"] === target.dataset["number"]) {
                        d.querySelectorAll(".bunner").forEach(el => {
                            el.classList.remove("bunnerActiv");
                        });
                        d.querySelectorAll(".check").forEach(el => {
                            el.classList.remove("checkActiv");
                        });
                        el.classList.add("bunnerActiv");
                        target.classList.add("checkActiv");
                        count = i + 1;
                    }
                });
            }
            if (target.dataset["id"] == "next") {
                count++;
                if (count > [...d.querySelectorAll(".bunner")].length) {
                    count = 1;
                }
                d.querySelectorAll(".bunner").forEach(el => {
                    if (el.dataset["id"] == count) {
                        d.querySelectorAll(".bunner").forEach(el => {
                            el.classList.remove("bunnerActiv");
                        });
                        d.querySelectorAll(".check").forEach(el => {
                            el.classList.remove("checkActiv");
                        });
                        el.classList.add("bunnerActiv");
                        d.querySelectorAll(".check").forEach(el => {
                            if (el.dataset["number"] == count) {
                                el.classList.add("checkActiv");
                            }
                        });
                    }
                });
            }
            setTimeout(() => {
                add.call(window);
            }, 610);
        }
    }
}
// обработчик кнопок добавть в корзину

document.querySelector('.slider').addEventListener('click', function (evt) {
    if (evt.target.className == "bunner__button") {
        let params = new FormData();
        params.append('id_product', evt.target.dataset['id'])
        params.append('id_user', evt.target.dataset['user'])
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
})