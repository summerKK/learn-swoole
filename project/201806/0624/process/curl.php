<?php
/**
 * Created by PhpStorm.
 * User: summer
 * Date: 2018/6/24
 * Time: 20:56
 */

$urls = [
    'http://baidu.com',
    'http://sina.com',
    'http://360.com',
    'http://baidu.com?search=summer',
    'http://baidu.com?search=summer1',
];

/** @var swoole_process [] $workers */
$workers = [];

foreach ($urls as $url) {

    $process = new swoole_process(function (swoole_process $process) use ($url) {
        //数据写入管道
        $process->write(getContents($url));
    }, true);

    $pid = $process->start();

    $workers[$pid] = $process;

}

foreach ($workers as $worker) {
    //读取每个进程管道的数据
    echo $worker->read();
}

//模拟获取数据
function getContents($url)
{
    sleep(1);
    return "$url success" . PHP_EOL;
}