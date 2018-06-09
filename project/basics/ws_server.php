<?php
/**
 * Created by PhpStorm.
 * User: summer
 * Date: 2018/5/2
 * Time: 1:05
 */


$serv = new swoole_websocket_server('0.0.0.0', 9501);

//监听websocket连接打开事件
$serv->on('open', function ($ws, $request) {
    var_dump($request->fd, $request->get, $request->server);
    $ws->push($request->fd, 'Hello,welcome\n');
});

//监听websock消息事件
$serv->on('message', function ($ws, $request) {
    echo "Message:{$request->data}\n";
    $ws->push($request->fd, "Server:{$request->data}");
});

//监听websocket关闭事件
$serv->on('close', function ($ws, $fd) {
    echo "Client-$fd is closed\n";
});


$serv->start();