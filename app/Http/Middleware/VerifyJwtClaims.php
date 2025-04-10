<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Services\SyncService;
class VerifyJwtClaims
{
    public $syncService;

    public function __construct(SyncService $syncService)
    {
        $this->syncService = $syncService;
    }
    public function handle($request, Closure $next)
    {

        try {

            $payload = JWTAuth::parseToken()->getPayload();

            $request['project_id'] = $payload->get('project_id');
            $request['user_id'] = $payload->get('user_id');

            if (!$this->syncService->check($request->all())) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }



        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
