<?php

namespace IdNow;

use IdNow\Log\Logger;

/**
 * Class Client
 * @package IdNow
 */
class Client
{
    use ManipulatesConnectionData;
    /**
     * @var string
     */
    private $companyId;


    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var string
     */
    private $apiVersion;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var bool
     */
    private $testMode;

    /**
     * Default API version
     */
    const DEFAULT_API_VERSION = 'v1';


    /**
     * Client constructor.
     * @param string $companyId
     * @param string $apiKey
     * @param string $apiVersion
     */
    public function __construct($companyId, $apiKey, $apiVersion = self::DEFAULT_API_VERSION, $testMode = false,
        $logging = false,
        $logFile = '',
        $logLevel = '')
    {
        $this->companyId = $companyId;
        $this->apiKey = $apiKey;
        $this->apiVersion = $apiVersion;
        $this->testMode = $testMode;
        if($logging) {
            $this->configureLogging(true, $logFile, $logLevel);
        } else {
            $this->getLoggerInstance();
        }
    }

    public function getIdentificationWebformLink($transactionId = null)
    {
        if($transactionId) {
            return $this->getProtocol().$this->getGoDomain($this->testMode).'/'.$this->getCompanyId().'/userdata/'.$transactionId;
        }
        return $this->getProtocol().$this->getGoDomain($this->testMode).'/'.$this->getCompanyId().'/userdata';
    }

    public function getLoggerInstance()
    {
        if(!$this->logger) {
            $this->logger = new Logger(false);
        }
        return $this->logger;
    }

    public function configureLogging($enableLogging, $logFile = '', $logLevel = Logger::LEVEL_ERROR)
    {
        $this->logger = new Logger($enableLogging, $logFile, $logLevel);
    }

    public function getCompanyId()
    {
        return $this->companyId;
    }

    public function getApiKey()
    {
        return $this->apiKey;
    }

    public function getApiVersion()
    {
        return $this->apiVersion;
    }

    public function setCompanyId($companyId)
    {
        $this->companyId = $companyId;
        return $this;
    }

    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
        return $this;
    }

    public function setApiVersion($apiVersion)
    {
        $this->apiVersion = $apiVersion;
        return $this;
    }
}