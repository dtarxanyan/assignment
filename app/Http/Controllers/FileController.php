<?php

namespace App\Http\Controllers;


use App\Jobs\CreateTasksFromJsonJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class FileController extends Controller
{
    public function store(Request $request)
    {
        try {
            $tasks = json_decode($request->getContent());

            if (!is_array($tasks)) {
                throw new UnprocessableEntityHttpException('Invalid json', config('errors.json_file_validation_error'));
            }

            $this->dispatch(new CreateTasksFromJsonJob($request->getContent()));

            return new JsonResponse(['success' => 1], 201);
        } catch (UnprocessableEntityHttpException $e) {
            return new JsonResponse([
                'success' => 0,
                'message' => 'Uploading Tasks Failed',
                'error_code' => $e->getCode(),
            ], $e->getStatusCode());
        } catch (\Throwable $e) {
            return new JsonResponse([
                'success' => 0,
                'message' => 'Uploading Tasks Failed',
                'error_code' => $e->getCode(),
            ], 500);
        }
    }
}
