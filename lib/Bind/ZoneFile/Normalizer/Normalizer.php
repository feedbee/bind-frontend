<?php

namespace Bind\ZoneFile\Normalizer;

class Normalizer
{
	private function __construct() {}

	public static function normalize($records)
	{
		$lastGlobalTtl = $lastType = $lastDomain = null;
		$soaMet = false;
		foreach ($records as &$record) {
			if ($record['type'] == '$DIRECTIVE') {
				$record['name'] = strtoupper($record['name']);
				if ($record['name'] == 'TTL') {
					$lastGlobalTtl = $record['value'];
				}
			}
			else
			{
				$record['class'] = strtoupper($record['class']);

				if (!isset($record['type'])) {
					if (empty($lastType)) {
						throw new Exception('Record type undefined in first file record');
					}
					$record['type'] = $lastType;
				} else {
					$lastType = $record['type'];
				}
				$record['type'] = strtoupper($record['type']);

				if ($record['domain'] == ' ') {
					if (empty($lastDomain)) {
						throw new Exception('Record domain undefined in first file record');
					}
					$record['domain'] = $lastDomain;
				} else {
					$lastDomain = $record['domain'];
				}

				if (!isset($record['ttl'])) {
					if ($record['class'] != 'SOA') {
						if (empty($lastGlobalTtl) && !$soaMet) {
							throw new Exception('Record TTL undefined while global TTL is not set too');
						}
						$record['ttl'] = $lastGlobalTtl;
					}
				}

				if ($record['class'] == 'SOA') {
					$soaMet = true;
				}
			}
		}

		return $records;
	}
}