<?php

namespace App\Http\Controllers;


use App\Features\ListTasksFeature;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class TaskController
{
    public function index()
    {
        try {
            $feature = new ListTasksFeature();
            $tasks = $feature->run();

            return new JsonResponse([
                'success' => 1,
                'data' => $tasks,
            ]);
        } catch (\Throwable $e) {
            Log::error($e);

            return new JsonResponse([
                'success' => 0,
                'error_code' => $e->getCode(),
            ]);
        }
    }
}
