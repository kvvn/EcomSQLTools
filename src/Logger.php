<?php
/**
 * Created by PhpStorm.
 * User: kvvn
 * Date: 6/24/16
 * Time: 10:18 AM
 */

namespace Kvvn\EcomSQLTools;


class Logger {
    public static function info($message) {
        $color = 32;
        $default = 39;
        echo "\033[{$color}m [" . date('Y-m-d h:i:s'). '] INFO: ' . print_r($message, true) . " \033[{$default}m" . PHP_EOL;
    }

    public static function error($message) {
        $color = 31;
        $default = 39;
        echo "\033[{$color}m [" . date('Y-m-d h:i:s'). '] Error: ' . print_r($message, true) . " \033[{$default}m" . PHP_EOL;
    }
}