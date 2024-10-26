<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Strategy;
use Illuminate\Http\Request;
use App\Services\GooglePageSpeedService;

class MetricController extends Controller
{
    protected $pageSpeedService;

    public function __construct(GooglePageSpeedService $pageSpeedService)
    {
        $this->pageSpeedService = $pageSpeedService;
    }

    public function index()
    {
        $categories = Category::all();
        $strategies = Strategy::all();

        return view('metrics.index', compact('categories', 'strategies'));
    }

    public function run(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
            'categories' => 'required|array',
            'strategy' => 'required|string|in:mobile,desktop',
        ]);

        try {
            // Usar el servicio para obtener las métricas
            $metrics = $this->pageSpeedService->getMetrics(
                $request->input('url'),
                $request->input('categories'),
                $request->input('strategy')
            );

            // Renderiza los datos en una vista parcial
            return response()->json([
                'html' => view('metrics.partials.results', ['metrics' => $metrics])->render()
            ]);
        } catch (\Exception $e) {
                    // Registrar el error en el log de Laravel
            \Log::error('Error fetching metrics: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}