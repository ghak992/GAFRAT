<?php

ob_start();
session_start();
if(!isset($_SESSION['login'])){
    $_SESSION['login'] = false;
}

if (!$_SESSION['login']) {
    header('Location: http://localhost/GAFRAT');
}

