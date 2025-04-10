<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DataResource\Pages;
use App\Filament\Resources\DataResource\RelationManagers;
use App\Models\Data;
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
    Grid
};

use Filament\Tables\Filters\Filter;
use Carbon\Carbon;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Traits\User\GetHelper;


class DataResource extends Resource
{
    use GetHelper;
    protected static ?string $model = Data::class;

    protected static ?string $navigationIcon = 'heroicon-o-table-cells';

    protected static ?string $title = 'Данные';

    protected static ?string $navigationGroup = 'ОТЧЕТЫ';

    protected static ?string $navigationLabel = 'Данные';

    protected static ?string $pluralLabel = 'Данные';

    protected static ?string $navigationLabelName = 'Данные';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    // 1. Дата (обычно 'created_at' не редактируется, но можно отобразить как disabled или hidden)
                    TextInput::make('created_at')
                        ->label('Дата')
                        ->disabled()
                        ->dehydrated(false), // не отправлять на сохранение

                    // 2. Город
                    TextInput::make('city')
                        ->label('Город'),

                    // 3. Устройство
                    TextInput::make('device')
                        ->label('Устройство')
                        ->maxLength(50),

                    // 4. Оператор
                    TextInput::make('mobile_operator')
                        ->label('Мобильный оператор'),

                    // 5. Телефон
                    TextInput::make('phone')
                        ->label('Телефон')
                        ->tel()
                        ->maxLength(20),

                    // 6. IP
                    TextInput::make('ip_address')
                        ->label('IP-адрес')
                        ->required()
                        ->maxLength(45),

                    // 7. Пол
                    TextInput::make('gender')
                        ->label('Пол'),

                    // 8. Возраст
                    TextInput::make('age')
                        ->label('Возраст'),

                    // 9. Платформа
                    TextInput::make('platform')
                        ->label('Платформа')
                        ->maxLength(50),

                    // 10. Браузер
                    TextInput::make('browser')
                        ->label('Браузер')
                        ->maxLength(50),

                    // Остальные поля:
                    TextInput::make('page')
                        ->label('Страница')
                        ->required()
                        ->maxLength(2048),

                    TextInput::make('ref')
                        ->label('Реферер')
                        ->maxLength(2048),

                    TextInput::make('utm_term')
                        ->label('UTM-терм')
                        ->maxLength(255),

                    TextInput::make('utm_source')
                        ->label('UTM-источник')
                        ->maxLength(255),

                    TextInput::make('utm_campaign')
                        ->label('UTM-кампания')
                        ->maxLength(255),

                    TextInput::make('utm_medium')
                        ->label('UTM-тип трафика')
                        ->maxLength(255),

                    TextInput::make('utm_content')
                        ->label('UTM-контент')
                        ->maxLength(255),

                    TextInput::make('latitude')
                        ->label('Latitude'),

                    TextInput::make('longitude')
                        ->label('Longitude'),

                    TextInput::make('region')
                        ->label('Область'),

                    TextInput::make('country')
                        ->label('Страна'),

                    TextInput::make('address')
                        ->label('Адрес'),
                ])
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
        ->columns([

            TextColumn::make('created_at')->label('Дата')->sortable()->dateTime(),

            TextColumn::make('city')->label('Город')->sortable()->searchable(),

            TextColumn::make('device')->label('Устройство')->sortable()->searchable(),

            TextColumn::make('mobile_operator')->label('Оператор')->sortable()->searchable(),

            TextColumn::make('phone')->label('Телефон')->sortable()->searchable(),

            TextColumn::make('ip_address')->label('IP-адрес')->sortable()->searchable(),

            TextColumn::make('gender')->label('Пол')->sortable()->searchable(),

            TextColumn::make('age')->label('Возраст')->sortable()->searchable(),

            TextColumn::make('platform')->label('Платформа')->sortable()->searchable(),

            TextColumn::make('browser')->label('Браузер')->sortable()->searchable(),

            TextColumn::make('page')->label('Страница')->sortable()->searchable(),
            TextColumn::make('ref')->label('Реферер')->sortable()->searchable(),
            TextColumn::make('utm_term')->label('UTM-терм')->sortable()->searchable(),
            TextColumn::make('utm_source')->label('UTM-источник')->sortable()->searchable(),
            TextColumn::make('utm_campaign')->label('UTM-кампания')->sortable()->searchable(),
            TextColumn::make('utm_medium')->label('UTM-тип трафика')->sortable()->searchable(),
            TextColumn::make('utm_content')->label('UTM-контент')->sortable()->searchable(),
            TextColumn::make('latitude')->label('Latitude')->sortable()->searchable(),
            TextColumn::make('longitude')->label('Longitude')->sortable()->searchable(),
            TextColumn::make('region')->label('Область')->sortable()->searchable(),
            TextColumn::make('country')->label('Страна')->sortable()->searchable(),
            TextColumn::make('address')->label('Адрес')->sortable()->searchable(),

        ])
        ->filters([
            Tables\Filters\Filter::make('created_at')
        ->label('Дата')
        ->form([
            Forms\Components\Grid::make(2)
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

            ->query(function (Builder $query, array $data): Builder {
                $query = $query;

                if (!empty($data['preset'])) {
                    switch ($data['preset']) {
                        case 'today':
                            return $query->whereDate('created_at', Carbon::today());
                        case 'yesterday':
                            return $query->whereDate('created_at', Carbon::yesterday());
                        case 'week':
                            return $query->whereDate('created_at', '>=', Carbon::now()->subDays(7));
                        case 'month':
                            return $query->whereDate('created_at', '>=', Carbon::now()->subMonth());
                    }
                }

                return $query
                    ->when($data['from'], fn ($q) => $q->whereDate('created_at', '>=', $data['from']))
                    ->when($data['until'], fn ($q) => $q->whereDate('created_at', '<=', $data['until']));
            })
            ->indicateUsing(function (array $data): array {
                $indicators = [];

                if (!empty($data['preset'])) {
                    $map = [
                        'today' => 'Сегодня',
                        'yesterday' => 'Вчера',
                        'week' => 'Последняя неделя',
                        'month' => 'Последний месяц',
                    ];
                    $indicators[] = $map[$data['preset']] ?? '';
                }

                if (!empty($data['from'])) {
                    $indicators[] = 'От: ' . Carbon::parse($data['from'])->format('d.m.Y');
                }

                if (!empty($data['until'])) {
                    $indicators[] = 'До: ' . Carbon::parse($data['until'])->format('d.m.Y');
                }

                return $indicators;
            }),

            Tables\Filters\SelectFilter::make('city')
                ->label('Город')
                ->options(fn () => Data::query()->distinct()->pluck('city', 'city')->filter()->toArray())
                ->searchable(),

            Tables\Filters\SelectFilter::make('mobile_operator')
                ->label('Оператор')
                ->options(fn () => Data::query()->distinct()->pluck('mobile_operator', 'mobile_operator')->filter()->toArray())
                ->searchable(),
        ])
        ->actions([])
        ->bulkActions([
            ExportBulkAction::make()
        ])
        ->defaultSort('created_at', 'desc');

    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListData::route('/'),
            'view' => Pages\ViewData::route('/{record}'),

        ];
    }
}
