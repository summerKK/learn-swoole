<?php
/**
 * Created by PhpStorm.
 * User: summer
 * Date: 2018/5/3
 * Time: 0:14
 */

$client = new swoole_client(SWOOLE_SOCK_TCP);

//连接到服务器
if (!$client->connect('127.0.0.1', 9501, 0.5)) {
    die("Connect failed!\n");
}

//向服务器发送数据
$n = 0;
while ($n <= 100) {
    if (!$client->send('Hello World')) {
        die("Send failed!\n");
    }

    //从服务器接收数据
    $data = $client->recv();
    if (!$data) {
        die("receive failed!\n");
    }

    echo $data . "\n";

    usleep(500);
    $n++;
}


$client->close();