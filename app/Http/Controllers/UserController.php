<?php

namespace App\Http\Controllers;

use App\Features\GetFacebookUserFeature;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends Controller
{
    public function show($identifier)
    {
        try {
            $id = $identifier;

            if ($identifier == 'me') {
                $id = Auth::id();
            }

            $feature = new GetFacebookUserFeature();
            $user = $feature->run((int)$id);

            return new JsonResponse([
                'success' => 1,
                'data' => $user->asArray(),
            ]);
        } catch (NotFoundHttpException $e) {
            Log::error($e);

            return new JsonResponse([
                'success' => 0,
                'message' => 'User not found',
                'error_code' => config('errors.user_not_found'),
            ], $e->getStatusCode());
        } catch (\Throwable $e) {
            Log::error($e);

            return new JsonResponse([
                'success' => 0,
                'message' => 'Server Error',
                'error_code' => config('errors.server_error'),
            ], 500);
        }
    }
}
