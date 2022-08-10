<?php session_start(); ?>
<!doctype html>
<html lang="ru">

<head>
    <!-- Обязательные метатеги -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Форма!</title>

    <script src="handler.js"></script>
</head>

<body>
    <?php if (!array_key_exists('email', $_SESSION)) { ?>
        <form action="handler.php" method="POST" id="form">
            <div class="mb-3">
                <label for="FIO" class="form-label">ФИО</label>
                <input type="text" class="form-control" id="FIO" name="FIO">
            </div>
            <div class="mb-3">
                <label for="Email" class="form-label">Имейл</label>
                <input type="email" class="form-control" id="Email" name="Email">
            </div>
            <div class="mb-3">
                <label for="Phone" class="form-label">Телефон</label>
                <input type="tel" class="form-control" id="Phone" name="Phone">
            </div>
            <div class="mb-3">
                <label for="Comment" class="form-label">Комментарий</label>
                <input type="text" class="form-control" id="Comment" name="Comment">
            </div>
            <button type="submit" class="btn btn-primary">Отправить</button>
        </form>
        <?php } else {
        if (array_key_exists('povtor', $_SESSION)) {
            if (strtotime(date("Y-m-d H:i:s")) < strtotime($_SESSION['povtor'])) { ?>
                <p>Отправте повторную заявку через <?php
                                                    $ost = strtotime($_SESSION['povtor']) - strtotime(date("Y-m-d H:i:s")) - 10800;
                                                    echo date("H:i:s", $ost);
                                                    $_SESSION = array();
                                                    ?></p>
            <?php }
        } else { ?>
            <p>Оставлено сообщение из формы обратной связи.</p>
            <p>Имя: <?php echo $_SESSION['nameFirst'] ?></p>
            <p>Фамилия: <?php echo $_SESSION['nameMiddle'] ?></p>
            <p>Отчество: <?php echo $_SESSION['nameLast'] ?></p>
            <p>E-mail: <?php echo $_SESSION['email'] ?></p>
            <p>Телефон: <?php echo $_SESSION['phone'] ?></p>
            <p>С вами свяжуться после <?php $date = new DateTime(date("Y-m-d H:i:s", strtotime($_SESSION['time'])));
                                        $date->modify('+1 hour +30 minutes');
                                        echo $date->format("Y-m-d H:i:s")  ?></p>
    <?php }
    } ?>
</body>

</html>