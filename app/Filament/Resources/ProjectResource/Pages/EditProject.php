<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\ProjectResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProject extends EditRecord
{
    protected static string $resource = ProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
            ->modalHeading('Удалить'),
        ];
    }

    public function getTitle(): string
    {
        $displayLocationName = $this->record->name ?? '';

        return $displayLocationName ? 'Редактирование ' . $displayLocationName : 'Редактирование';
    }

}
