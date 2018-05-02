<?php
/**
 * Created by PhpStorm.
 * User: summer
 * Date: 2018/5/3
 * Time: 0:26
 */

$client = new swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);

//连接成功
$client->on('connect', function ($cli) {
    $cli->send("Hello World!\n");
});

//接收
$client->on('receive', function ($cli, $data) {
    echo "Received:$data\n";
});

//连接失败
$client->on('error', function ($cli) {
    echo "Connect failed!\n";
});

//关闭
$client->on('close', function ($cli) {
    echo "Connect close\n";
});

//发起连接
$client->connect('127.0.0.1', 9501, 0.5);





