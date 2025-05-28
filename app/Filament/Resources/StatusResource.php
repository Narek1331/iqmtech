<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StatusResource\Pages;
use App\Filament\Resources\StatusResource\RelationManagers;
use App\Models\Status;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StatusResource extends Resource
{
    protected static ?string $model = Status::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $title = 'Статусы';

    // protected static ?string $navigationGroup = '';

    protected static ?string $navigationLabel = 'Статусы';

    protected static ?string $pluralLabel = 'Статусы';

    protected static ?string $navigationLabelName = 'Статусы';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Название')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('color')
                    ->label('Цвет')
                    ->colors([
                        'success' => 'success',
                        'primary' => 'primary',
                        'warning' => 'warning',
                        'danger'  => 'danger',
                        'gray'    => 'gray',
                    ])
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'success' => '🟢',
                        'primary' => '🔵',
                        'warning' => '🟡',
                        'danger'  => '🔴',
                        'gray'    => '⚪️',
                        default => $state,
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('color')
                    ->label('Цвет')
                    ->options([
                        'success' => '🟢 success',
                        'primary' => '🔵 primary',
                        'warning' => '🟡 warning',
                        'danger'  => '🔴 danger',
                        'gray'    => '⚪️ gray',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                    ->modalHeading('Удалить'),
                ]),
            ]);
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
            'index' => Pages\ListStatuses::route('/'),
            'create' => Pages\CreateStatus::route('/create'),
            'edit' => Pages\EditStatus::route('/{record}/edit'),
        ];
    }
}
