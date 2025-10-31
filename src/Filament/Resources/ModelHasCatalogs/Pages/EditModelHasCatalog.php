<?php

declare(strict_types=1);

namespace Mortezaa97\Catalogs\Filament\Resources\ModelHasCatalogs\Pages;

use Mortezaa97\Catalogs\Filament\Resources\ModelHasCatalogs\ModelHasCatalogResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditModelHasCatalog extends EditRecord
{
    protected static string $resource = ModelHasCatalogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

