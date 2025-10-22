<?php


namespace App\Filament\Resources\Admins\Pages;



use App\Filament\Resources\Admins\AdminResource;
use Filament\Actions\EditAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;


class ViewAdmin extends ViewRecord
{
    protected static string $resource = AdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('forms.common.personal_information'))
                    ->components([
                        TextEntry::make('name')
                            ->label(__('forms.common.name')),
                            
                        TextEntry::make('email')
                            ->label(__('forms.common.email')),

                        TextEntry::make('is_active')
                            ->label(__('forms.common.is_active'))
                            ->badge()
                            ->color(fn(bool $state): string => $state ? 'success' : 'danger')
                            ->formatStateUsing(fn(bool $state): string => $state ? __('forms.common.active') : __('forms.common.inactive')),

                        TextEntry::make('created_at')
                            ->label(__('forms.common.created_at'))
                            ->dateTime('d-m-Y'),

                        TextEntry::make('updated_at')
                            ->label(__('forms.common.updated_at'))
                            ->dateTime('d-m-Y'),
                    ])->columnSpanFull(),
            ]);
    }

}
