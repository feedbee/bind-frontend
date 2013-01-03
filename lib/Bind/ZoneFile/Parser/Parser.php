<?php

namespace Bind\ZoneFile\Parser;

class Parser
{
	private function __construct() {}

	public static function parseStdin()
	{
		$handler = fopen('php://stdin', 'r');
		$records = self::parse($handler);
		fclose($handler);

		return $records;
	}

	public static function parse($handler)
	{
		$records = array();

		while (!feof($handler)) {
			$line = fgets($handler);

			$line = self::cleanup_line($line);
			if (strlen($line) < 1) { // skip empty lines
				continue;
			}

			// directives
			$first_char = substr($line, 0, 1);
			if ($first_char == '$') {
				list($directive, $value) = self::extract_directive($line);
				$records[] = array('type' => '$DIRECTIVE', 'name' => $directive, 'value' => $value);
				continue;
			}

			// multi-line
			// @TODO: brackets inside quotes (in TXT records) will break parsing
			$openBracketsCount = substr_count($line, '(');
			$closeBracketsCount = substr_count($line, ')');
			if ($openBracketsCount < $closeBracketsCount) {
				throw new Exception('Brackets are not balanced');
			}
			while ($openBracketsCount > $closeBracketsCount && !feof($handler)) {
				$next_line = fgets($handler);
				$next_line = self::cleanup_line($next_line);
				if (strlen($line) < 1) { // skip empty lines
					continue;
				}
				$line .= " $next_line";

				$openBracketsCount = substr_count($line, '(');
				$closeBracketsCount = substr_count($line, ')');
			}
			if ($openBracketsCount != $closeBracketsCount) {
				throw new Exception('Brackets are not balanced');
			}

			$line = str_replace(array('(', ')'), ' ', $line);

			// parse record
			list($domain, $type, $ttl, $class, $rdata) = self::extract_record($line);
			$records[] = array('domain' => $domain, 'type' => $type, 'ttl' => $ttl, 'class' => $class, 'rdata' => $rdata);
		}

		return $records;
	}

	private static function cleanup_line($line)
	{
		$line = preg_replace('/(;|#).*$/', '', $line); //remove comments
		$line = rtrim($line); // spece at right
		return $line;
	}

	private static function extract_directive($line)
	{
		$r = preg_match('/^\$(\w*)\s(.*)$/', $line, $matches);
		if ($r) {
			return array($matches[1], $matches[2]);
		}
		throw new Exception('Directive parsing failed');
	}

	private static function extract_record($line)
	{
		$r = preg_match('/^([^\s]*\s+|\s+)((IN|CN|HS)\s+)?(([\dhdwmy]+)\s+)?(A|AAAA|A6|AFSDB|APL|CERT|CNAME|DNAME|GPOS|HINFO|ISDN|KEY|KX|LOC|MX|NAPTR|NSAP|NS|NXT|PTR|PX|RP|RT|SIG|SOA|SRV|TXT|WKS|X25)\s+(.*)$/i',
			$line, $matches);

		if (!$r) {
			throw new Exception("Failed to parse record `$line`");
		}

		$domain = trim($matches[1]);
		if ($domain === '') {
			$domain = ' ';
		}
		$type = $matches[3] !== '' ? $matches[3] : null;
		$ttl = $matches[5] !== '' ? $matches[5] : null;
		$class = $matches[6];
		$rdata = trim($matches[7]);

		return array($domain, $type, $ttl, $class, $rdata);
	}
}