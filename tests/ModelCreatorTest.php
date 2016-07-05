<?php
/**
 * Created by PhpStorm.
 * User: kvvn
 * Date: 7/5/16
 * Time: 11:22 AM
 */

class ModelCreatorTest extends PHPUnit_Framework_TestCase {
    private $res = '<?php

class TestTable extends AbstractTable
{
    const tableName = \'test\';
    public function __construct($connection = null)
	{
		parent::__construct($connection);
		$this->addTableField(\'id\', self::COLUMN_NUMERIC , true);
$this->addTableField(\'var\', self::COLUMN_STRING );

	}
}';

    public function testCreateModel()
    {
        $testClass = new Kvvn\SimpleMigrations\ModelCreator("CREATE TABLE exite_ru.test (     id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,     var VARCHAR(10) NOT NULL );");
        $this->assertEquals($this->res, $testClass->CreateModel());
    }
}
