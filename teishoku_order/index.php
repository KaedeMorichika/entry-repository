<?php
require_once(__DIR__ . '/config/const.php');
require_once(__DIR__ . '/vendor/autoload.php');
require_once(__DIR__ . '/utils/auth_utils.php');

require_once(__DIR__ . '/class/auth/SingletonPDO.php');

if (!empty($_SESSION)) {

    session_start();
    if (!empty($_POST['user_id']) && !empty($_POST['password'])) {

    }

}


if (!empty($_GET['action'])) {
    $action = sanitize_get($_GET['action']);
}

if (!empty($action)) {
    require_once(__DIR__ . '/action/' . $action . '.php');
}
