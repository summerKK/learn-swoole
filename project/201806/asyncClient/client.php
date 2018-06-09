<?php
/**
 * Created by PhpStorm.
 * User: summer
 * Date: 2018/6/9
 * Time: 18:52
 */

class Client
{
    private $_client;

    public function __construct()
    {
        $this->_client = new swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);

        $this->_client->on('connect', [$this, 'onConnect']);

        $this->_client->on('receive', [$this, 'onReceive']);

        $this->_client->on('close', [$this, 'onClose']);

        $this->_client->on('error', [$this, 'onError']);
    }

    public function connect()
    {
        $fp = $this->_client->connect('127.0.0.1', 9501, 1);
        if (!$fp) {
            echo <<<EOF
Error:{$fp->errMsg}[{$fp->errCode}]
EOF;
            return;

        }
    }

    public function onConnect(swoole_client $cli)
    {
        fwrite(STDOUT, "enter msg:");
        while (true) {
            $cli->send(mt_rand(100, 99999));
            usleep(500000);
        }
        swoole_event_add(STDIN, function ($fp) use ($cli) {
            fwrite(STDOUT, "enter msg:");
            $msg = trim(fgets(STDIN));
            $cli->send($msg);
        });
    }

    public function onReceive(swoole_client $cli, $data)
    {
        echo $data . "\n";
    }

    public function onClose(swoole_client $cli)
    {
        echo <<<EOF
client close connection
EOF;

    }

    public function onError()
    {

    }

    public function send($data)
    {
        $this->_client->send($data);
    }

    public function isConnected()
    {
        return $this->_client->isConnected();
    }
}

(new Client())->connect();