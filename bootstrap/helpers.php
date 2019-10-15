<?php

function randColor() {
    $colArray = ["f44336", "9C27B0", "2196F3", "00BCD4", "009688", "4CAF50", "FFC107", "FF9800", "795548", "607D8B"];
    return "#" . $colArray[array_rand($colArray)];
}
