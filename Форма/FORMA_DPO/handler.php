<?php
session_start();

$_SESSION = array();

header('Content-Type: application/json');

// Получение данных 

$FIO = htmlspecialchars($_POST['FIO'], ENT_QUOTES);
$Email = htmlspecialchars($_POST['Email'], ENT_QUOTES);
$Phone = htmlspecialchars($_POST['Phone'], ENT_QUOTES);
$Comment = htmlspecialchars($_POST['Comment'], ENT_QUOTES);

$now = date("Y-m-d H:i:s");

$errors = [];

// Обработка данных и проверка

$FIO = rtrim($FIO, " \n\r\t\v\x00");
$Email = rtrim($Email, " \n\r\t\v\x00");
$Phone = rtrim($Phone, " \n\r\t\v\x00");
$Comment = rtrim($Comment, " \n\r\t\v\x00");

if ($FIO != '') {
    $FIO_Arr = explode(' ', $FIO);
    $nameFirst = $FIO_Arr[1];
    $nameMiddle = $FIO_Arr[0];
    $nameLast = $FIO_Arr[2];
}

if ($FIO == "") {
    $errors["FIO"] = true;
}

$sootv = preg_match("/^[a-zA-Z]\S{2,30}@\w{1,10}\.(com|ru)/", $Email, $matches);
if ($sootv) {
    if ($matches[0] != $Email) {
        $errors["Email"] = true;
    }
} else {
    $errors["Email"] = true;
}

$sootv = preg_match("/^(8|\+7)\d{10}/", $Phone, $matches);
if ($sootv) {
    if ($matches[0] != $Phone) {
        $errors["Phone"] = true;
    }
} else {
    $errors["Phone"] = true;
}
if ($Comment == "") {
    $errors["Comment"] = true;
}

if (!empty($errors)) {
    echo json_encode(['errors' => $errors]);
    die();
}

$message = wordwrap($Comment, 70, "\r\n");

$result = mail($Email, 'Email', $message);

if ($result) {
    $_SESSION['email'] = $Email;
    $_SESSION['nameFirst'] = $nameFirst;
    $_SESSION['nameMiddle'] = $nameMiddle;
    $_SESSION['nameLast'] = $nameLast;
    $_SESSION['phone'] = $Phone;
    $_SESSION['time'] = $now;
}

// Проверка на повтор сообщения в течении часа

$connection = new PDO('pgsql:host=localhost;dbname=form', 'postgres', 'postgres');

$sql = 'SELECT max(U.time)
    FROM "User" U
    WHERE email=:email
    GROUP BY U.time
    ORDER BY U.time DESC
    LIMIT 1';

$sql_proverka = $connection->prepare($sql);
$sql_proverka->bindValue(':email', $Email, PDO::PARAM_STR);
$sql_proverka->execute();

$test = $sql_proverka->fetch();

$data_proverka = new DateTime(date("Y-m-d H:i:s", strtotime($test['max'])));

$data_proverka->modify('+1 hour');


// если все хорошо, то сохраняется в бд новое письмо

if (strtotime($data_proverka->format("Y-m-d H:i:s")) < strtotime('now')) {

    $sql = 'INSERT INTO "User" (email,fio,phone,comment,time)
VALUES (:email,:fio,:phone,:comment,:time)';

    $sql_reg = $connection->prepare($sql);
    $sql_reg->bindValue(':email', $Email, PDO::PARAM_STR);
    $sql_reg->bindValue(':fio', $FIO, PDO::PARAM_STR);
    $sql_reg->bindValue(':phone', $Phone, PDO::PARAM_STR);
    $sql_reg->bindValue(':comment', $Comment, PDO::PARAM_STR);
    $sql_reg->bindValue(':time', $now, PDO::PARAM_STR);
    $sql_reg->execute();

    echo json_encode(['success' => true]);
} else {
    $_SESSION['povtor'] = $data_proverka->format("Y-m-d H:i:s");

    echo json_encode(['success' => true]);
}
