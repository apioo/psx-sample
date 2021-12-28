<?php

namespace App\Tests;

use Doctrine\DBAL\Schema\Schema;

class TestSchema
{
    public static function getSchema(): Schema
    {
        $schema = new Schema();

        $table = $schema->createTable('population');
        $table->addColumn('id', 'integer', array('autoincrement' => true));
        $table->addColumn('place', 'integer');
        $table->addColumn('region', 'string');
        $table->addColumn('population', 'integer');
        $table->addColumn('users', 'integer');
        $table->addColumn('world_users', 'float');
        $table->addColumn('insert_date', 'datetime');
        $table->setPrimaryKey(array('id'));

        return $schema;
    }
}
