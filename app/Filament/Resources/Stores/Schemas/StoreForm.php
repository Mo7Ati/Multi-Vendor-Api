<?php

namespace App\Filament\Resources\Stores\Schemas;

use App\Models\StoreCategory;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
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
                    Section::make(__('forms.store.basic_information'))
                        ->schema([
                            TextInput::make('name')
                                ->label(__('forms.store.name'))
                                ->required()
                                ->maxLength(255)
                                ->translatableTabs(),

                            Textarea::make('description')
                                ->label(__('forms.store.description'))
                                ->rows(4)
                                ->translatableTabs(),

                            TextInput::make('address')
                                ->label(__('forms.store.address'))
                                ->translatableTabs(),
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
                                ->searchable()
                                ->required(),

                            TextInput::make('phone')
                                ->label(__('forms.store.phone'))
                                ->tel()
                                ->maxLength(20),
                        ]),


                    Section::make(__('forms.store.settings'))
                        ->schema([
                            TextInput::make('delivery_time')
                                ->label(__('forms.store.delivery_time'))
                                ->maxLength(255),

                            Toggle::make('is_active')
                                ->label(__('forms.store.is_active'))
                                ->required()
                                ->default(true),
                        ]),

                ]),

                // Section::make(__('forms.store.social_media'))
                //     ->schema([
                //         KeyValue::make('social_media')
                //             ->label(__('forms.store.social_media'))
                //             ->keyLabel(__('forms.store.platform'))
                //             ->valueLabel(__('forms.store.url'))
                //             ->addActionLabel(__('forms.store.add_social_media')),
                //     ])->columnSpanFull(),

                Section::make(__('forms.store.media'))
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('logo')
                            ->collection('stores-logo')
                            ->label(__('forms.store.logo'))
                            ->image(),
                    ])->columnSpanFull(),
            ]);
    }
}
