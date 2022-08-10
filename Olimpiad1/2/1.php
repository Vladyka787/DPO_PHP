<?php

function workingWithString(array $string_array)
{

    for ($i = 0; $i < 8; $i++) {
        if (array_key_exists($i, $string_array)) {

            if ($string_array[$i] == "") {
                if (array_key_exists($i + 1, $string_array)) {
                    if ($string_array[$i + 1] != "") {
                        for ($j = count($string_array); $j < 8; $j++) {
                            array_splice($string_array, $i, 0, "0000");
                        }
                    }
                }
            }

            for ($j = strlen($string_array[$i]); $j < 4; $j++) {
                $string_array[$i] = "0" . $string_array[$i];
            }
        } else {
            $string_array[$i] = "0000";
        }
    }

    $new_string_array = implode(":", $string_array);
    return $new_string_array;
}

for ($count = 1; $count <= 8; $count++) {
    // Получаем входные данные
    echo "Тест №" . $count . " начался\n";

    $url = "B/00" . $count . ".dat";
    $array = file($url);

    for ($i = 0; $i < count($array); $i++) {
        $array[$i] = trim($array[$i]);
    }
    // Обработка данных

    for ($i = 0; $i < count($array); $i++) {
        $string_array = explode(":", $array[$i]);
        $array[$i] = workingWithString($string_array);
    }

// Получаем выходные данные
    $url = "B/00" . $count . ".ans";
    $verify_array = file($url);

    for ($i = 0; $i < count($verify_array); $i++) {
        $verify_array[$i] = trim($verify_array[$i]);
    }

    $error = 0;
    for ($i = 0; $i < count($array); $i++) {
        if ($array[$i] == $verify_array[$i]) {
        } else {
            $error++;
        }
    }

    if ($error == 0) {
        echo "Тест пройден\n";
    } else {
        echo "Тест не пройден\n";
    }
}
