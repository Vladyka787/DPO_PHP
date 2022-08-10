<?php

// Цикл по файлам
for ($numberFile = 1; $numberFile <= 6; $numberFile++) {
//    Получение входных данных
    $fileDataName = 'C/' . $numberFile . '.dat';

    $fileDataContent = file_get_contents($fileDataName);

    $fileDataArr = explode("\n", $fileDataContent);
    if ($fileDataArr[count($fileDataArr) - 1] === "") {
        unset($fileDataArr[count($fileDataArr) - 1]);
    }

//    Обработка массива
    $workArr = [];

    $count = 0;

    foreach ($fileDataArr as $arr) {
        $arr=explode(' ', $arr);
        $workArr[$count][0] = $arr[0];
        $workArr[$count][1] = $arr[1];
        $count++;
    }

    unset($count);

//  Варианты выбора
    $options = [];

    foreach ($workArr as $arr) {
        for ($i = 0; $i < $arr[1]; $i++) {
            $options[] = $arr[0];
        }
    }

//    Рассчет статистики
    $resultDisplay = [];

    for ($i = 0; $i < (10 ** 6); $i++) {
        $chislo = random_int(0, count($options) - 1);
        if (array_key_exists($options[$chislo], $resultDisplay)) {
            $resultDisplay[$options[$chislo]]++;
        } else {
            $resultDisplay[$options[$chislo]] = 1;
        }
    }
//  Вывод
    $result = [];

    for ($i = 0, $iMax = count($resultDisplay); $i < $iMax; $i++) {
        $result[] = $workArr[$i][0] . ' ' . ($resultDisplay[$workArr[$i][0]] / (10 ** 6));
        echo $workArr[$i][0] . ' ' . ($resultDisplay[$workArr[$i][0]] / (10 ** 6)) . "\n";
    }

    echo "\n";
}