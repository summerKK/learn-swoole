<?php
/**
 * Created by PhpStorm.
 * User: summer
 * Date: 2018/6/24
 * Time: 0:42
 */

class asyncMysql
{
    /** @var \Swoole\Mysql $_dbConnection */
    private $_dbConnection = null;
    private $_config = [];

    public function __construct(array $config)
    {
        $this->_dbConnection = new \Swoole\Mysql();

        $this->_config = $config;
    }

    public function query()
    {
        $this->_dbConnection->connect($this->_config, function ($db, $result) {
            if ($result === false) {
                var_dump($db->connect_errno, $db->connect_error);
                exit();
            }
            $sql = 'show tables';
            $db->query($sql, function (swoole_mysql $db, $r) {
                if ($r === false) {
                    var_dump($db->error, $db->errno);
                } elseif ($r === true) {
                    var_dump($db->affected_rows, $db->insert_id);
                }
                var_dump($r);
                $db->close();
            });
        });
    }

}

$config = [
    'host' => 'mysql',
    'port' => 3306,
    'user' => 'root',
    'password' => 'root',
    'database' => 'webim',
    'charset' => 'utf8', //指定字符集
    'timeout' => 2,  // 可选：连接超时时间（非查询超时时间），默认为SW_MYSQL_CONNECT_TIMEOUT（1.0）
];

(new asyncMysql($config))->query();