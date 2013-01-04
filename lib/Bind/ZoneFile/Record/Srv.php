<?php

namespace Bind\ZoneFile\Record;

class Srv extends Record
{
	private $priority;
	private $weight;
	private $port;
	private $target;

	protected function updateRdata($rdata)
	{
		$rdata = preg_replace('/\s+/', ' ', $rdata);

		$rdataArray = explode(' ', $rdata);

		if (count($rdataArray) != 4) {
			throw new RdataException("Invalid SRV record format: `$rdata`");
		}

		$this->setPriority($rdataArray[0]);
		$this->setWeight($rdataArray[1]);
		$this->setPort($rdataArray[2]);
		$this->setTarget($rdataArray[3]);
	}
	public function getRdata()
	{
		return "{$this->getPriority()} {$this->getWeight()} {$this->getPort()} {$this->getTarget()}";
	}

	public function setPriority($priority)
	{
		$this->priority = $priority;
	}
	public function getPriority()
	{
		return $this->priority;
	}

	public function setWeight($weight)
	{
		$this->weight = $weight;
	}
	public function getWeight()
	{
		return $this->weight;
	}

	public function setPort($port)
	{
		$this->port = $port;
	}
	public function getPort()
	{
		return $this->port;
	}

	public function setTarget($target)
	{
		$this->target = $target;
	}
	public function getTarget()
	{
		return $this->target;
	}
}