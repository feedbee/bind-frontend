<?php

namespace Utils;

class Config
{
	public static $config;

	public static function get($name)
	{
		if (isset(self::$config[$name])) {
			return self::$config[$name];
		}

		return null;
	}
}