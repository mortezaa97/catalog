<?php

declare(strict_types=1);

namespace Mortezaa97\Catalogs\Filament\Resources\Catalogs\Pages;

use Mortezaa97\Catalogs\Filament\Resources\Catalogs\CatalogResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCatalog extends CreateRecord
{
    protected static string $resource = CatalogResource::class;
}

