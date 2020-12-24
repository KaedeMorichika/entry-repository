<?php
require_once(__DIR__ . '/config/const.php');
require_once(__DIR__ . '/vendor/autoload.php');
require_once(__DIR__ . '/utils/auth_utils.php');

require_once(__DIR__ . '/class/auth/SingletonPDO.php');

if (!empty($_GET['action'])) {
    $action = sanitize_get($_GET['action']);
}

if (!empty($action)) {
    require_once(__DIR__ . '/action/' . $action . '.php');
}
