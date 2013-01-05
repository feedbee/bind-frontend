<?php

require_once '../bootstrap.php';

// Routing
$controller = 'zone-file';
if(isCli()) {
	$action = $argv[1];
} else {
	$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : null;
}
if (empty($action)) {
	$action = 'default';
}

$shortName = ucfirst(normalizeName($controller));
$controllerFileName = APP_ROOT . "/controllers/{$shortName}.php";
if (!file_exists($controllerFileName)) {
	show404();
}
require_once $controllerFileName;
$controllerClassName = "App\\Controller\\" . $shortName;
if (!class_exists($controllerClassName, false)) {print $controllerClassName;
	show404();
}
$controllerInstance = new $controllerClassName;

$actionMethod = normalizeName($action) . 'Action';
if (!method_exists($controllerInstance, $actionMethod)) {
	show404();
}

// Dispatch
$controllerInstance->$actionMethod();


function normalizeName($name)
{
	while (false !== ($pos = strpos($name, '-'))) {
		if (strlen($name) > $pos + 1) {
			$l = substr($name, $pos+1, 1);
			$l = strtoupper($l);
			$name = substr_replace($name, $l, $pos, 2);
		} else {
			$name = substr($name, 0, -1);
		}
	}

	return $name;
}

function show404()
{
	if(isCli()) {
		file_put_contents('php://stderr', "Requested action not found");
		exit(1);
	} else {
		$protocol = $_SERVER['SERVER_PROTOCOL'];
		header("$protocol 404 Not Found");
	}

	exit;
}

function isCli()
{
	return php_sapi_name() == 'cli';
}