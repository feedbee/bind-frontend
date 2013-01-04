<?php

namespace Bind\ZoneFile\Record;

class Mx extends Record
{
	private $priority;
	private $destination;

	protected function updateRdata($rdata)
	{
		$rdata = preg_replace('/\s+/', ' ', $rdata);
		parent::updateRdata($rdata);

		$rdataArray = explode(' ', $rdata);

		if (count($rdataArray) != 2) {
			throw new RdataException("Invalid MX record format: `$rdata`");
		}

		$this->setPriority($rdataArray[0]);
		$this->setDestination($rdataArray[1]);
	}

	public function setPriority($priority)
	{
		$this->priority = $priority;
	}
	public function getPriority()
	{
		return $this->priority;
	}

	public function setDestination($destination)
	{
		$this->destination = $destination;
	}
	public function getDestination()
	{
		return $this->destination;
	}
}