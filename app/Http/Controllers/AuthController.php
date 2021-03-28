<?php

namespace App\Http\Controllers;


use App\Features\GetAccessWithFacebookTokenFeature;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function loginWithFacebook(Request $request)
    {
        try {
            $feature = new GetAccessWithFacebookTokenFeature();
            $personalAccessToken = $feature->run($request->get('facebookToken'));
            return new JsonResponse([
                'success' => 1,
                'data' => $personalAccessToken->accessToken
            ]);
        } catch (\Throwable $e) {
            Log::error($e);

            return new JsonResponse([
                'success' => 0,
            ], 401);
        }
    }
}
