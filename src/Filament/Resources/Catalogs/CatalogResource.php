<?php

declare(strict_types=1);

namespace Mortezaa97\Catalogs\Filament\Resources\Catalogs;

use Mortezaa97\Catalogs\Filament\Resources\Catalogs\Pages\CreateCatalog;
use Mortezaa97\Catalogs\Filament\Resources\Catalogs\Pages\EditCatalog;
use Mortezaa97\Catalogs\Filament\Resources\Catalogs\Pages\ListCatalogs;
use Mortezaa97\Catalogs\Filament\Resources\Catalogs\RelationManagers\ModelHasCatalogsRelationManager;
use Mortezaa97\Catalogs\Filament\Resources\Catalogs\Schemas\CatalogForm;
use Mortezaa97\Catalogs\Filament\Resources\Catalogs\Tables\CatalogsTable;
use Mortezaa97\Catalogs\Models\Catalog;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use BackedEnum;
use UnitEnum;

class CatalogResource extends Resource
{
    protected static ?string $model = Catalog::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $navigationLabel = 'کاتالوگ‌ها';

    protected static ?string $modelLabel = 'کاتالوگ';

    protected static ?string $pluralModelLabel = 'کاتالوگ‌ها';

    protected static string|null|UnitEnum $navigationGroup = 'کاتالوگ';

    public static function form(Schema $schema): Schema
    {
        return CatalogForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CatalogsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            ModelHasCatalogsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCatalogs::route('/'),
            'create' => CreateCatalog::route('/create'),
            'edit' => EditCatalog::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}

