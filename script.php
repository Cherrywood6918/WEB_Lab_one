<?php

session_start();

if (!isset($_SESSION['dataTable'])) {
    $_SESSION['dataTable'] = [];
}


if($_POST['flag'] === "true") {
    $result = dataGeneration();
    array_push($_SESSION['dataTable'], $result);
    echo $result;
}
else if (($_POST['flag'] === "false")) {
    foreach ($_SESSION['dataTable'] as $values){
        echo $values;

    }
}


function checkArea($x, $y, $r)
{
    if (($x * $x + $y * $y <= $r * $r) && (2 * $x + $r >= $y) &&
        ($x <= $r) && ($x >= -$r) && ($x >= 0 || $y >= 0)) return "<span class='true'>Попадет</span>";
    else return "<span class='false'>Не попадает</span>";
}

function validate($x, $y, $r)
{
    $fieldX = !validateStr($x) && $x >= -5 && $x <= 5;
    $fieldY = !validateStr($y) && $y >= -3 && $y <= 3;
    $fieldR = !validateStr($r) && $r >= 2 && $r <= 5;

    return $fieldX && $fieldY && $fieldR;
}

function validateStr($str)
{
    return strlen(trim($str)) === 0 || $str === "-0" || !is_numeric($str);
}

function dataGeneration() {
    $start = microtime(true);
    $valueX = $_POST['coordinateX'];
    $valueY = $_POST['coordinateY'];
    $valueR = $_POST['radius'];
    if (!validate($valueX, $valueY, $valueR)) {
        http_response_code(400);
    } else {
        $res = checkArea($valueX, $valueY, $valueR);
        date_default_timezone_set('Europe/Moscow');
        $time = date('H:i:s');
        $finish = microtime(true);
        $execute = number_format($finish - $start, 5, ',', '')."sec";
        return "<tr>
                    <td>$valueX</td>
                    <td>$valueY</td>
                    <td>$valueR</td>
                    <td>$time</td>
                    <td>$execute</td>
                    <td>$res</td>
                 </tr>";

    }
}





