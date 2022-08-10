<?php

// Цикл по файлам
for ($numberFile = 1; $numberFile < 12; $numberFile++) {
//    Получение входных данных
    $fileDataName = 'D/' . $numberFile . '.dat';

    $fileDataContent = file_get_contents($fileDataName);

//    Обработка данных из файла

    $fileData = preg_replace('/\s+/', '', $fileDataContent);

    $fileData = preg_replace('/\/\*.*?\*\//', '', $fileData);

    $fileData = preg_replace('/[a-zA-Z\.#><\-_:0-9]+{}/', '', $fileData);

    $fileData = preg_replace("/[^0-9]0px/", ':0', $fileData);

    preg_match_all('/#[0-9a-fA-F]+/', $fileData, $matches);

    $matches = $matches[0];

    $workWithNumber = [];

    $count = 0;

    for ($i = 0, $iMax = count($matches); $i < $iMax; $i++) {
        if (
            ($matches[$i][1] == $matches[$i][2]) &&
            ($matches[$i][3] == $matches[$i][4]) &&
            ($matches[$i][5] == $matches[$i][6])
        ) {
            $workWithNumber[$count][0] = $matches[$i];
            $workWithNumber[$count][1] = '#' . $matches[$i][1] . $matches[$i][3] . $matches[$i][5];
            $count++;
        }
    }

    foreach ($workWithNumber as $value) {
        $fileData = str_replace($value[0], $value[1], $fileData);
    }

    $fileData = str_replace(array('#CD853F', '#FFC0CB', '#DDA0DD', '#F00', '#FFFAFA', '#D2B48C'), array('peru', 'pink', 'plum', 'red', 'snow', 'tan'), $fileData);

    preg_match_all('/margin-top:[0-9]+(px)?;margin-bottom:[0-9]+(px)?;margin-left:[0-9]+(px)?;margin-right:[0-9]+(px)?;/', $fileData, $matches, PREG_UNMATCHED_AS_NULL);

    $arrFilter = [];

    for ($i = 0, $iMax = count($matches); $i < $iMax; $i++) {
        if (($matches[$i][0] != null) && ($matches[$i][0] !== 'px')) {
            $arrFilter[][0] = $matches[$i][0];
        }
    }

    $zamena = "";

    for ($k = 0, $kMax = count($arrFilter); $k < $kMax; $k++) {
        $arr = explode(';', $arrFilter[$k][0]);
        if ($arr[count($arr) - 1] === "") {
            unset($arr[count($arr) - 1]);
        }

        $sortArr = [];

        for ($j = 0, $jMax = count($arr); $j < $jMax; $j++) {
            if (strpos($arr[$j], 'top') !== false) {
                $sortArr[0] = $arr[$j];
            }
            if (strpos($arr[$j], 'right') !== false) {
                $sortArr[1] = $arr[$j];
            }
            if (strpos($arr[$j], 'bottom') !== false) {
                $sortArr[2] = $arr[$j];
            }
            if (strpos($arr[$j], 'left') !== false) {
                $sortArr[3] = $arr[$j];
            }
        }

        $arr = $sortArr;

        $chislArr = [];

        for ($j = 0, $jMax = count($arr); $j < $jMax; $j++) {
            if (strpos($arr[$j], 'top') !== false) {
                $chislArr[] = str_replace('margin-top:', '', $arr[$j]);
            }
            if (strpos($arr[$j], 'right') !== false) {
                $chislArr[] = str_replace('margin-right:', '', $arr[$j]);
            }
            if (strpos($arr[$j], 'bottom') !== false) {
                $chislArr[] = str_replace('margin-bottom:', '', $arr[$j]);
            }
            if (strpos($arr[$j], 'left') !== false) {
                $chislArr[] = str_replace('margin-left:', '', $arr[$j]);
            }
        }

        if (
            ($chislArr[0] != $chislArr[1]) &&
            ($chislArr[0] != $chislArr[2]) &&
            ($chislArr[0] != $chislArr[3])
        ) {
            $zamena = "margin:" . $chislArr[0] . ' ' . $chislArr[1] . ' ' . $chislArr[2] . ' ' . $chislArr[3] . ';';
        } else {
            $zamena = "margin:" . $chislArr[0] . ';';
        }

        $arrFilter[$k][1] = $zamena;
    }

    foreach ($arrFilter as $value) {
        $fileData = str_replace($value[0], $value[1], $fileData);
    }

    preg_match_all('/padding-top:[0-9]+(px)?;padding-bottom:[0-9]+(px)?;padding-left:[0-9]+(px)?;padding-right:[0-9]+(px)?;/', $fileData, $matches, PREG_UNMATCHED_AS_NULL);

    $arrFilter = [];

    for ($i = 0, $iMax = count($matches); $i < $iMax; $i++) {
        if (($matches[$i][0] != null) && ($matches[$i][0] !== 'px')) {
            $arrFilter[][0] = $matches[$i][0];
        }
    }

    $zamena = "";

    for ($k = 0, $kMax = count($arrFilter); $k < $kMax; $k++) {
        $arr = explode(';', $arrFilter[$k][0]);
        if ($arr[count($arr) - 1] === "") {
            unset($arr[count($arr) - 1]);
        }

        $sortArr = [];

        for ($j = 0, $jMax = count($arr); $j < $jMax; $j++) {
            if (strpos($arr[$j], 'top') !== false) {
                $sortArr[0] = $arr[$j];
            }
            if (strpos($arr[$j], 'right') !== false) {
                $sortArr[1] = $arr[$j];
            }
            if (strpos($arr[$j], 'bottom') !== false) {
                $sortArr[2] = $arr[$j];
            }
            if (strpos($arr[$j], 'left') !== false) {
                $sortArr[3] = $arr[$j];
            }
        }

        $arr = $sortArr;

        $chislArr = [];

        for ($j = 0, $jMax = count($arr); $j < $jMax; $j++) {
            if (strpos($arr[$j], 'top') !== false) {
                $chislArr[] = str_replace('padding-top:', '', $arr[$j]);
            }
            if (strpos($arr[$j], 'right') !== false) {
                $chislArr[] = str_replace('padding-right:', '', $arr[$j]);
            }
            if (strpos($arr[$j], 'bottom') !== false) {
                $chislArr[] = str_replace('padding-bottom:', '', $arr[$j]);
            }
            if (strpos($arr[$j], 'left') !== false) {
                $chislArr[] = str_replace('padding-left:', '', $arr[$j]);
            }
        }

        if (
            ($chislArr[0] != $chislArr[1]) &&
            ($chislArr[0] != $chislArr[2]) &&
            ($chislArr[0] != $chislArr[3])
        ) {
            $zamena = "padding:" . $chislArr[0] . ' ' . $chislArr[1] . ' ' . $chislArr[2] . ' ' . $chislArr[3] . ';';
        } else {
            $zamena = "padding:" . $chislArr[0] . ';';
        }

        $arrFilter[$k][1] = $zamena;
    }

    foreach ($arrFilter as $value) {
        $fileData = str_replace($value[0], $value[1], $fileData);
    }

    $fileData = str_replace(';}', '}', $fileData);

    echo $fileData;
}