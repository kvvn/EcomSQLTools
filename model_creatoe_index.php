<?php
/**
 * Created by PhpStorm.
 * User: kvvn
 * Date: 7/4/16
 * Time: 5:24 PM
 */

require_once('vendor/autoload.php');

$sql = $argv[1];
if(!empty($sql)){
    try{
        new Kvvn\SimpleMigrations\ModelCreator($sql);
    } catch (Exception $e) {
        echo 'Error in sql: ' . $e->getMessage();
    }
} else {
    echo 'No sql given';
}