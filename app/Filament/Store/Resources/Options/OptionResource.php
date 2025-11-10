<?php

namespace App\Filament\Store\Resources\Options;

use App\Filament\Store\Resources\Options\Pages\CreateOption;
use App\Filament\Store\Resources\Options\Pages\EditOption;
use App\Filament\Store\Resources\Options\Pages\ListOptions;
use App\Filament\Store\Resources\Options\Pages\ViewOption;
use App\Filament\Store\Resources\Options\Schemas\OptionForm;
use App\Filament\Store\Resources\Options\Tables\OptionsTable;
use App\Models\Option;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class OptionResource extends Resource
{
    protected static ?string $model = Option::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static ?int $navigationSort = 7;

    public static function form(Schema $schema): Schema
    {
        return OptionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OptionsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOptions::route('/'),
            'create' => CreateOption::route('/create'),
            'view' => ViewOption::route('/{record}'),
            'edit' => EditOption::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): string
    {
        return __('general.nav_groups.products_management');
    }

    public static function getNavigationLabel(): string
    {
        return __('general.nav_labels.options');
    }

    public static function getModelLabel(): string
    {
        return __('general.labels.option');
    }

    public static function getPluralModelLabel(): string
    {
        return __('general.labels.options');
    }
    public static function getNavigationBadge(): ?string
    {
        return self::getModel()::count();
    }
}
