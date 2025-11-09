<?php

namespace App\Filament\Resources\StoreCategories\Schemas;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class StoreCategoryForm
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
                                        ->label(__('forms.store_category.name'))
                                        ->required()
                                        ->maxLength(255),

                                    Textarea::make('description')
                                        ->label(__('forms.store_category.description'))
                                        ->rows(4),
                                ]),
                        ]),
                ])->columnSpanFull(),
            ]);
    }
}
