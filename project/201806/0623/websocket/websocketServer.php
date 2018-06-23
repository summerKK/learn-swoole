<?php
/**
 * Created by PhpStorm.
 * User: summer
 * Date: 2018/6/23
 * Time: 19:16
 */

class websocketServer
{
    /** @var swoole_websocket_server $_wsServer */
    private $_wsServer;

    public function __construct()
    {
        $this->_wsServer = new swoole_websocket_server('0.0.0.0', '9502');

        //参数配置
        $this->_wsServer->set([

        ]);

        //注册事件
        $this->_wsServer->on('open', [$this, 'onOpen']);

        $this->_wsServer->on('message', [$this, 'onMessage']);

        $this->_wsServer->on('close', [$this, 'onClose']);

        $this->_wsServer->start();
    }

    public function onOpen(swoole_websocket_server $server, swoole_http_request $request)
    {
        echo "server: handshake success with fd{$request->fd}\n";
        $server->push($request->fd, "swoole");
    }

    public function onMessage(swoole_websocket_server $server, swoole_websocket_frame $frame)
    {
        echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
        $server->push($frame->fd, "this is server");
    }

    public function onClose(swoole_websocket_server $server, $fd)
    {
        echo "client {$fd} closed\n";
    }
}

new websocketServer();