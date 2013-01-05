<?php

namespace App\Controller;

class ZoneFile
{
	public function defaultAction()
	{
		$view = new \Utils\View;

		$zone = 'example.com';

		$dir = \Utils\Config::get('zone_files_dir');
		$h = fopen("$dir/db.$zone", 'r');
		$records = \Bind\ZoneFile\Reader\StandardReader::read($h);
		fclose($h);

		$view->records = $records;

		$body = $view->render(APP_ROOT . '/templates/zone-file.phtml');

		$view->title = 'Zone File';
		$view->body = $body;
		echo $view->render(APP_ROOT . '/templates/layout.phtml');
	}
}