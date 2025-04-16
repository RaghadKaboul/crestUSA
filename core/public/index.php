<?php
use Illuminate\Http\Request;


define('LARAVEL_START', microtime(true));

// Autoload Composer dependencies
require __DIR__.'/../vendor/autoload.php';

// Load the application
$app = require_once __DIR__.'/../bootstrap/app.php';

// Handle the incoming request
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);

