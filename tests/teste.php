<?php

require_once __DIR__ . '/../src/LogLevel.php';
require_once __DIR__ . '/../src/LogitInterface.php';
require_once __DIR__ . '/../src/LogitAbstract.php';
require_once __DIR__ . '/../src/Logit.php';

 $log = new Osians\Logit\Logit(__DIR__ . '/Log/', Osians\Logit\LogLevel::INFO);
 $log->info('Informação a Logar');
 $log->error('Whoops!');
 $log->debug('x = 5');


