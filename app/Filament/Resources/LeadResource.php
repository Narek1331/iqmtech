<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeadResource\Pages;
use App\Filament\Resources\LeadResource\RelationManagers;
use App\Models\{
    Data,
    Status,
    Project
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
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Carbon\Carbon;
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
                                Filter::make('date_filter')
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
                SelectFilter::make('status_id')
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
                })
                ->query(function ($query, $data) {
                    if(isset($data['value']) && $data['value'])
                    {
                        $query->where('status_id', $data['value']);
                    }
                }),
                SelectFilter::make('page')
                ->label('Источник')
                ->options(function () {
                    return Data::where('user_id',auth()->user()->id)
                    ->get()->pluck('page','page');
                })
                ->query(function ($query, $data) {
                    if(isset($data['value']) && $data['value'])
                    {
                        $query->where('page', $data['value']);
                    }
                }),
                SelectFilter::make('project')
                ->label('Проекту')
                ->options(function () {
                    return Project::where('user_id',auth()->user()->id)
                    ->get()->pluck('name','id');
                })
                ->query(function ($query, $data) {
                    if(isset($data['value']) && $data['value'])
                    {
                        $query->where('project_id', $data['value']);
                    }
                }),
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
