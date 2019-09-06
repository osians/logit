<?php

require_once __DIR__ . '/../src/LogitLevel.php';
require_once __DIR__ . '/../src/LogitInterface.php';
require_once __DIR__ . '/../src/LogitAbstract.php';
require_once __DIR__ . '/../src/Logit.php';

use Osians\Logit\Logit;
use Osians\Logit\LogitLevel;
use PHPUnit\Framework\TestCase;

class LogitTest extends TestCase
{
    private $logPath;

    private $logger;
    private $errLogger;

    public function setUp()
    {
        $this->logPath = __DIR__.'/logs';

        $this->logger = new Logit($this->logPath, LogitLevel::DEBUG, array ('flushFrequency' => 1));
        $this->errLogger = new Logit($this->logPath, LogitLevel::ERROR, array (
            'extension' => 'log',
            'prefix' => 'error_',
            'flushFrequency' => 1
        ));
    }

    public function testImplementsPsr3LoggerInterface()
    {
        $this->assertInstanceOf('\Osians\Logit\LogitInterface', $this->logger);
    }

    public function testAcceptsExtension()
    {
        $this->assertStringEndsWith('.log', $this->errLogger->getLogFilePath());
    }

    public function testAcceptsPrefix()
    {
        $filename = basename($this->errLogger->getLogFilePath());
        $this->assertStringStartsWith('error_', $filename);
    }

    public function testWritesBasicLogs()
    {
        $this->logger->log(LogitLevel::DEBUG, 'This is a test');
        $this->errLogger->log(LogitLevel::ERROR, 'This is a test');

        $this->assertTrue(file_exists($this->errLogger->getLogFilePath()));
        $this->assertTrue(file_exists($this->logger->getLogFilePath()));

        $this->assertLastLineEquals($this->logger);
        $this->assertLastLineEquals($this->errLogger);
    }


    public function assertLastLineEquals(Logit $logr)
    {
        $this->assertEquals($logr->getLastLogLine(), $this->getLastLine($logr->getLogFilePath()));
    }

    public function assertLastLineNotEquals(Logit $logr)
    {
        $this->assertNotEquals($logr->getLastLogLine(), $this->getLastLine($logr->getLogFilePath()));
    }

    private function getLastLine($filename)
    {
        $size = filesize($filename);
        $fp = fopen($filename, 'r');
        $pos = -2; // start from second to last char
        $t = ' ';

        while ($t != "\n") {
            fseek($fp, $pos, SEEK_END);
            $t = fgetc($fp);
            $pos = $pos - 1;
            if ($size + $pos < -1) {
                rewind($fp);
                break;
            }
        }

        $t = fgets($fp);
        fclose($fp);

        return trim($t);
    }

    public function tearDown() {
        #@unlink($this->logger->getLogFilePath());
        #@unlink($this->errLogger->getLogFilePath());
    }
}

