<?php

namespace App\Filament\Resources\BlackPhoneResource\Pages;

use App\Filament\Resources\BlackPhoneResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBlackPhone extends EditRecord
{
    protected static string $resource = BlackPhoneResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
            ->modalHeading('Удалить'),
        ];
    }

    public function getTitle(): string
    {
        return 'Редактирование';
    }
}
