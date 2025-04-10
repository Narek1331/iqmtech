<?php

namespace App\Filament\Admin\Resources\DataResource\Pages;

use App\Filament\Admin\Resources\DataResource;
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
