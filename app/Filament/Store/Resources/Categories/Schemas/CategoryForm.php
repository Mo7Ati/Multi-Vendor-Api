<?php

namespace App\Filament\Store\Resources\Categories\Schemas;

use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Form components will be added here
            ]);
    }
}
