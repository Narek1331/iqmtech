<?php

namespace App\Filament\Admin\Resources\ClientResource\Pages;

use App\Filament\Admin\Resources\ClientResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Spatie\Permission\Models\{
    Role,
    Permission
};
class EditClient extends EditRecord
{
    protected static string $resource = ClientResource::class;

    public function getTitle(): string
    {
        return 'Редактирование';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
            ->modalHeading('Удалить'),
        ];
    }

    protected function afterSave(): void
    {

       $role = Role::find($this->data['role']);

       $this->record->syncRoles([]);

       $this->record->assignRole($role['name']);

       $this->record->save();
    }
}
