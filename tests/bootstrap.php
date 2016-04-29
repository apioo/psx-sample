<?php

$loader = require(__DIR__ . '/../vendor/autoload.php');
$loader->add('Sample', 'tests');

\PSX\Framework\Test\Environment::setup(__DIR__ . '/..', function ($fromSchema) {

    return Sample\TestSchema::getSchema();

});
