<?php

namespace App\Filament\Store\Resources\Categories\Schemas;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
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
                                    ->label(__('forms.common.description'))
                                    ->rows(4),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }
}
