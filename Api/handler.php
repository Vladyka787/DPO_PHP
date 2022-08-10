<?php
require_once('key.php');

//Получаем данные методом POST и обрабатываем их
$address = htmlspecialchars($_POST["address"], ENT_QUOTES);

$arr = explode(' ', $address);

$processed = [];
for ($i = 0; $i < count($arr); $i++) {
    if ($arr[$i] == '') {
        break;
    } else {
        $processed[] = $arr[$i];
    }
}

$addressNew = implode('+', $processed);

//Делаем запрос в Апи на получаени координат и структурированного адреса
$values = [
    'apikey' => $key,
    'format' => 'json',
    'geocode' => $addressNew,
];
$parameters = http_build_query($values);

$path = 'https://geocode-maps.yandex.ru/1.x/?' . $parameters;

$data = json_decode(file_get_contents($path), true);

$structureAddress = $data['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['metaDataProperty']['GeocoderMetaData']['text'];

$coord = $data['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos'];

//Делаем запрос на получение ближайшего метро, по координатам
$valuesMetro = [
    'apikey' => $key,
    'format' => 'json',
    'geocode' => $coord,
    'kind' => 'metro',
    'results' => 1,
];

$parametersMetro = http_build_query($valuesMetro);

$path = 'https://geocode-maps.yandex.ru/1.x/?' . $parametersMetro;

$dataMetro = json_decode(file_get_contents($path), true);

$metroAddress = $dataMetro['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['metaDataProperty']['GeocoderMetaData']['text'];

//Выводим все данные
echo "<div style='padding: 1em;'><p>Адрес: " . $structureAddress . "\n</p>";
echo "<p>Координаты " . $coord . "\n</p>";
echo "<p>Ближайшее метро: " . $metroAddress . "</p></div>";

exit();
