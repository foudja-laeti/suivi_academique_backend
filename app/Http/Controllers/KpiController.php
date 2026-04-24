<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class KpiController extends Controller
{
    public function index()
    {
        return response()->json([
            'timestamp' => now()->toIso8601String(),
            'kpis' => [
                'filieres'       => DB::table('filieres')->count(),
                'niveaux'        => DB::table('niveaux')->count(),
                'ues'            => DB::table('ues')->count(),
                'ecs'            => DB::table('ecs')->count(),
                'personnels'     => DB::table('personnels')->count(),
                'salles'         => DB::table('salles')->count(),
                'programmations' => DB::table('programmations')->count(),
            ],
            'system' => [
                'memory_usage_mb' => round(memory_get_usage(true) / 1024 / 1024, 2),
                'php_version'     => PHP_VERSION,
                'laravel_version' => app()->version(),
                'environment'     => app()->environment(),
                'uptime'          => round(microtime(true) - LARAVEL_START, 4),
            ],
        ]);
    }
}
