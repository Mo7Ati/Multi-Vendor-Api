<?php

namespace App\Filament\Store\Resources\Additions;

use App\Filament\Store\Resources\Additions\Pages\CreateAddition;
use App\Filament\Store\Resources\Additions\Pages\EditAddition;
use App\Filament\Store\Resources\Additions\Pages\ListAdditions;
use App\Filament\Store\Resources\Additions\Pages\ViewAddition;
use App\Filament\Store\Resources\Additions\Schemas\AdditionForm;
use App\Filament\Store\Resources\Additions\Tables\AdditionsTable;
use App\Models\Addition;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AdditionResource extends Resource
{
    protected static ?string $model = Addition::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPlus;

    protected static ?string $navigationLabel = 'Additions';

    protected static ?string $modelLabel = 'Addition';

    protected static ?string $pluralModelLabel = 'Additions';

    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return AdditionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AdditionsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAdditions::route('/'),
            'create' => CreateAddition::route('/create'),
            'view' => ViewAddition::route('/{record}'),
            'edit' => EditAddition::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): string
    {
        return __('general.nav_groups.store_management');
    }

    public static function getNavigationLabel(): string
    {
        return __('general.nav_labels.additions');
    }

    public static function getModelLabel(): string
    {
        return __('general.labels.addition');
    }

    public static function getPluralModelLabel(): string
    {
        return __('general.labels.additions');
    }
}
