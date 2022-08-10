document.addEventListener("DOMContentLoaded", function () {

// Создания события, получение формы и обработка

    let vrem = document.getElementById("form");

    vrem.addEventListener("submit", function (e) {
        e.preventDefault();

        let Form = new FormData(e.target);

        console.log(Form.get('FIO'));

        fetch('/handler.php', {
            method: 'POST',
            body: Form
        }
        )
            .then(response => response.json())
            .then((result) => {
                // Обработка ошибок
                if (result.errors) {
                    if (result.errors["Email"] == null) {
                        document.getElementById("Email").style.borderColor='#ced4da';
                    } else {
                        document.getElementById("Email").style.borderColor='red';
                    }

                    if (result.errors["FIO"] == null) {
                        document.getElementById("FIO").style.borderColor='#ced4da';
                    } else {
                        document.getElementById("FIO").style.borderColor='red';
                    }

                    if (result.errors["Phone"] == null) {
                        document.getElementById("Phone").style.borderColor='#ced4da';
                    } else {
                        document.getElementById("Phone").style.borderColor='red';
                    }
                    
                    if (result.errors["Comment"] == null) {
                        document.getElementById("Comment").style.borderColor='#ced4da';
                    } else {
                        document.getElementById("Comment").style.borderColor='red';
                    }
                } else {
                    console.log("Страница обновлена");
                    document.location.reload();
                }
            })
            .catch(error => console.log(error));

    })


})