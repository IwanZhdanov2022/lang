<?php

namespace Iwan07\Lang\Exception;
use Iwan07\Lang\Lang;

abstract class BaseLangException extends \Exception
{
    public function __construct(string $message, Lang $langClass)
    {
        $info = $langClass->getDebugInfo();
        $msg = $message . " (script: {$info['scriptPath']}, language: {$info['language']})";
        parent::__construct($msg);
    }
}