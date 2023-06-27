<?php

if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
    $uri = 'https://';
} else {
    $uri = 'http://';
}
$uri .= $_SERVER['HTTP_HOST'];

define('BASE_URL', $uri . '/students/2022-2023/web1/dev_233/public/');
define('CSS_PATH', BASE_URL . 'css/');
define('JS_PATH', BASE_URL . 'js/');
define('IMAGES_PATH', BASE_URL . 'images/');
define('ICONS_PATH', IMAGES_PATH . 'icons/');