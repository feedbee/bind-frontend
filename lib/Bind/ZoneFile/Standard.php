<?php

namespace Bind\ZoneFile;

class Standard
{
	private $ttl;
	private $soa;
	private $records;

	function __construct($ttl = null, $soa = null, array $records = array())
	{
		$this->ttl = $ttl;
		$this->soa = $soa;
		$this->records = $records;
	}

	public function setTtl($ttl)
	{
		$this->ttl = $ttl;
	}
	public function getTtl()
	{
		return $this->ttl;
	}

	public function setSoa($soa)
	{
		$this->soa = $soa;
	}
	public function getSoa()
	{
		return $this->soa;
	}

	public function setRecords(array $records)
	{
		$this->records = array();
		foreach ($records as $record) {
			$this->addRecord($record);
		}
	}
	public function getRecords()
	{
		return $this->records;
	}

	public function hasRecord(\Bind\ZoneFile\Record\Record $record)
	{
		foreach ($this->records as $index => $internalRecord) {
			if ($record === $internalRecord) {
				return true;
			}
		}

		return false;
	}
	public function addRecord(\Bind\ZoneFile\Record\Record $record)
	{
		$this->records[] = $record;
	}
	public function removeRecord($record)
	{
		foreach ($this->records as $index => $internalRecord) {
			if ($record === $internalRecord) {
				unset($this->records[$internalRecord]);
				$this->records = array_values($this->records);
				break;
			}
		}
	}
}