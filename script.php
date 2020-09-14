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
    $fieldX = preg_match("/^[-]?(([0-4]{1}[\,|\.]{1}[0-9]{1,})|[0-5])$/",$x) && $x!=="-0";
    $fieldY = preg_match("/^[-]?(([0-2]{1}[\,|\.]{1}[0-9]{1,})|[0-3])$/",$y) && $y!=="-0";
    $fieldR = preg_match("/^(([2-4]{1}[\,|\.]{1}[0-9]{1,})|[2-5])$/",$y);
    return $fieldX && $fieldY && $fieldR;
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





