<?php

namespace App\Filament\Admin\Resources\DataResource\Pages;

use App\Filament\Admin\Resources\DataResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListData extends ListRecords
{
    protected static string $resource = DataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
