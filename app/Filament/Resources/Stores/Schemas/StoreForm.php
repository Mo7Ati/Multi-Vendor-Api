<?php

namespace App\Filament\Resources\Stores\Schemas;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use App\Models\StoreCategory;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class StoreForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make([
                    Section::make(__('forms.common.basic_information'))
                        ->schema([
                            TranslatableTabs::make()
                                ->label(__('forms.common.basic_information'))
                                ->schema([
                                    TextInput::make('name')
                                        ->label(__('forms.common.name'))
                                        ->required()
                                        ->maxLength(255),

                                    Textarea::make('description')
                                        ->label(__('forms.store.description'))
                                        ->rows(4),

                                    TextInput::make('address')
                                        ->label(__('forms.store.address')),
                                ]),
                        ]),
                ]),

                Group::make([
                    Section::make(__('forms.store.credentials'))
                        ->schema([
                            TextInput::make('email')
                                ->label(__('forms.store.email'))
                                ->email()
                                ->required()
                                ->maxLength(255),

                            TextInput::make('password')
                                ->label(__('forms.store.password'))
                                ->password()
                                ->maxLength(255)
                                ->dehydrated(fn($state) => filled($state))
                                ->required(fn(string $context): bool => $context === 'create'),
                        ]),

                    Section::make(__('forms.store.category_and_contact_information'))
                        ->schema([
                            Select::make('category_id')
                                ->label(__('forms.store.category'))
                                ->options(StoreCategory::all()->pluck('name', 'id'))
                                ->searchable(),

                            TextInput::make('phone')
                                ->label(__('forms.store.phone'))
                                ->tel()
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->maxLength(20),
                        ]),


                    Section::make(__('forms.store.settings'))
                        ->schema([
                            TextInput::make('delivery_time')
                                ->label(__('forms.store.delivery_time'))
                                ->numeric()
                                ->required(),

                            Toggle::make('is_active')
                                ->label(__('forms.store.is_active'))
                                ->required()
                                ->default(true),
                        ]),
                ]),
            ]);
    }
}
