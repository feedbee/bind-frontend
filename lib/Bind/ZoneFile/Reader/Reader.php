<?php

namespace Bind\ZoneFile\Reader;

class Reader
{
	public static function readStdin()
	{
		$records = \Bind\ZoneFile\Parser\Parser::parseStdin();
		return self::process($records);
	}

	private function process($records)
	{
		$recordsNormalized = \Bind\ZoneFile\Normalizer\Normalizer::normalize($records);

		$objects = array();
		foreach ($recordsNormalized as $record) {
			if ($record['type'] == '$DIRECTIVE') {
				$objects[] = new \Bind\ZoneFile\Directive($record['name'], $record['value']);
			} else {
				$objects[] = \Bind\ZoneFile\Record\Record::factory($record);
			}
		}

		return $objects;
	}

	public static function read($handler)
	{
		$records = \Bind\ZoneFile\Parser\Parser::parse($handler);
		return self::process($records);
	}
}