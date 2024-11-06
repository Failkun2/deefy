<?php

require_once 'vendor/autoload.php';

session_start();

use iutnc\deefy\dispatch\Dispatcher as Dispatcher;
use iutnc\deefy\repository\DeefyRepository as DeefyRepository;

try {
    DeefyRepository::setConfig(__DIR__ . '\db.config.ini');
    $dispatcher = new Dispatcher();
    $dispatcher->run();
} catch (Exception $e) {
    echo "<p>Erreur : " . $e->getMessage() . "</p>";
}