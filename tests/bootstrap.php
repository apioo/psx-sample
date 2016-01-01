<?php

$loader = require(__DIR__ . '/../vendor/autoload.php');
$loader->add('Sample', 'tests');

PSX\Test\Environment::setup(__DIR__ . '/..', function ($fromSchema) {

    return Sample\TestSchema::getSchema();

});
