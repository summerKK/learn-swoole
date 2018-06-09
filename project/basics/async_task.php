<?php
/**
 * Created by PhpStorm.
 * User: summer
 * Date: 2018/5/2
 * Time: 1:16
 */


$serv = new swoole_server('0.0.0.0', 9501);

//异步工作进程数量
$serv->set(['task_worker_num' => 4]);

$serv->on('receive', function ($serv, $fd, $formId, $data) {
    //异步处理
    $taskId = $serv->task($data);
    echo "Dispath AsyncTask:id=$taskId\n";
});

//处理异步任务
$serv->on('task', function ($serv, $taskId, $fromId, $data) {
    echo "New AysncTask[id=$taskId]" . PHP_EOL;
    //返回任务结果
    $serv->finish("$data -> ok");
});

//异步结果任务
$serv->on('finish', function ($serv, $taskId, $data) {
    echo "AsyncTask[$taskId] Finish: $data" . PHP_EOL;
});

$serv->start();