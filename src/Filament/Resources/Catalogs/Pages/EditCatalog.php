<?php

declare(strict_types=1);

namespace Mortezaa97\Catalogs\Filament\Resources\Catalogs\Pages;

use Mortezaa97\Catalogs\Filament\Resources\Catalogs\CatalogResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditCatalog extends EditRecord
{
    protected static string $resource = CatalogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}

