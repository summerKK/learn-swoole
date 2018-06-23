<?php
/**
 * Created by PhpStorm.
 * User: summer
 * Date: 2018/6/9
 * Time: 18:52
 */

class Server
{
    /** @var swoole_server swoole_server */
    private $_server;

    public function __construct()
    {
        $this->_server = new swoole_server('0.0.0.0', 9501);

        $this->_server->on('start', [$this, 'onStart']);

        $this->_server->on('connect', [$this, 'onConnect']);

        $this->_server->on('receive', [$this, 'onReceive']);

        $this->_server->on('close', [$this, 'onClose']);

        $this->_server->start();
    }

    /**
     * @param \Swoole\Server $server
     */
    public function onStart($server)
    {
        echo <<<EOF
$server->host,$server->port \n
EOF;

    }

    public function onConnect($server, $fd, $fromId)
    {
        echo <<<EOF
Client {$fd} connect \n
EOF;

    }

    public function onReceive(swoole_server $server, $fd, $fromId, $data)
    {
        echo "receive data from {$fd}:$data\n";
    }

    public function onClose($server, $fd, $fromId)
    {
        echo <<<EOF
client {$fd} close connection \n
EOF;

    }
}

new Server();
