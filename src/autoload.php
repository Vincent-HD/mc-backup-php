<?php
foreach (scandir(__DIR__) as $filename) {
    if (strpos($filename, '.php') === false || pathinfo(__FILE__, PATHINFO_FILENAME) . '.' . pathinfo(__FILE__, PATHINFO_EXTENSION) === $filename) {
        continue;
    }
    require_once $filename;
}