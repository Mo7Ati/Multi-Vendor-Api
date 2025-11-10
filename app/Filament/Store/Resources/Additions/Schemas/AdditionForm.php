<?php

namespace App\Filament\Store\Resources\Additions\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AdditionForm
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
                                ->maxLength(255)
                                ->translatableTabs(),
                        ]),
                ]),
                Group::make([
                    Section::make(__('forms.common.status'))
                        ->schema([
                            Toggle::make('is_active')
                                ->label(__('forms.common.is_active'))
                                ->required()
                                ->default(true),
                        ]),
                ]),
            ]);
    }
}
