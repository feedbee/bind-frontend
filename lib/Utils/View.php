<?php

namespace Utils;

class View
{
	public function __set($name, $value)
	{
		$this->$name = $value;
	}

	public function __get($name)
	{
		if (isset($this->$name)) {
			return $this->$name;
		}

		return null;
	}

	public function render($template)
	{
		ob_start();
		require_once $template;
		$contents = ob_get_clean();

		return $contents;
	}
}