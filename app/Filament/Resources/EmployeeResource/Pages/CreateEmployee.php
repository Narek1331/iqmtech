<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateEmployee extends CreateRecord
{
    protected static string $resource = EmployeeResource::class;

    public function getTitle(): string
    {
        return 'Создать';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['main_user_id'] = Auth::id();
        $data['email_verified_at'] = now();

        return $data;
    }


}
