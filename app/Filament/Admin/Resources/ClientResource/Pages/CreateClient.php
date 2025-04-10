<?php

namespace App\Filament\Admin\Resources\ClientResource\Pages;

use App\Filament\Admin\Resources\ClientResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateClient extends CreateRecord
{
    protected static string $resource = ClientResource::class;

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
