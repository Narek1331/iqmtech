<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ProjectResource\Pages;
use App\Filament\Admin\Resources\ProjectResource\RelationManagers;
use App\Models\Project;
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
use Filament\Forms\Components\{
    TextInput,
    Card,
    Toggle,
    Grid,
    Repeater,
    Section
};

use Filament\Tables\Filters\Filter;
use Carbon\Carbon;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Components\Actions\Action;
use Webbingbrasil\FilamentCopyActions\Forms\Actions\CopyAction;
class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-code-bracket';

    protected static ?string $title = 'Проекты';

    // protected static ?string $navigationGroup = 'ОТЧЕТЫ';

    protected static ?string $navigationLabel = 'Проекты';

    protected static ?string $pluralLabel = 'Проекты';

    protected static ?string $navigationLabelName = 'Проекты';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Card::make()->schema([
                Toggle::make('status')
                    ->label('Статус'),
                TextInput::make('name')
                    ->label('Проект')
                    ->maxLength(255)
                    ->required(),
                TextInput::make('global_limit')
                    ->label('Глобальный лимит')
                    ->default(0)
                    ->minValue(0)
                    ->maxValue(10000)
                    ->numeric(),
                TextInput::make('daily_limit')
                    ->label('Дневной лимит')
                    ->default(0)
                    ->minValue(0)
                    ->maxValue(10000)
                    ->numeric(),
                Section::make('Домены')->schema([
                    Repeater::make('domains')
                        ->label('')
                        ->relationship('domains')
                        ->schema([
                            TextInput::make('domain')
                            ->label('Домен')
                            // ->rule('regex:/^(https?:\/\/)?([a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,6})$/i')
                            ->maxLength(255)
                            ->required(),
                        ])
                        ->createItemButtonLabel('Добавить домен')
                        ->columns('full')
                        ]),
                TextInput::make('token')
                    ->label('Токен')
                    ->suffixAction(CopyAction::make('Копировать'))
                    ->readOnly(),
                ])


        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('number_of_identifications')
                    ->label('Кол-во идентификаций')
                    ->alignment('left')
                    ->getStateUsing(function ($record) {
                        $current = $record->daily_limit ?? 0;
                        $left =  $current - $record->datas()->count();

                        return <<<HTML
                        <div>
                            <p>Текущий: <span class="font-medium">$current</span></p>
                            <p>Осталось: <span class="font-medium">$left</span></p>
                        </div>
                    HTML;
                    })
                    ->html(),
                TextColumn::make('price')
                    ->label('Стоимость')
                    ->sortable()
                    ->getStateUsing(function ($record) {
                        return number_format($record->global_limit * 10, 0, '.', ' ');;
                    }),
                TextColumn::make('name')
                    ->label('Проект')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('global_limit')
                    ->label('Глобальный лимит')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('daily_limit')
                    ->label('Дневной лимит')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('domains.domain')
                    ->label('Домены')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                ToggleColumn::make('status')
                    ->label('Статус')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Дата')
                    ->sortable()
                    ->toggleable()
                    ->dateTime(),

                TextColumn::make('user.name')
                    ->label('Создатель')
                    ->icon('heroicon-o-user')
                    ->formatStateUsing(function($record,$state){
                        if($record->user->id == auth()->user()->id)
                        {
                            return 'Это я';
                        }

                        return $state;
                    })
                    ->action(function($record){
                        if($record->user->id != auth()->user()->id)
                        {
                            $id = $record->user->id;
                            return redirect("/admin/clients/$id/edit");
                        }
                    })
                    ->searchable()
                    ->toggleable()
                    ->sortable(),

                    TextColumn::make('id')
                    ->label('Данные')
                    ->formatStateUsing(function($record,$state){
                        return 'Данные';
                    })
                    ->icon('heroicon-o-document')
                    ->action(function($record){
                        $userId = $record->user->id;
                        $projectId = $record->id;
                        return redirect("/admin/data?tableFilters[user_id][value]=$userId&tableFilters[project_id][value]=$projectId");
                    })
                    ->toggleable()

            ])

            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Filter::make('date_range')
                    ->form([
                        Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('preset')
                                    ->label('Период')
                                    ->options([
                                        'today' => 'Сегодня',
                                        'yesterday' => 'Вчера',
                                        'week' => 'Последняя неделя',
                                        'month' => 'Последний месяц',
                                    ])
                                    ->columnSpan('full'),

                                Forms\Components\DatePicker::make('from')
                                ->label('От')
                                ->columnSpan(1),
                                Forms\Components\DatePicker::make('until')
                                ->label('До')
                                ->columnSpan(1),
                            ]),
                    ])
                    ->query(function ($query, array $data) {
                        $query->withTrashed();

                        if (!empty($data['preset'])) {
                            match ($data['preset']) {
                                'today' => $query->whereDate('created_at', today()),
                                'yesterday' => $query->whereDate('created_at', today()->subDay()),
                                'week' => $query->whereBetween('created_at', [now()->subWeek(), now()]),
                                'month' => $query->whereBetween('created_at', [now()->subMonth(), now()]),
                                default => null,
                            };
                        }

                        if (!empty($data['from'])) {
                            $query->whereDate('created_at', '>=', $data['from']);
                        }

                        if (!empty($data['until'])) {
                            $query->whereDate('created_at', '<=', $data['until']);
                        }

                        return $query;
                    }),

                Filter::make('status')
                    ->form([
                        Forms\Components\Select::make('status')
                            ->label('Статус')
                            ->options([
                                '1' => 'Активные',
                                '0' => 'Неактивные',
                            ])
                            ->placeholder('Все'),
                    ])
                    ->query(function ($query, array $data) {
                        $query->withTrashed();
                        if (isset($data['status']) && $data['status'] !== '') {
                            $query->where('status', $data['status']);
                        }
                        return $query;
                    }),
            ])

            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->modalHeading('Удалить'),
                Tables\Actions\ForceDeleteAction::make()
                    ->modalHeading('Удалить навсегда'),
                Tables\Actions\RestoreAction::make()
                    ->modalHeading('Восстановить')
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->modalHeading('Удалить'),
                    Tables\Actions\ForceDeleteBulkAction::make()
                        ->modalHeading('Удалить навсегда'),
                    Tables\Actions\RestoreBulkAction::make()
                        ->modalHeading('Восстановить')
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
            'index' => Pages\ListProjects::route('/'),
            // 'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
