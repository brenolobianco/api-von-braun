<?php

namespace App\Services;

use phpseclib3\Net\Telnet;

class TelnetService
{
    protected $telnet;

    public function __construct($hostname, $port, $username, $password)
    {
        $this->telnet = new Telnet($hostname, $port);
        $this->login($username, $password);
    }

    protected function login($username, $password)
    {
        $this->telnet->login($username, $password);
    }

    public function sendCommand($command)
    {
        $this->telnet->write($command . "\r\n");
        return $this->telnet->read();
    }

    public function __destruct()
    {
        $this->telnet->disconnect();
    }
}
