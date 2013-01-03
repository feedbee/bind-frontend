<?php

namespace Bind\ZoneFile\Record;

class Soa extends Record
{
	private $zone;
	private $admin;
	private $serial;
	private $refresh;
	private $retry;
	private $expiry;
	private $minTtl;

	protected function parseRdata()
	{
		$rdata = preg_replace('/\s+/', ' ', $this->getRdata());
		$this->setRdata($rdata);

		$rdataArray = explode(' ', $rdata);

		if (count($rdataArray) != 7) {
			throw new RdataException("Invalid SOA record format: `$rdata`");
		}

		$this->setZone($rdataArray[0]);
		$this->setAdmin($rdataArray[1]);
		$this->setSerial($rdataArray[2]);
		$this->setRefresh($rdataArray[3]);
		$this->setRetry($rdataArray[4]);
		$this->setExpiry($rdataArray[5]);
		$this->setMinTtl($rdataArray[6]);
	}

	public function setZone($zone)
	{
		$this->zone = $zone;
	}
	public function getZone()
	{
		return $this->zone;
	}

	public function setAdmin($admin)
	{
		$this->admin = $admin;
	}
	public function getAdmin()
	{
		return $this->admin;
	}

	public function setSerial($serial)
	{
		$this->serial = $serial;
	}
	public function getSerial()
	{
		return $this->serial;
	}

	public function setRefresh($refresh)
	{
		$this->refresh = $refresh;
	}
	public function getRefresh()
	{
		return $this->refresh;
	}

	public function setRetry($retry)
	{
		$this->retry = $retry;
	}
	public function getRetry()
	{
		return $this->retry;
	}

	public function setExpiry($expiry)
	{
		$this->expiry = $expiry;
	}
	public function getExpiry()
	{
		return $this->expiry;
	}

	public function setMinTtl($minTtl)
	{
		$this->minTtl = $minTtl;
	}
	public function getMinTtl()
	{
		return $this->minTtl;
	}
}