<?php

// Цикл по файлам
for ($numberFile = 1; $numberFile < 5; $numberFile++) {
//    Получение входных данных
    $fileDataName = 'A/' . $numberFile . '.dat';

    $fileDataContent = file_get_contents($fileDataName);

    $fileDataArr = explode("\n", $fileDataContent);
    if ($fileDataArr[count($fileDataArr) - 1] === "") {
        unset($fileDataArr[count($fileDataArr) - 1]);
    }

    $workArray = [];
//  Обработка данных
    for ($i = 0, $iMax = count($fileDataArr); $i < $iMax; $i++) {
        for ($j = 0, $jMax = strlen($fileDataArr[$i]); $j < $jMax; $j++) {
            if ($j < 8) {
                $workArray[$i][0] .= $fileDataArr[$i][$j];
            }
            if ($j > 15) {
                $workArray[$i][1] .= $fileDataArr[$i][$j];
            }
        }
    }

    $preResult = [];

    for ($i = 0, $iMax = count($workArray); $i < $iMax; $i++) {
        if (array_key_exists($workArray[$i][0], $preResult)) {
            $preResult[$workArray[$i][0]][0]++;
            if (strtotime($preResult[$workArray[$i][0]][2]) < strtotime($workArray[$i][1])) {
                $preResult[$workArray[$i][0]][2] = $workArray[$i][1];
            }
        } else {
            $preResult[$workArray[$i][0]][0] = 1;
            $preResult[$workArray[$i][0]][1] = $workArray[$i][0];
            $preResult[$workArray[$i][0]][2] = $workArray[$i][1];
        }
    }

    $result = [];

    foreach ($preResult as $elem) {
        $result[] = $elem[0] . ' ' . $elem[1] . ' ' . $elem[2];
    }
//  Получение выходных данных
    $fileDataName = "A/" . $numberFile . ".out";

    $fileResultContent = file_get_contents($fileDataName);

    $fileResultArr = explode("\n", $fileResultContent);
    if ($fileResultArr[count($fileResultArr) - 1] === "") {
        unset($fileResultArr[count($fileResultArr) - 1]);
    }
//  Сравнение работы программы с предполагаемыми выходными данными
    $error = 0;
    for ($j = 0, $jMax = count($fileResultArr); $j < $jMax; $j++) {
        if ($result[$j] != $fileResultArr[$j]) {
            $error++;
        }
    }

    if ($error != 0) {
        echo "Ошибка сравнения результат с файлом " . $fileDataName . " \n";
    }
}