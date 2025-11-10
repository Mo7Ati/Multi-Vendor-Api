<?php

namespace App\Filament\Store\Resources\Categories;

use App\Filament\Store\Resources\Categories\Pages\CreateCategory;
use App\Filament\Store\Resources\Categories\Pages\EditCategory;
use App\Filament\Store\Resources\Categories\Pages\ListCategories;
use App\Filament\Store\Resources\Categories\Pages\ViewCategory;
use App\Filament\Store\Resources\Categories\Schemas\CategoryForm;
use App\Filament\Store\Resources\Categories\Tables\CategoriesTable;
use App\Models\Category;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    public static function form(Schema $schema): Schema
    {
        return CategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CategoriesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCategories::route('/'),
            'create' => CreateCategory::route('/create'),
            'view' => ViewCategory::route('/{record}'),
            'edit' => EditCategory::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): string
    {
        return __('general.nav_groups.products_management');
    }

    public static function getNavigationLabel(): string
    {
        return __('general.nav_labels.categories');
    }

    public static function getModelLabel(): string
    {
        return __('general.labels.category');
    }

    public static function getPluralModelLabel(): string
    {
        return __('general.labels.categories');
    }
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
