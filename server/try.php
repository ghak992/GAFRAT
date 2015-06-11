<?php

 require_once 'config.php';
    require_once 'DBoperations.php';
    require_once 'cryptpass.php';
    


echo count(DBoperations::getLogsScreenshot(3));