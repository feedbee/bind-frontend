<?php

namespace Bind\ZoneFile;

class Standard
{
	/**
	 * @var \Bind\ZoneFile\Directive
	 */
	private $ttl;
	/**
	 * @var \Bind\ZoneFile\Record\Soa
	 */
	private $soa;
	/**
	 * @var \Bind\ZoneFile\Record\Record[]
	 */
	private $records;

	private $template = "%s\n%s\n\n%s\n";

	function __construct($ttl = null, $soa = null, array $records = array())
	{
		$this->ttl = $ttl;
		$this->soa = $soa;
		$this->records = $records;
	}

	public function setTtl(\Bind\ZoneFile\Directive $ttl)
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
				unset($this->records[$index]);
				$this->records = array_values($this->records);
				break;
			}
		}
	}

	public function __toString()
	{
		return sprintf($this->getTemplate(), $this->getTtl(), $this->getSoa(), implode("\n", $this->getRecords()));
	}

	public function setTemplate($template)
	{
		$this->template = $template;
	}
	public function getTemplate()
	{
		return $this->template;
	}
}