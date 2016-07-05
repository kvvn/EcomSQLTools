<?php
/**
 * Created by PhpStorm.
 * User: kvvn
 * Date: 6/15/16
 * Time: 3:33 PM
 */

namespace Kvvn\EcomSQLTools;


class Config {
    private $connection1 = [
        'host' => 'localhost',
        'db' => 'test1',
        'user' => 'user',
        'pass' => '*******',
        'type'=> 'main'
    ];
    private $connection2 = [
        'host' => 'localhost',
        'db' => 'test2',
        'user' => 'user',
        'pass' => '*******',
        'type'=> 'main'
    ];
    private $connection3 = [
        'host' => 'localhost',
        'db' => 'test3',
        'user' => 'user',
        'pass' => '*******',
        'type' => 'subservice'
    ];
    private $connection4 = [
        'host' => 'localhost',
        'db' => 'test4',
        'user' => 'user',
        'pass' => '*******',
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