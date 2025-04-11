<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlackPhoneResource\Pages;
use App\Filament\Resources\BlackPhoneResource\RelationManagers;
use App\Models\BlackPhone;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\{
    TextColumn,
};
use Filament\Forms\Components\{
    TextInput,
    Card,
};
use App\Traits\User\GetHelper;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
class BlackPhoneResource extends Resource
{
    use GetHelper;
    protected static ?string $model = BlackPhone::class;

    protected static ?string $navigationIcon = 'heroicon-o-phone-x-mark';

    protected static ?string $title = 'Запрещенные телефоны';

    protected static ?string $navigationGroup = 'ЧЕРНЫЙ СПИСОК';

    protected static ?string $navigationLabel = 'Запрещенные телефоны';

    protected static ?string $pluralLabel = 'Запрещенные телефоны';

    protected static ?string $navigationLabelName = 'Запрещенные телефоны';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    PhoneInput::make('phone')
                        ->label('Телефон')
                        ->countryStatePath('ru')
                        ->onlyCountries(['ru'])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('created_at')
                    ->label('Дата')
                    ->sortable()
                    ->dateTime(),

                TextColumn::make('phone')
                    ->label('Телефон')
                    ->sortable()
                    ->searchable(),

            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->modalHeading('Удалить'),
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
            'index' => Pages\ListBlackPhones::route('/'),
            'create' => Pages\CreateBlackPhone::route('/create'),
            'edit' => Pages\EditBlackPhone::route('/{record}/edit'),
        ];
    }
}
