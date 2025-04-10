<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Models\User;
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
    CheckboxList,
    Toggle,
    Grid,
    Select,
    Section
};
use Spatie\Permission\Models\{
    Role,
    Permission
};
class EmployeeResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $title = 'Мои сотрудники';

    protected static ?string $navigationGroup = 'АДМИНИСТРИРОВАНИЕ';

    protected static ?string $navigationLabel = 'Мои сотрудники';

    protected static ?string $pluralLabel = 'Мои сотрудники';

    protected static ?string $navigationLabelName = 'Мои сотрудники';

    protected static ?int $navigationSort = 4;

    public static function getEloquentQuery(): Builder
    {

        $query = parent::getEloquentQuery();

        if($authUser= auth()->user())
        {
            $query = $query->where('main_user_id',$authUser->id);
        }

        return $query;

    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([

                    TextInput::make('name')
                        ->label('Имя сотрудника')
                        ->maxLength(255)
                        ->required(),

                    TextInput::make('email')
                        ->label('Почтовый ящик')
                        ->email(255)
                        ->maxLength(255)
                        ->required()
                        ->reactive()
                        ->disabled(fn($livewire) => $livewire?->record != null),

                    TextInput::make('password')
                        ->label('Укажите пароль')
                        ->password()
                        ->required()
                        ->minLength(8)
                        ->maxLength(255)
                        ->hidden(fn($livewire) => $livewire?->record !== null),

                    TextInput::make('password_confirmation')
                        ->label('Подтвердите пароль')
                        ->password()
                        ->required()
                        ->minLength(8)
                        ->maxLength(255)
                        ->same('password')
                        ->hidden(fn($livewire) => $livewire?->record !== null),

                        Section::make('Разрешения')
                        ->schema([
                            Forms\Components\Actions::make([
                                Forms\Components\Actions\Action::make('select')
                                    ->label(function($livewire){
                                        if(isset($livewire->data['permissions']) && count($livewire->data['permissions']) == Permission::count())
                                        {
                                            return 'Удалить все';
                                        }else{
                                           return 'Выбрать все';
                                        }
                                    })
                                    ->action(function (Forms\Get $get, Forms\Set $set,$livewire) {
                                        if(isset($livewire->data['permissions']) && count($livewire->data['permissions']) == Permission::count())
                                        {
                                            $livewire->data['permissions'] = [];
                                        }else{
                                            $livewire->data['permissions'] = Permission::pluck('id')->toArray();                                    }

                                    })
                            ])
                            ->reactive(),
                            CheckboxList::make('permissions')
                                ->label('')
                                ->relationship('permissions', 'name')
                                ->options(
                                    Permission::all()->pluck('name', 'id')->mapWithKeys(function ($name, $id) {
                                        return [$id => __('role.' . $name)];
                                    })
                                )
                                ->columns(4)
                                ->gridDirection('row')
                                ->required()
                                ->reactive(),

                            ])

                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('name')
                    ->label('Имя')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('E-mail')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Дата')
                    ->sortable()
                    ->dateTime(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
