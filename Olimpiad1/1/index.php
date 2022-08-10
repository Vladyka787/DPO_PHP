<?php
// Функция для обработки массива файла с входными данными
// Принимаем на вход массив на выход даем обработанный массив
function workingWithAnArray(array $arrIn)
{

    $arrWork = [];

    $arrWork[] = trim(explode(" ", $arrIn[0], 1)[0]);

    $n = $arrWork[0];

    for ($i = 0; $i < $n; $i++) {
        $arrWork[] = explode(" ", $arrIn[$i + 1], 3);
        $arrWork[$i + 1][2] = trim($arrWork[$i + 1][2]);
    }

    $arrWork[] = trim(explode(" ", $arrIn[1 + $n], 1)[0]);

    $m = $arrWork[1 + $n];

    for ($i = 0; $i < $m; $i++) {
        $arrWork[] = explode(" ", $arrIn[$i + $n + 2], 5);
        $arrWork[$i + $n + 2][4] = trim($arrWork[$i + $n + 2][4]);
    }

    return $arrWork;
}

// Функция для проверка данных в соответсвии с требованиями
// На вход массив на выход булевое значение Тру-ошибок нет, фолс-есть ошибки
function dataValidation(array $arrWork)
{
    $error = 0;

    $n = $arrWork[0];
    $m = $arrWork[1 + $n];

    if ($n < 1 && $n > 100000) {
        $error++;
    }

    for ($i = 0; $i < $n; $i++) {
        if ($arrWork[$i + 1][0] < 1 || $arrWork[$i + 1][0] > 100000) {
            $error++;
        }
        if ($arrWork[$i + 1][1] < 1 || $arrWork[$i + 1][1] > 1000) {
            $error++;
        }
        if ($arrWork[$i + 1][2] != "R" && $arrWork[$i + 1][2] != "L" && $arrWork[$i + 1][2] != "D") {
            $error++;
        }
    }

    if ($m < 1 && $m > 100000) {
        $error++;
    }

    for ($i = 0; $i < $m; $i++) {
        if ($arrWork[$i + $n + 2][0] < 1 || $arrWork[$i + $n + 2][0] > 100000) {
            $error++;
        }
        for ($j = 1; $j <= 3; $j++) {
            if ($arrWork[$i + $n + 2][$j] < 1 || $arrWork[$i + $n + 2][$j] > 100) {
                $error++;
            }
        }
        if ($arrWork[$i + $n + 2][4] != "R" && $arrWork[$i + $n + 2][4] != "L" && $arrWork[$i + $n + 2][4] != "D") {
            $error++;
        }
    }

    if ($error == 0) {
        return true;
    } else {
        return false;
    }
}

// Работа с массивом и получение результата выигрыша
// На вход массив, на выход число
function getResult(array $arrWork)
{
    $n = $arrWork[0];
    $m = $arrWork[1 + $n];

    $sum = 0;

    for ($i = 0; $i < $n; $i++) {
        for ($j = 0; $j < $m; $j++) {
            if ($arrWork[$i + 1][0] == $arrWork[$j + 2 + $n][0]) {
                if ($arrWork[$i + 1][2] == $arrWork[$j + 2 + $n][4]) {
                    if ($arrWork[$i + 1][2] == "L") {
                        $sum += $arrWork[$i + 1][1] * $arrWork[$j + 2 + $n][1] - $arrWork[$i + 1][1];
                        break;
                    }
                    if ($arrWork[$i + 1][2] == "R") {
                        $sum += $arrWork[$i + 1][1] * $arrWork[$j + 2 + $n][2] - $arrWork[$i + 1][1];
                        break;
                    }
                    if ($arrWork[$i + 1][2] == "D") {
                        $sum += $arrWork[$i + 1][1] * $arrWork[$j + 2 + $n][3] - $arrWork[$i + 1][1];
                        break;
                    }
                } else {
                    $sum -= $arrWork[$i + 1][1];
                    break;
                }
            }
        }
    }

    return $sum;
}

$count = 0;
// Цикл для получения файлов
while (true) {

    $count++;

    // Сcылки на файл
    $url_in = "./A/00" . $count . ".dat";
    $url_out = "./A/00" . $count . ".ans";

    if (file_exists($url_in) && file_exists($url_out)) {

        echo "Тест №" . $count . " начат\n";
        echo "Ваши данные:\n";
        // Считываем данные из файла с входными данными
        $arr_in = file($url_in);
        // Обрабатываем массив
        $arr_work = workingWithAnArray($arr_in);

        // Проверка данных
        if (dataValidation($arr_work)) {
            echo "Валидация пройдена.\n";
            // Считываем данные из файла с выходными данными
            $file_out = trim(file($url_out)[0]);

            //var_dump($file_out);
            // Получаем результат
            $result = getResult($arr_work);

            echo "Ожидаемый результат: " . $file_out . "\n";
            echo "Получившийся результат: " . $result . "\n";
            // Сравниваем ожидания и реальность
            if ($file_out == $result) {
                echo "Тест пройден.\n";
            } else {
                echo "Тест не пройден.\n";
            }
        } else {
            echo "Валидация не пройдена.\n";
        }

    } else {
        echo "Тесты закончились\n";
        echo "Ура";
        break;
    }
}
