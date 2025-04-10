<?php

namespace App\Filament\Admin\Resources\ClientResource\Pages;

use App\Filament\Admin\Resources\ClientResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\{
    Role,
    Permission
};
use Illuminate\Support\Carbon;
class CreateClient extends CreateRecord
{
    protected static string $resource = ClientResource::class;

    public function getTitle(): string
    {
        return 'Создать';
    }

    protected function afterCreate(): void
    {
       $this->record->main_user_id = Auth::id();
       $this->record->email_verified_at = Carbon::now();;

       $role = Role::find($this->data['role']);

       $this->record->assignRole($role['name']);

       $this->record->save();
    }
}
