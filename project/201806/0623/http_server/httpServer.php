<?php
/**
 * Created by PhpStorm.
 * User: summer
 * Date: 2018/6/23
 * Time: 18:20
 */

class httpServer
{
    /** @var swoole_server swoole_server */
    private $_server;

    public function __construct()
    {
        $this->_server = new swoole_http_server('0.0.0.0', '9501');

        $this->_server->set(
            [
                'enable_static_handler' => true,
                'document_root' => '/var/www/learn-sw/project/201806/0623/http_server/data/',
            ]
        );

        $this->_server->on('request', [$this, 'onRequest']);

        $this->_server->start();
    }

    public function onRequest(swoole_http_request $request, swoole_http_response $response)
    {
        $response->cookie('summer', 'Hello World', time() + 3600);
        return $response->end('Hi Summer!');
    }
}

new httpServer();