<?php

namespace App\Controller;

class ZoneFile
{
	public function defaultAction()
	{
		$view = new \Utils\View;

		$h = fopen(APP_ROOT . '/../tests/db.xxx', 'r');
		$records = \Bind\ZoneFile\Reader\StandardReader::read($h);
		fclose($h);

		$view->records = $records;

		$body = $view->render(APP_ROOT . '/templates/zone-file.phtml');

		$view->title = 'Zone File';
		$view->body = $body;
		echo $view->render(APP_ROOT . '/templates/layout.phtml');
	}
}