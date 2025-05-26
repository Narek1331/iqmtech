<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnalyticsResource\Pages;
use App\Filament\Resources\AnalyticsResource\RelationManagers;
use App\Models\{
    Project
};
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\{
    TextColumn,
    ToggleColumn
};
use Filament\Tables\Actions\Action;

class AnalyticsResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar-square';

    protected static ?string $title = 'Аналитика';

    // protected static ?string $navigationGroup = '';

    protected static ?string $navigationLabel = 'Аналитика';

    protected static ?string $pluralLabel = 'Аналитика';

    protected static ?string $navigationLabelName = 'Аналитика';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Проект')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('Общая статистика')
                    ->label('Общая статистика')
                    ->color('warning')
                    ->url(function($record){
                        $recordId = $record->id;

                        return "/app/analytics/$recordId/annual";
                    }),
                Action::make('Помесячная статистика')
                    ->label('Помесячная статистика')
                    ->color('warning')
                    ->url(function($record){
                        $recordId = $record->id;

                        return "/app/analytics/$recordId/monthly";
                    }),
                Action::make('Ежедневная статистика')
                    ->label('Ежедневная статистика')
                    ->color('warning')
                    ->url(function($record){
                        $recordId = $record->id;

                        return "/app/analytics/$recordId/daily";
                    })
            ])
            ->bulkActions([]);
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
            'index' => Pages\ListAnalytics::route('/'),
            'annual' => Pages\Annual::route('/{record}/annual'),
            'monthly' => Pages\Monthly::route('/{record}/monthly'),
            'daily' => Pages\Daily::route('/{record}/daily')

        ];
    }
}
