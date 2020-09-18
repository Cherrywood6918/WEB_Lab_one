<?php

session_start();

if (!isset($_SESSION['dataTable'])) {
    $_SESSION['dataTable'] = [];
}


if($_POST['flag'] === "true") {
    $result = dataGeneration();
    array_push($_SESSION['dataTable'], $result);
    toTable($result);
}
else if (($_POST['flag'] === "false")) {
    foreach ($_SESSION['dataTable'] as $values){
        toTable($values);
    }
}

function toTable($array){
    echo "<tr>";
    foreach ($array as $value) {
        echo "<td>$value</td>";
    }
    echo "</tr>";
}


function checkArea($x, $y, $r)
{
    if (($x * $x + $y * $y <= $r * $r) && (2 * $x + $r >= $y) &&
        ($x <= $r) && ($x >= -$r) && ($x >= 0 || $y >= 0)) return "Попадет";
    else return "Не попадает";
}

function validate($x, $y, $r)
{
    $fieldX = preg_match("/^[-]?(([0-4]{1}[\,|\.]{1}[0-9]{1,})|[0-5])$/",$x) && $x!=="-0";
    $fieldY = preg_match("/^[-]?(([0-2]{1}[\,|\.]{1}[0-9]{1,})|[0-3])$/",$y) && $y!=="-0";
    $fieldR = preg_match("/^(([2-4]{1}[\,|\.]{1}[0-9]{1,})|[2-5])$/",$r);
    return $fieldX && $fieldY && $fieldR;
}

function format_number($num){
    $newNum = strlen($num)<=6? $num:number_format($num, 4);
    return rtrim(rtrim($newNum, '0'), '.');
}
function dataGeneration() {
    $start = microtime(true);
    if (!validate($_POST['coordinateX'], $_POST['coordinateY'], $_POST['radius'])) {
        http_response_code(400);
    } else {
        $valueX = format_number($_POST['coordinateX']);
        $valueY = format_number($_POST['coordinateY']);
        $valueR = format_number($_POST['radius']);
        $res = checkArea($valueX, $valueY, $valueR);
        date_default_timezone_set('Europe/Moscow');
        $time = date('H:i:s');
        $finish = microtime(true);
        $execute = number_format($finish - $start, 5, ',', '')."sec";
        return array($valueX,$valueY,$valueR,$time,$execute,$res);
    }
}





