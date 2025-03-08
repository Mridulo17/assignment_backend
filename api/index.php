<?php

// Update the paths in index.php to reflect the new location
require __DIR__.'/../vendor/autoload.php';  // Adjust the path to autoload.php
$app = require_once __DIR__.'/../bootstrap/app.php'; // Adjust the path to app.php

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);  

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
