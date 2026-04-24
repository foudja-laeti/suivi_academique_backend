<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('filiere');

});
Route::get('/metrics', function () {
    $metrics = [];

    $metrics[] = '# HELP http_response_time_seconds Response time';
    $metrics[] = '# TYPE http_response_time_seconds gauge';
    $metrics[] = 'http_response_time_seconds ' . round(microtime(true) - LARAVEL_START, 4);

    $metrics[] = '# HELP http_errors_total Total HTTP errors';
    $metrics[] = '# TYPE http_errors_total counter';
    $metrics[] = 'http_errors_total 0';

    $metrics[] = '# HELP php_memory_usage_bytes Memory usage';
    $metrics[] = '# TYPE php_memory_usage_bytes gauge';
    $metrics[] = 'php_memory_usage_bytes ' . memory_get_usage(true);

    return response(implode("\n", $metrics), 200)
        ->header('Content-Type', 'text/plain; version=0.0.4; charset=utf-8');
});
