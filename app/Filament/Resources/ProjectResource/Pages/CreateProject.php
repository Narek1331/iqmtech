<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\ProjectResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Traits\User\StoreHelper;

class CreateProject extends CreateRecord
{
    use StoreHelper;
    protected static string $resource = ProjectResource::class;

    public function getTitle(): string
    {
        return 'Создать';
    }

}
