<?php

namespace Bind\ZoneFile\Record;

class Record
{
	private $domain;
	private $type;
	private $ttl;
	private $class;
	private $rdata;

	public function __construct($domain, $type, $ttl, $class, $rdata)
	{
		$this->setDomain($domain);
		$this->setType($type);
		$this->setTtl($ttl);
		$this->setClass($class);
		$this->setRdata($rdata);

		$this->parseRdata();
	}

	public function setDomain($domain)
	{
		$this->domain = $domain;
	}
	public function getDomain()
	{
		return $this->domain;
	}

	public function setType($type)
	{
		$this->type = $type;
	}
	public function getType()
	{
		return $this->type;
	}

	public function setTtl($ttl)
	{
		$this->ttl = $ttl;
	}
	public function getTtl()
	{
		return $this->ttl;
	}

	public function setClass($class)
	{
		$this->class = $class;
	}
	public function getClass()
	{
		return $this->class;
	}

	public function setRdata($rdata)
	{
		$this->rdata = $rdata;
	}
	public function getRdata()
	{
		return $this->rdata;
	}

	protected function parseRdata() {}

	public static function factory($record)
	{
		$class = $record['class'];
		$className = '\\Bind\\ZoneFile\\Record\\' . ucfirst(strtolower($class));

		if (class_exists($className)) {
			return new $className($record['domain'], $record['type'], $record['ttl'], $record['class'], $record['rdata']);
		} else {
			return new Record($record['domain'], $record['type'], $record['ttl'], $record['class'], $record['rdata']);
		}
	}
}