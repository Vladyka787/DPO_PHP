//Слушаем документ
document.addEventListener("DOMContentLoaded", function () {
    //Получаем форму
    let form = document.getElementById("form_address");
    //Ставим ивент на отправку формы
    form.addEventListener("submit", function (e) {
        //Запрещаем перезагрузку
        e.preventDefault();

        //Обрабатываем форму, чтобы позже добавить в нее данные с апи
        let add_post_Form = new FormData(document.forms.form_address);
        let vstavka = document.getElementById("test");
        //Получаем из формы адрес
        let adr = document.forms.form_address.elements.address.value;

        //Делаем запрос к обработчику
        fetch('handler.php', {
                method: 'POST',
                body: add_post_Form,
            }
        )
            .then(response => response.text())//Получаем текстовый ответ
            .then((result) => {
                if (result.length > 0) {//Если ответ получен, то выводим его
                    vstavka.insertAdjacentHTML('beforeend', result);
                //    Ответ добавляется после формы
                }
            })
            .catch(error => console.log(error));
    })


})