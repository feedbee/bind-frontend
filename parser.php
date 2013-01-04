<?php

$data_structure_example = array(
	array(
		'type' => '$DIRECTIVE',
		'name' => 'TTL',
		'value' => '86400',
	),
	array(
		'class' => 'SOA',
		'ns_server' => '',
		'email' => '',
		'serial' => 2013010100,
		'refresh' => 10800,
		'retry' => 100000,
		'expiry' => 100000,
		'negative_ttl' => 86400,
	),
	array(
		'class' => 'NS',
		'host' => '@',
		'value' => 'ns1.commontools.net.',
	),
	array(
		'class' => 'MX',
		'host' => '@',
		'priority' => 10,
		'value' => 'example.com.',
	),
);

require_once __DIR__ . '/app/bootstrap.php';

$records = \Bind\ZoneFile\Reader\StandardReader::readStdin();
var_dump($records);

print $records;