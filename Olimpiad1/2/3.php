<?php

$string = "2aaa'3'bbb'4'";
// Используем регулярные выражения и получаем нужные данные
preg_match_all("/'[0-9]+'/", $string, $matches);

$array = $matches[0];

$new_matches = $matches;
// Обрабатываем строку
for ($i = 0; $i < count($matches[0]); $i++) {
    $array[$i] = trim($array[$i], "'");
    $new_matches[0][$i] = str_replace($array[$i], ($array[$i] * 2), $matches[0][$i]);
}

for ($i = 0; $i < count($matches[0]); $i++) {
    $string = str_replace($matches[0][$i], $new_matches[0][$i], $string);
}

echo $string;
