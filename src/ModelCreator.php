<?php
/**
 * Created by PhpStorm.
 * User: kvvn
 * Date: 7/4/16
 * Time: 5:06 PM
 */

namespace Kvvn\SimpleMigrations;


class ModelCreator {

    private $SQL;
    private $sqlTypes2EVO = [
        'INT' => 'COLUMN_NUMERIC',
        'VARCHAR' => 'COLUMN_STRING',
        'BLOB' => 'COLUMN_BINARY',
        'DATETIME' => 'COLUMN_DATETIME',
        'LONGBLOB' => 'COLUMN_BINARY',
        'TINYINT' => 'COLUMN_NUMERIC',
    ];

    private $template = '<?php

class %1$s extends AbstractTable
{
    const tableName = \'%2$s\';
    public function __construct($connection = null)
	{
		parent::__construct($connection);
		%3$s
	}
}';

    private $fieldTemplate = '$this->addTableField(\'%1$s\', self::%2$s %3$s);';

    public function __construct($SQL)
    {
        $this->SQL = $SQL;
        echo $this->CreateModel();
    }

    public function CreateModel($SQL = null) {
        if(!$SQL) {
            $SQL = $this->SQL;
        }
        $sqlParser = new \SqlParser\Parser($SQL, true);
        $table_name = (string)$sqlParser->statements[0]->name->table;

        $fieldsString = '';

        //var_dump($sqlParser->statements[0]->fields);
        foreach($sqlParser->statements[0]->fields as $field) {
            $key_true = '';
            if(in_array('AUTO_INCREMENT', $field->options->options)) {
                $key_true = ', true' ;
            }


            $fieldsString .= sprintf(
                    $this->fieldTemplate,
                    $field->name,
                    $this->sqlTypes2EVO[$field->type->name],
                    $key_true
                ) . PHP_EOL;
        }

        $model = sprintf($this->template, $this->classNameFromTable($table_name), $table_name, $fieldsString);

        return $model;
    }

    private function classNameFromTable($table_name) {
        $nameParts = explode('_', $table_name);
        $prefix = array_map('ucfirst', $nameParts);
        return implode('', $prefix) . 'Table';
    }

}