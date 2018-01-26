<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 26.01.2018
 * Time: 14:06
 */

require_once('vendor/autoload.php');

$sql = $argv[1];
if (!empty($sql)) {
    try {
        new Kvvn\EcomSQLTools\ElasticSearchMappingFromDDL($sql, 'log');
    } catch (Exception $e) {
        echo 'Error in sql: ' . $e->getMessage();
    }
} else {
    echo 'No sql given';
}
