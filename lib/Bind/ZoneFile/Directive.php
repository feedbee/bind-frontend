<?php

namespace Bind\ZoneFile;

class Directive
{
	private $name;
	private $value;

	private $template = "$%s\t%s";

	public function __construct($name, $value)
	{
		$this->name = $name;
		$this->value = $value;
	}

	public function setName($name)
	{
		$this->name = $name;
	}
	public function getName()
	{
		return $this->name;
	}

	public function setValue($value)
	{
		$this->value = $value;
	}
	public function getValue()
	{
		return $this->value;
	}

	public function __toString()
	{
		return sprintf($this->getTemplate(), $this->getName(), $this->getValue());
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