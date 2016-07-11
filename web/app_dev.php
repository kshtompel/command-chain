<?php

umask(0000);

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Debug;

include_once __DIR__ . '/../app/autoload.php';

// Initialize kernel and run the application.
$kernel = new AppKernel('dev', true);
$kernel->loadClassCache();

Debug::enable();

$request = Request::createFromGlobals();

$response = $kernel->handle($request);
$response->send();

$kernel->terminate($request, $response);