<?php

namespace App\Filament\Resources\DataResource\Pages;

use App\Filament\Resources\DataResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewData extends ViewRecord
{
    protected static string $resource = DataResource::class;

    public function getTitle(): string
    {
        return '';
    }

}
