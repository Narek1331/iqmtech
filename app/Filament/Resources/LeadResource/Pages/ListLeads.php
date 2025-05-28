<?php

namespace App\Filament\Resources\LeadResource\Pages;

use App\Filament\Resources\LeadResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms;
use App\Models\Status;
class ListLeads extends ListRecords
{
    protected static string $resource = LeadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('createStatus')
                ->label('Создать новый статус')
                ->modalHeading('Создать новый статус')
                ->modalSubmitActionLabel('Сохранить')
                ->form([
                    Forms\Components\TextInput::make('name')
                        ->label('Название')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Select::make('color')
                        ->label('Цвет')
                        ->default('gray')
                        ->options([
                            'success' => '🟢',
                            'primary' => '🔵',
                            'warning' => '🟡',
                            'danger'  => '🔴',
                            'gray'    => '⚪️',
                        ])
                ])
                ->action(function (array $data): void {
                    Status::create($data);
                }),
        ];
    }
}
