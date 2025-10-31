<?php

declare(strict_types=1);

namespace Mortezaa97\Catalogs\Filament\Resources\Catalogs\Pages;

use Mortezaa97\Catalogs\Filament\Resources\Catalogs\CatalogResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCatalogs extends ListRecords
{
    protected static string $resource = CatalogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

