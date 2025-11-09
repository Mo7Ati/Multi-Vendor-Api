<?php

namespace App\Filament\Resources\Admins\Schemas;

use Filament\Forms\Components\EmailInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AdminForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make([
                    Section::make(__('forms.common.basic_information'))
                        ->schema([
                            TextInput::make('name')
                                ->label(__('forms.common.name'))
                                ->required()
                                ->maxLength(255),

                            TextInput::make('email')
                                ->label(__('forms.common.email'))
                                ->email()
                                ->unique(ignoreRecord: true)
                                ->required()
                                ->maxLength(255),

                            TextInput::make('password')
                                ->label(__('forms.common.password'))
                                ->required(fn(string $context): bool => $context === 'create')
                                ->password()
                                ->helperText(__('forms.admins.password_helper_text'))
                                ->dehydrated(fn($state) => filled($state))
                                ->maxLength(255),
                        ]),
                ]),

                Section::make(__('forms.common.status'))
                    ->schema([
                        Toggle::make('is_active')
                            ->label(__('forms.common.is_active'))
                            ->required()
                            ->default(true),
                    ]),
            ]);
    }
}
