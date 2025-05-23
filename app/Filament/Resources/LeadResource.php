<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeadResource\Pages;
use App\Filament\Resources\LeadResource\RelationManagers;
use App\Models\{
    Data,
    Status
};
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Traits\User\GetHelper;
use Filament\Tables\Columns\{
    TextColumn,
    ToggleColumn,
    TextInputColumn,
    SelectColumn
};

class LeadResource extends Resource
{
    use GetHelper;
    protected static ?string $model = Data::class;

    protected static ?string $navigationIcon = 'heroicon-o-table-cells';

    protected static ?string $title = 'Лиды';

    // protected static ?string $navigationGroup = '';

    protected static ?string $navigationLabel = 'Лиды';

    protected static ?string $pluralLabel = 'Лиды';

    protected static ?string $navigationLabelName = 'Лиды';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                ->label('Дата')
                ->sortable()
                ->dateTime(),

                TextColumn::make('page')
                ->label('Источник')
                ->sortable()
                ->searchable(),

                TextColumn::make('phone')
                ->label('Телефон')
                ->sortable()
                ->searchable(),

                SelectColumn::make('status_id')
                ->label('Статус')
                ->options(function () {
                    return Status::all()->mapWithKeys(function ($status) {
                        $colorDot = match ($status->color) {
                            'success' => '🟢',
                            'primary' => '🔵',
                            'warning' => '🟡',
                            'danger'  => '🔴',
                            'gray'    => '⚪️',
                            default   => '⚪️',
                        };
                        return [$status->id => $colorDot . ' ' . $status->name];
                    });
                }),

                TextInputColumn::make('comment')
                ->label('Комментарий'),



            ])
            ->filters([
                //
            ])
            ->actions([])
            ->bulkActions([])
            ->defaultSort('created_at', 'desc');

    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLeads::route('/'),
            // 'create' => Pages\CreateLead::route('/create'),
            // 'edit' => Pages\EditLead::route('/{record}/edit'),
        ];
    }
}
