<?php

$autoloadFilePath = __DIR__ . '/../vendor/autoload.php';

if (!file_exists($autoloadFilePath)) {
    throw new \Exception('autoload.php not found. Make sure to run composer install.');
}

require $autoloadFilePath;
