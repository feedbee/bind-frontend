<?php

namespace Bind\ZoneFile\Reader;

class Reader
{
	public static function readStdin()
	{
		$records = \Bind\ZoneFile\Parser\Parser::parseStdin();
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
}