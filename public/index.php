<?php

require __DIR__.'/../vendor/autoload.php';

use src\app\Client;



function main($argv) {
    $csv = file($argv[1]);

    $client = new Client();
    $client($csv);
}


main($argv);