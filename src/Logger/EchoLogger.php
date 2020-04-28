<?php


namespace Leankoala\LeankoalaClient\Logger;


class EchoLogger implements Logger
{
    public function log($message)
    {
        echo $message;
    }
}
