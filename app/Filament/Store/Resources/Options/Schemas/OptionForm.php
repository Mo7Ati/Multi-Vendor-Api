<?php

namespace App\Filament\Store\Resources\Options\Schemas;

use Filament\Schemas\Schema;

class OptionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Form components will be added here
            ]);
    }
}
