<?php

namespace App\Filament\Resources\BlackPhoneResource\Pages;

use App\Filament\Resources\BlackPhoneResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBlackPhones extends ListRecords
{
    protected static string $resource = BlackPhoneResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
