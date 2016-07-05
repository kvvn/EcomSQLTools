<?php
/**
 * Created by PhpStorm.
 * User: kvvn
 * Date: 6/15/16
 * Time: 3:21 PM
 */
namespace Kvvn\EcomSQLTools;


class SimpleMigrations {

    const directory = 'src/sqls';

    public function __construct()
    {
        Logger::info('Init Job');
        $queries = [];

        $config  = new Config();
        $connections = $config->getConnections();

        $file_names = $this->getSQLFileNames();
        foreach ($file_names as $file_name) {
            $queries[] = $this->getQueries($file_name);
        }
        $queries = call_user_func('array_merge', $queries);
        foreach($queries[0] as $k => $query) {
            $query = trim($query);
            if(!$this->validateQueries($query)) {
                Logger::error('Error in query: ' . $query);
                die();
            }
        }
        foreach($connections as $connection) {
            $error = 0;
            $dsn = sprintf('mysql:dbname=%s;host=%s', $connection['db'], $connection['host']);
            $pdo = new \PDO($dsn, $connection['user'], $connection['pass']);
            $pdo->beginTransaction();
            foreach($queries[0] as $k => $query) {
                if (!empty($query)) {
                    $pdo->exec($query);
                    if (!empty((int)$pdo->errorInfo()[0])) {
                        Logger::error($pdo->errorInfo());
                        $error = 1;
                    }
                }
            }
            if($error == 1) {
                $pdo->rollBack();
            }else {
                $pdo->commit();
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
            $sqlParser = new \SqlParser\Parser($query, true);
            $result = true;

        } catch (\SqlParser\Exceptions\ParserException $e) {
            Logger::error($e->getMessage());
        }


        return $result;
    }
}


/**
 *  Query for schema compare
 *
 *  SELECT col.TABLE_NAME, col.COLUMN_TYPE, col.CHARACTER_MAXIMUM_LENGTH, col.EXTRA
 *  FROM information_schema.COLUMNS col
 *  WHERE col.TABLE_SCHEMA = 'exite_ru'
 *  ORDER BY col.TABLE_NAME, col.ORDINAL_POSITION;
 *
 **/