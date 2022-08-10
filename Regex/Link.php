<?php
// Получаем данные
$fileDataName = 'text.txt';

$fileDataContent = file_get_contents($fileDataName);
// Ищем строку старого формата
preg_match_all('/http:\/\/asozd\.duma\.gov\.ru\/main\.nsf\/\(Spravka\)\?OpenAgent&RN=[0-9-]+&[0-9]+/', $fileDataContent, $matches);

$matches = $matches[0];
// Для каждой строки делаем новый формат и меняем со старым
foreach ($matches as $match) {
    preg_match_all('/[0-9-]+&/', $match, $res);

    $str = $res[0][0];
    $str = substr($str, 0, -1);

    $zamena = "http://sozd.parlament.gov.ru/bill/" . $str;

    $fileDataContent = str_replace($match, $zamena, $fileDataContent);
}
// Выводим ответ
echo $fileDataContent;
