<?php

namespace IdNow\Log;

/**
 * Class Logger
 * @package IdNow
 */
class Logger
{
    /**
     * @var bool
     */
    private $enabled;

    /**
     * @var string
     */
    private $file;

    /**
     * @var bool
     */
    private $level;

    public function __construct($enabled, $file = '', $level = '')
    {
        $this->setEnabled($enabled);


        if($this->isEnabled()) {
            if($this->checkLevel($level)) {
                $this->level = $level;
            }

            if($this->checkFile($file)) {
                $this->file = $file;
            }
        }

    }

    public function isEnabled()
    {
        return $this->enabled;
    }

    public function setEnabled($enabled)
    {
        if($enabled == true) {
            $this->enabled = true;
        } else {
            $this->enabled = false;
        }
    }

    public function checkFile($file)
    {
        if(!$file) {
            throw new \Exception('IdNow log enabled but logfile not specified.');
            return false;
        }
        if(!file_exists($file)) {
            file_put_contents($file, '');
        }
        if(is_writable($file)) {
            return true;
        }
        throw new \Exception('IdNow log file ('.$file.') not writable.');
        return false;
    }

    public function checkLevel($level)
    {
        switch($level) {
            case LogLevels::ERROR:
            case LogLevels::WARNING:
            case LogLevels::DEBUG:
                return true;
                break;
            default:
                throw new \Exception("IdNow log level has incorrect value (".$level.").");
                return false;
        }
    }

    public function log($type, $message)
    {

        switch($this->getLevel()) {
            case LogLevels::ERROR:
                if(!in_array($type, [LogTypes::ERROR])) {
                    return false;
                }
                break;
            case LogLevels::WARNING:
                if(!in_array($type, [LogTypes::ERROR, LogTypes::WARNING])) {
                    return false;
                }
                break;
            case LogLevels::DEBUG:
                break;
            default:
                return false;
        }

        switch($type) {
            case LogTypes::INFO:
                $message = 'INFO: '.$message;
                break;
            case LogTypes::WARNING:
                $message = 'WARNING: '.$message;
                break;
            case LogTypes::ERROR:
                $message = 'ERROR: '.$message;
        }
        $message = date('Y-m-d H:i:s').': '.$message."\n";
        return $this->write($message);

    }

    public function write($message)
    {
        if($this->isEnabled()) {
            return file_put_contents($this->file, $message, FILE_APPEND);
        }
        return false;
    }

    public function info($message)
    {
        return $this->log(LogTypes::INFO, $message);
    }

    public function warning($message)
    {
        return $this->log(LogTypes::WARNING, $message);
    }

    public function error($message)
    {
        return $this->log(LogTypes::ERROR, $message);
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function getFile()
    {
        return $this->file;
    }
}