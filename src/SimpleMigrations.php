<?php
/**
 * Created by PhpStorm.
 * User: kvvn
 * Date: 6/15/16
 * Time: 3:21 PM
 */
namespace Kvvn\SimpleMigrations;

use SebastianBergmann\Exporter\Exception;

class SimpleMigrations {

    const directory = 'src/sqls';

    public function __construct()
    {
        $queries = [];

        $config  = new Config();
        $connections = $config->getConnections();

        $file_names = $this->getSQLFileNames();
        foreach ($file_names as $file_name) {
            $queries[] = $this->getQueries($file_name);
        }
        $queries = call_user_func('array_merge', $queries);
        foreach($queries[0] as $k => $query) {
            if(!$this->validateQueries($query)) {
                die('Error in query: ' . $query);
            }
        }


        foreach($connections as $connection) {
            $dsn = sprintf('mysql:dbname=%s;host=%s', $connection['db'], $connection['host']);
            $pdo = new \PDO($dsn, $connection['user'], $connection['pass']);
            foreach($queries[0] as $k => $query) {
                if (!empty($query)) {
                    $pdo->exec($query);
                    if (!empty((int)$pdo->errorInfo()[0])) {

                        print_r($pdo->errorInfo());
                    }
                }
            }
        }
    }

    /**
     * @return array
     */
    private function getSQLFileNames()
    {
        $files = $scanned_directory = array_diff(scandir(self::directory), array('..', '.'));
        return $files;
    }

    /**
     * @param $file_name
     * @return array
     */
    private function getQueries($file_name)
    {
        $data = file_get_contents(self::directory . '/' . $file_name);
        $queries = explode(';', $data);
        return $queries;
    }

    private function validateQueries($query)
    {
        $result = false;
        try{
            $sqlParser = new \SqlParser\Parser($query);
            $result = true;
        } catch (Exception $e) {
            var_dump($e);
        }


        return $result;
    }
}