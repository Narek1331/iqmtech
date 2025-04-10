<?php

namespace App\Filament\Resources\BlackPhoneResource\Pages;

use App\Filament\Resources\BlackPhoneResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Traits\User\StoreHelper;

class CreateBlackPhone extends CreateRecord
{
    use StoreHelper;
    protected static string $resource = BlackPhoneResource::class;

    public function getTitle(): string
    {
        return 'Создать';
    }
}
