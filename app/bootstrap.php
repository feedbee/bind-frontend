<?php

define('APP_ROOT', __DIR__);
define('APP_LIB_ROOT', realpath(__DIR__ . '/../lib'));
define('APP_VENDOR_ROOT', realpath(__DIR__ . '/../vendor'));

require_once APP_VENDOR_ROOT . '/symfony/class-loader/Symfony/Component/ClassLoader/UniversalClassLoader.php';

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
	'Bind' => APP_LIB_ROOT . '/../lib',
	'Utils' => APP_LIB_ROOT . '/../lib',
));
$loader->register();