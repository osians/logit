<?php

namespace Osians\Logit;

use Datetime;
use Osians\Logit\LogLevel;

class Logit
{
    protected $options = array(
        'extension' => 'log',
        'dateFormat'=> 'Y-m-d H:i:s.u'
    );

    /**
     *    File Pointer para o arquivo de Log
     *
     *    @var resource
     */
    private $fileHandle;

    /**
     *    Nivel de Log minimo
     *
     *    @var string
     */
    protected $logLevel = LogLevel::DEBUG;

    /**
     *    Permissao default para arquivos de Log
     *
     *    @var integer
     */
    private $defaultPermissions = 0777;

    public function __construct(
        $logDirectory,
        $logLegel = LogLevel::DEBUG,
        $options = array()
    ) {
        $this->setLogLevel($logLevel);
        $this->setOptions($options);
        $this->setLogDirectory($logDirectory);
    }

    /**
     *    Seta nivel do Log
     *
     *    @param string $logLevel
     */
    public function setLogLevel($logLevel)
    {
        $this->logLevel = $logLevel;
    }

    /**
     *    Seta Opcoes
     *
     *    @param array $options
     */
    public function setOptions($options = array())
    {
        $this->options = array_merge($this->options, $options);
    }

    public function setLogDirectory($logDirectory)
    {
        $logDirectory = rtrim($logDirectory, DIRECTORY_SEPARATOR);
        if (!file_exists($logDirectory)) {
            mkdir($logDirectory, $this->defaultPermissions, true);
        }
    }
}
