<?php
/**
 * Created by PhpStorm.
 * User: summer
 * Date: 2018/5/2
 * Time: 0:30
 */


$serv = new swoole_http_server('0.0.0.0', 9501);

$serv->on('request', function ($request, $response) {
    var_dump($request->get, $request->post);
    $response->header("Content-Type", "text/html; charset=utf-8");
    $response->end("<h1>Hello Swoole. #" . rand(1000, 9999) . "</h1>");
});

$serv->start();