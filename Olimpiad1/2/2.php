<?php

for ($fileNumber = 1; $fileNumber <= 14; $fileNumber++) {
    // Получение данных
    if ($fileNumber < 10) {
        $arr = file("C/00" . $fileNumber . ".dat");
    } else {
        $arr = file("C/0" . $fileNumber . ".dat");
    }
    $result = $arr;
    // Работа с данными
    for ($i = 0; $i < count($arr); $i++) {
        $arr[$i] = trim($arr[$i], "\n");

        preg_match("/> [SNPDE]/", $arr[$i], $matches);

        switch ($matches[0][2]) {
                // Обработка строки
            case "S":
                preg_match_all("/> [SNPDE] [0-9]+ [0-9]+/", $arr[$i], $posleStr);
                preg_match_all("/[0-9]+/", $posleStr[0][0], $perem);
                $n = $perem[0][0];
                $m = $perem[0][1];
                $regular = "[a-zA-Z '_]{" . $n . "," . $m . "}";
                preg_match_all("/<" . $regular . ">/", $arr[$i], $findStr);
                preg_match_all("/" . $regular . "/", $findStr[0][0], $findStr);
                if (array_key_exists(0, $findStr[0])) {
                    $result[$i] = "OK";
                } else {
                    $result[$i] = "FAIL";
                }

                break;
            case "N":
                // Обработка цифр
                preg_match_all("/> [SNPDE] -?[0-9]+ -?[0-9]+/", $arr[$i], $posleStr);
                preg_match_all("/-?[0-9]+/", $posleStr[0][0], $perem);
                $n = $perem[0][0];
                $m = $perem[0][1];
                $regular = "-?[0-9]+";
                preg_match_all("/<" . $regular . ">/", $arr[$i], $findStr);
                preg_match_all("/" . $regular . "/", $findStr[0][0], $findStr);
                if (array_key_exists(0, $findStr[0])) {
                    if (($findStr[0][0] >= $n) && ($findStr[0][0] <= $m)) {
                        $result[$i] = "OK";
                    } else {
                        $result[$i] = "FAIL";
                    }
                } else {
                    $result[$i] = "FAIL";
                }

                break;
            case "P":
                // Обработка номера
                $regular = "\+7 \(999\) 999-99-99";
                preg_match_all("/<" . $regular . ">/", $arr[$i], $findStr);
                if (array_key_exists(0, $findStr[0])) {
                    $result[$i] = "OK";
                } else {
                    $result[$i] = "FAIL";
                }

                break;
            case "D":
                // Обработка даты
                $regular = "[0-9]{1,2}\.[0-9]{1,2}\.[0-9]{4} [0-9]{1,2}:[0-9]{2}";
                preg_match_all("/<" . $regular . ">/", $arr[$i], $findStr);

                $str = $findStr[0][0];
                $str = ltrim($str, "<");
                $str = rtrim($str, ">");
                $str = explode(' ', $str);

                $data = explode('.', $str[0]);

                $time = explode(':', $str[1]);

                if (array_key_exists(0, $findStr[0])) {
                    if (checkdate($data[1], $data[0], $data[2])) {
                        if (($time[0] < 24) && ($time[1] < 60)) {
                            $result[$i] = "OK";
                            break;
                        }
                    }
                    $result[$i] = "FAIL";
                } else {
                    $result[$i] = "FAIL";
                }

                break;
            case "E":
                // Обработка имейла
                $regular = "[a-zA-Z][a-zA-Z0-9_]{3,29}@[a-zA-Z]{2,30}[.][a-z]{2,10}";
                preg_match_all("/<" . $regular . ">/", $arr[$i], $findStr);
                if (array_key_exists(0, $findStr[0])) {
                    $result[$i] = "OK";
                } else {
                    $result[$i] = "FAIL";
                }
                break;
        }
    }

    // Получение выходных данных и проверка
    if ($fileNumber < 10) {
        $proverka = file("C/00" . $fileNumber . ".ans");
    } else {
        $proverka = file("C/0" . $fileNumber . ".ans");
    }

    for ($j = 0; $j < count($proverka); $j++) {
        $proverka[$j] = trim($proverka[$j], "\n");
    }

    if ($proverka == $result) {
        echo "Тест №" . $fileNumber . " удачно.";
    } else {
        echo "Тест №" . $fileNumber . " провален.";
    }
}
