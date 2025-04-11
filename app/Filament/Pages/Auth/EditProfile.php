<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;

class EditProfile extends BaseEditProfile
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getNameFormComponent(),
                TextInput::make('full_name_of_contact_person')
                    ->label('ФИО контактного лица')
                    ->minLength(1)
                    ->maxLength(250),
                $this->getEmailFormComponent(),
                TextInput::make('company_name')
                    ->label('Название компании')
                    ->maxLength(1)
                    ->maxLength(250),
                PhoneInput::make('phone')
                    ->label('Телефон')
                    ->countryStatePath('ru')
                    ->onlyCountries(['ru'])
                    ->required(),
                // $this->getPasswordFormComponent(),
                // $this->getPasswordConfirmationFormComponent(),
            ]);
    }
}
