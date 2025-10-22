<?php

namespace App\Filament\Resources\StoreCategories;

use App\Filament\Resources\StoreCategories\Pages\CreateStoreCategory;
use App\Filament\Resources\StoreCategories\Pages\EditStoreCategory;
use App\Filament\Resources\StoreCategories\Pages\ListStoreCategories;
use App\Filament\Resources\StoreCategories\Pages\ViewStoreCategory;
use App\Filament\Resources\StoreCategories\Schemas\StoreCategoryForm;
use App\Filament\Resources\StoreCategories\Tables\StoreCategoriesTable;
use App\Models\StoreCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class StoreCategoryResource extends Resource
{
    protected static ?string $model = StoreCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return StoreCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StoreCategoriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStoreCategories::route('/'),
            'create' => CreateStoreCategory::route('/create'),
            'view' => ViewStoreCategory::route('/{record}'),
            'edit' => EditStoreCategory::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): string
    {
        return __('general.nav_groups.store_management');
    }

    public static function getNavigationLabel(): string
    {
        return __('general.nav_labels.store_categories');
    }

    public static function getModelLabel(): string
    {
        return __('general.labels.store_category');
    }

    public static function getPluralModelLabel(): string
    {
        return __('general.labels.store_categories');
    }
}
