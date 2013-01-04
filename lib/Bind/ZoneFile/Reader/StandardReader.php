<?php

namespace Bind\ZoneFile\Reader;

class StandardReader extends Reader
{
	public static function readStdin()
	{
		$records = parent::readStdin();
		return self::process($records);
	}

	private function process($records)
	{
		$zoneFile = new \Bind\ZoneFile\Standard;
		foreach ($records as $record) {
			if ($record instanceof \Bind\ZoneFile\Directive && $record->getName() == 'TTL') {
				$zoneFile->setTtl($record->getValue());
			} elseif ($record instanceof \Bind\ZoneFile\Record\Soa) {
				$zoneFile->setSoa($record);
			} else {
				$zoneFile->addRecord($record);
			}
		}

		return $zoneFile;
	}

	public static function read($handler)
	{
		$records =  parent::read($handler);
		return self::process($records);
	}
}