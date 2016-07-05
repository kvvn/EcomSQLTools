<?php
/**
 * Created by PhpStorm.
 * User: kvvn
 * Date: 6/15/16
 * Time: 3:33 PM
 */

namespace Kvvn\SimpleMigrations;


class Config {
    private $connection1 = [
        'host' => 'localhost',
        'db' => 'test1',
        'user' => 'kvvn',
        'pass' => 'nau08fel',
        'type'=> 'main'
    ];
    private $connection2 = [
        'host' => 'localhost',
        'db' => 'test2',
        'user' => 'kvvn',
        'pass' => 'nau08fel',
        'type'=> 'main'
    ];
    private $connection3 = [
        'host' => 'localhost',
        'db' => 'test3',
        'user' => 'kvvn',
        'pass' => 'nau08fel',
        'type' => 'subservice'
    ];
    private $connection4 = [
        'host' => 'localhost',
        'db' => 'test4',
        'user' => 'kvvn',
        'pass' => 'nau08fel',
        'type' => 'subservice'
    ];


    public function getConnections() {
        $res = [];

        $connections = get_object_vars($this);
        foreach ($connections as $k => $connection) {
            $res[] = $connection;
        }
        return $res;
    }

}