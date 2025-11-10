<?php

namespace App\Filament\Store\Resources\Products\Schemas;

use AbdulmajeedJamaan\FilamentTranslatableTabs\TranslatableTabs;
use App\Filament\Store\Resources\Additions\Schemas\AdditionForm;
use App\Filament\Store\Resources\Options\Schemas\OptionForm;
use App\Models\Addition;
use App\Models\Category;
use App\Models\Option;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProductForm
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
                                        ->label(__('forms.common.description'))
                                        ->rows(4),

                                    TextInput::make('keywords')
                                        ->label(__('forms.common.keywords'))
                                        ->helperText(__('forms.common.keywords_helper_text'))
                                        ->maxLength(255),
                                ]),
                        ]),
                ]),
                Group::make([
                    Section::make(__('forms.product.category_and_price'))
                        ->schema([

                            Select::make('category_id')
                                ->relationship('category', 'name')
                                ->label(__('forms.product.category'))
                                ->required()
                                ->options(Category::all()->pluck('name', 'id'))
                                ->searchable(),


                            TextInput::make('price')
                                ->label(__('forms.product.price'))
                                ->required()
                                ->numeric()
                                ->prefix('USD'),

                            TextInput::make('compare_price')
                                ->label(__('forms.product.compare_price'))
                                ->numeric()
                                ->prefix('USD'),
                        ]),

                    Section::make(__('forms.product.product_settings'))
                        ->schema([
                            TextInput::make('quantity')
                                ->label(__('forms.product.quantity'))
                                ->required()
                                ->numeric(),

                            Toggle::make('is_active')
                                ->label(__('forms.common.is_active'))
                                ->required()
                                ->default(true),
                        ]),
                ]),

                Group::make([
                    Section::make()
                        ->heading(__('forms.product.options'))
                        ->schema([
                            Repeater::make('options')
                                ->label(__('forms.product.options'))
                                ->schema([
                                    Select::make('option_id')
                                        ->label(__('forms.product.option'))
                                        ->options(function () {
                                            return Option::where('is_active', true)
                                                ->where('store_id', auth()->guard('store')->id())
                                                ->get()
                                                ->pluck('name', 'id');
                                        })
                                        ->createOptionForm(fn($schema) => OptionForm::configure($schema))
                                        ->createOptionUsing(function (array $data): int {
                                            $option = Option::create($data);
                                            return $option->getKey();
                                        })
                                        ->searchable()
                                        ->required(),

                                    TextInput::make('price')
                                        ->label(__('forms.common.price'))
                                        ->numeric()
                                        ->prefix('$')
                                        ->required(),
                                ])
                                ->columns(2)
                                ->defaultItems(0)
                                ->reorderableWithButtons()
                                ->collapsible()
                                ->itemLabel(function (array $state): ?string {
                                    if (isset($state['option_id'])) {
                                        $option = \App\Models\Option::find($state['option_id']);
                                        return $option?->getTranslation('name', app()->getLocale()) ?? $option?->name;
                                    }
                                    return null;
                                }),
                        ]),
                ]),
                Group::make([
                    Section::make()
                        ->heading(__('forms.product.additions'))
                        ->schema([
                            Repeater::make('additions')
                                ->label(__('forms.product.additions'))
                                ->schema([
                                    Select::make('addition_id')
                                        ->label(__('forms.product.addition'))
                                        ->options(function () {
                                            return Addition::where('is_active', true)
                                                ->where('store_id', auth()->guard('store')->id())
                                                ->pluck('name', 'id');
                                        })
                                        ->searchable()
                                        ->required()
                                        // ->createOptionForm(AdditionForm::configure())
                                        ->createOptionUsing(function (array $data): int {
                                            $addition = Addition::create($data);
                                            return $addition->getKey();
                                        }),
                                    TextInput::make('price')
                                        ->label(__('forms.common.price'))
                                        ->numeric()
                                        ->prefix('$')
                                        ->required(),
                                ])
                                ->columns(2)
                                ->defaultItems(0)
                                ->reorderableWithButtons()
                                ->collapsible()
                                ->itemLabel(function (array $state): ?string {
                                    if (isset($state['addition_id'])) {
                                        $addition = \App\Models\Addition::find($state['addition_id']);
                                        return $addition?->getTranslation('name', app()->getLocale()) ?? $addition?->name;
                                    }
                                    return null;
                                }),
                        ]),
                ]),

                Section::make(__('forms.product.media'))
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('image')
                            ->label(__('forms.product.image'))
                            ->collection('product-images')
                            ->image()
                            ->imageEditor(),
                    ])->columnSpanFull(),
            ]);
    }
}
