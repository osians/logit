<?php

use Osians\Logit\Logit;
use Osians\Logit\LogLevel;
use PHPUnit\Framework\TestCase;

class LogitTest extends TestCase
{
    private $logPath;

    private $logger;
    private $errLogger;

    public function setUp()
    {
        $this->logPath = __DIR__.'/logs';
        $this->logger = new Logger($this->logPath, LogLevel::DEBUG, array ('flushFrequency' => 1));
        $this->errLogger = new Logger($this->logPath, LogLevel::ERROR, array (
            'extension' => 'log',
            'prefix' => 'error_',
            'flushFrequency' => 1
        ));
    }

    
}

