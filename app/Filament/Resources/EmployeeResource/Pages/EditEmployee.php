<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmployee extends EditRecord
{
    protected static string $resource = EmployeeResource::class;

    public function getTitle(): string
    {
        $displayLocationName = $this->record->name ?? '';

        return $displayLocationName ? 'Редактирование ' . $displayLocationName : 'Редактирование';
    }

}
