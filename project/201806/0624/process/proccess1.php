<?php
/**
 * Created by PhpStorm.
 * User: summer
 * Date: 2018/6/24
 * Time: 18:32
 */

$process = new swoole_process(function (swoole_process $process) {

    $process->exec('/usr/bin/php7.2', [__DIR__ . '/../../0623/websocket/websocketServer.php']);

}, false);

$pid = $process->start();

echo $pid . PHP_EOL;

swoole_process::wait();

