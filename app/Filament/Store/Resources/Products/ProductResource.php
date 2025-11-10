<?php

namespace App\Filament\Store\Resources\Products;

use App\Filament\Store\Resources\Products\Pages\CreateProduct;
use App\Filament\Store\Resources\Products\Pages\EditProduct;
use App\Filament\Store\Resources\Products\Pages\ListProducts;
use App\Filament\Store\Resources\Products\Pages\ViewProduct;
use App\Filament\Store\Resources\Products\Schemas\ProductForm;
use App\Filament\Store\Resources\Products\Tables\ProductsTable;
use App\Models\Product;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return ProductForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductsTable::configure($table);
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
            'index' => ListProducts::route('/'),
            'create' => CreateProduct::route('/create'),
            'view' => ViewProduct::route('/{record}'),
            'edit' => EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): string
    {
        return __('general.nav_groups.products_management');
    }

    public static function getNavigationLabel(): string
    {
        return __('general.nav_labels.products');
    }

    public static function getModelLabel(): string
    {
        return __('general.labels.product');
    }

    public static function getPluralModelLabel(): string
    {
        return __('general.labels.products');
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
