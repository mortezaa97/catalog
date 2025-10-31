<?php

declare(strict_types=1);

namespace Mortezaa97\Catalogs;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Mortezaa97\Catalogs\Filament\Resources\Catalogs\CatalogResource;
use Mortezaa97\Catalogs\Filament\Resources\ModelHasCatalogs\ModelHasCatalogResource;

class CatalogsPlugin implements Plugin
{
    public static function make(): static
    {
        return app(static::class);
    }

    public function getId(): string
    {
        return 'catalogs';  
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                'CatalogResource' => CatalogResource::class,
                'ModelHasCatalog' => ModelHasCatalogResource::class,
            ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}
