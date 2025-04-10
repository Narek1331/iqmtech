<?php

namespace App\Services;

use App\Services\{
    MobileOperatorService,
    GeolocationService
};
use App\Repositories\DataRepository;

class DataService
{
    private MobileOperatorService $mobileOperatorService;
    private GeolocationService $geolocationService;
    private DataRepository $dataRepository;

    public function __construct(
        MobileOperatorService $mobileOperatorService,
        GeolocationService $geolocationService,
        DataRepository $dataRepository
    ) {
        $this->mobileOperatorService = $mobileOperatorService;
        $this->geolocationService = $geolocationService;
        $this->dataRepository = $dataRepository;
    }

    public function sync(array $data)
    {
        $data = $this->handleGeolocation($data);
        $data = $this->handleMobileOperator($data);

        return $this->dataRepository->store($data);
    }

    private function handleGeolocation(array $data): array
    {
        if (empty($data['latitude']) || empty($data['longitude'])) {
            return $data;
        }

        $geolocationData = $this->geolocationService->getLocation($data['latitude'], $data['longitude']);
        if (!$geolocationData) {
            return $data;
        }

        $geolocationFields = ['city', 'region', 'country', 'address'];
        foreach ($geolocationFields as $field) {
            if (!empty($geolocationData[$field])) {
                $data[$field] = $geolocationData[$field];
            }
        }

        return $data;
    }

    private function handleMobileOperator(array $data): array
    {
        if (empty($data['ip_address'])) {
            return $data;
        }

        $mobileOperatorData = $this->mobileOperatorService->getOperator($data['ip_address']);
        if (!empty($mobileOperatorData['isp'])) {
            $data['mobile_operator'] = $mobileOperatorData['isp'];
        }

        return $data;
    }
}
