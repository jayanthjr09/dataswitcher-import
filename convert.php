<?php



require __DIR__ . '/vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Xenus\Connection;
use Src\Import;

$log = new Logger('Dataswitcher Tech Challenge');
$log->pushHandler(new StreamHandler('app.log', Logger::DEBUG));
$log->info('Running Conversion');



// CALL YOUR CODE HERE
//TODO move configs to env and take from there
$connection = new Connection('mongodb://dsw_challenge_mongodb:27017', 'dataswitcher');

$import = new Import($connection, $log);
$import->run();

// END YOUR CALL HERE

$log->info('Conversion Finished');
echo "\n Conversion Finished! \n";


