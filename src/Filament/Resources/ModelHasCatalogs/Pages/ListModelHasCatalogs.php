<?php

declare(strict_types=1);

namespace Mortezaa97\Catalogs\Filament\Resources\ModelHasCatalogs\Pages;

use Mortezaa97\Catalogs\Filament\Resources\ModelHasCatalogs\ModelHasCatalogResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListModelHasCatalogs extends ListRecords
{
    protected static string $resource = ModelHasCatalogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('افزودن آیتم به کاتالوگ'),
        ];
    }
}

