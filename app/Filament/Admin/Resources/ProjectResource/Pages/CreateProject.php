<?php

namespace App\Filament\Admin\Resources\ProjectResource\Pages;

use App\Filament\Admin\Resources\ProjectResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProject extends CreateRecord
{
    protected static string $resource = ProjectResource::class;

    public function getTitle(): string
    {
        return 'Создать';
    }

      protected function mutateFormDataBeforeCreate(array $data): array
        {
            $data['created_by_admin'] = true;

            return $data;
        }
}
