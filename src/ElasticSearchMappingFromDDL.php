<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 26.01.2018
 * Time: 13:46
 */

namespace Kvvn\EcomSQLTools;

use SqlParser as SP;

class ElasticSearchMappingFromDDL
{
    private $sqlTypesElastic = [
        'INT' => 'long',
        'VARCHAR' => 'text',
        'BLOB' => 'text',
        'DATETIME' => 'date',
        'TINYINT' => 'double',
        'TIMESTAMP' => 'double',
        'TEXT' => 'text',
    ];

    private $typeName;

    public function __construct($SQL, $typeName)
    {
        $this->SQL = $SQL;
        $this->typeName = $typeName;

        echo $this->createModel();
    }

    public function createModel($SQL = null)
    {

        $properties = [];
        if (!$SQL) {
            $SQL = $this->SQL;
        }
        $sqlParser = new SP\Parser($SQL, true);

        foreach ($sqlParser->statements[0]->fields as $field) {
            if ($this->sqlTypesElastic[$field->type->name]) {
                switch ($this->sqlTypesElastic[$field->type->name]) {
                    case 'date':
                        $properties[(string)$field->name] = [
                            'type' => $this->sqlTypesElastic[$field->type->name],
                            'format' => 'yyyy-MM-dd HH:mm:ss||yyyy-MM-dd||epoch_millis'
                        ];
                        break;
                    default:
                        $properties[(string)$field->name] = [
                            'type' => $this->sqlTypesElastic[$field->type->name]];
                        break;
                }
            }
        }
        $mapping = ['mappings' => [$this->typeName => ['properties' => $properties]]];

        return json_encode($mapping);
    }
}