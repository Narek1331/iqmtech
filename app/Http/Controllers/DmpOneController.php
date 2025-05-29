<?php

namespace App\Http\Controllers;

use App\Http\Requests\DmpOneSyncRequest;
use App\Services\DataService;
use Illuminate\Http\JsonResponse;

/**
 * Class DmpOneController
 *
 * Handles synchronization of DMP-related tracking data.
 */
class DmpOneController extends Controller
{
    /**
     * @var DataService
     */
    private DataService $dataService;

    /**
     * DmpOneController constructor.
     *
     * @param DataService $dataService
     */
    public function __construct(DataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * Handles the incoming sync request, processes and stores the data.
     *
     * @param DmpOneSyncRequest $request
     * @return JsonResponse
     */
    public function sync(DmpOneSyncRequest $request): JsonResponse
    {
        $data = $this->extractData($request);

        $created = $this->dataService->sync($data);

        return response()->json([
            'status' => 'success',
        ]);
    }

    /**
     * Extracts and transforms request input to match the Data model structure.
     *
     * @param DmpOneSyncRequest $request
     * @return array<string, mixed>
     */
    private function extractData(DmpOneSyncRequest $request): array
    {
        $data = $request->only([
            'phone',
            'page',
            'referer',
            'ip',
            'utm_term',
            'utm_source',
            'utm_campaign',
            'utm_medium',
            'utm_content',
            'latitude',
            'longitude',
            'gender',
            'age',
            'city',
            'region',
            'country',
            'address',
            'comment',
            'status_id',
            'project_id',
            'user_id',
        ]);

        $data['ip_address'] = $data['ip'] ?? null;
        unset($data['ip']);

        $data['ref'] = $data['referer'] ?? null;
        unset($data['referer']);

        if ($request->filled('interests')) {
            $data['comment'] = json_encode($request->input('interests'));
        }

        return $data;
    }
}
