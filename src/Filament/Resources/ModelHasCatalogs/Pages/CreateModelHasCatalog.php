<?php

declare(strict_types=1);

namespace Mortezaa97\Catalogs\Filament\Resources\ModelHasCatalogs\Pages;

use Mortezaa97\Catalogs\Filament\Resources\ModelHasCatalogs\ModelHasCatalogResource;
use Filament\Resources\Pages\CreateRecord;

class CreateModelHasCatalog extends CreateRecord
{
    protected static string $resource = ModelHasCatalogResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

