<?php

namespace App\Http\Controllers\Sync;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SyncDataRequest;
use App\Services\DataService;
use Illuminate\Http\JsonResponse;

class DataController extends Controller
{
    protected DataService $dataService;

    public function __construct(DataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * Синхронизация данных с внешним сервисом.
     *
     * @param SyncDataRequest $request
     * @return JsonResponse
     */
    public function sync(SyncDataRequest $request): JsonResponse
    {
        // Получение проверенных данных из запроса
        $data = $request->all();

        // Добавление IP-адреса в массив данных
        $data['ip_address'] = $request->ip();

        // Вызов сервиса для синхронизации данных
        $this->dataService->sync($data);

        // Возврат успешного ответа в соответствии с REST-принципами
        return response()->json([
            'message' => 'Данные успешно синхронизированы.',
        ], JsonResponse::HTTP_OK);
    }

    /**
     * Обработка ошибки синхронизации данных.
     *
     * @return JsonResponse
     */
    public function syncFailure(): JsonResponse
    {
        return response()->json([
            'message' => 'Не удалось синхронизировать данные. Пожалуйста, попробуйте снова.',
        ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
    }
}
