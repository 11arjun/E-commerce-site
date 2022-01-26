<?php
function sanitize_array($array){
    if (is_array($array)) {
        array_walk_recursive($array, 'sanitize_value');
    }
    else {
        sanitize_value($array);
    }
    return $array;
}

function sanitize_value(&$value) {
    $value = trim(htmlspecialchars($value, ENT_QUOTES));
}