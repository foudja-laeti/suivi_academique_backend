<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KpiController;
Route::get('/', function () {
    return view('filiere');

});
Route::get('/metrics', function () {
    $metrics = [];

    // Temps de réponse simulé
    $metrics[] = '# HELP http_response_time_seconds Response time';
    $metrics[] = '# TYPE http_response_time_seconds gauge';
    $metrics[] = 'http_response_time_seconds '.round(microtime(true) - LARAVEL_START, 4);

    // Taux d'erreur
    $metrics[] = '# HELP http_errors_total Total HTTP errors';
    $metrics[] = '# TYPE http_errors_total counter';
    $metrics[] = 'http_errors_total 0';

    // Mémoire utilisée
    $metrics[] = '# HELP php_memory_usage_bytes Memory usage';
    $metrics[] = '# TYPE php_memory_usage_bytes gauge';
    $metrics[] = 'php_memory_usage_bytes '.memory_get_usage(true);

    return response(implode("\n", $metrics))
        ->header('Content-Type', 'text/plain; version=0.0.4');
});
Route::get('/app/{any?}', function () {
    return file_get_contents(public_path('frontend/index.html'));
})->where('any', '.*');

Route::get('/api/kpi', [KpiController::class, 'index']);
Route::get('/dashboard', function () {
    return view('dashboard');
});
