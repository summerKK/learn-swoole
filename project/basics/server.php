<?php
/**
 * Created by PhpStorm.
 * User: summer
 * Date: 2018/5/1
 * Time: 22:04
 */


//创建SERVER,监听9501端口
$serv = new swoole_server('0.0.0.0', 9501);

//监听连接事件
$serv->on('connect', function ($serv, $fd) {
    echo "Client:Connect.\n";
});

//监听数据接受事件
$serv->on('receive', function ($serv, $fd, $from_id, $data) {
    $serv->send($fd, "Server:$data");
});

//监听关闭事件
$serv->on('close', function ($serv, $fd) {
    echo "Client:Close.\n";
});

//启动服务
$serv->start();
