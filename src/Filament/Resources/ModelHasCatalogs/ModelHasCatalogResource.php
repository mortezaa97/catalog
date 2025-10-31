<?php

declare(strict_types=1);

namespace Mortezaa97\Catalogs\Filament\Resources\ModelHasCatalogs;

use Mortezaa97\Catalogs\Filament\Resources\ModelHasCatalogs\Pages\CreateModelHasCatalog;
use Mortezaa97\Catalogs\Filament\Resources\ModelHasCatalogs\Pages\EditModelHasCatalog;
use Mortezaa97\Catalogs\Filament\Resources\ModelHasCatalogs\Pages\ListModelHasCatalogs;
use Mortezaa97\Catalogs\Filament\Resources\ModelHasCatalogs\Schemas\ModelHasCatalogForm;
use Mortezaa97\Catalogs\Filament\Resources\ModelHasCatalogs\Tables\ModelHasCatalogsTable;
use Mortezaa97\Catalogs\Models\ModelHasCatalog;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use BackedEnum;
use UnitEnum;

class ModelHasCatalogResource extends Resource
{
    protected static ?string $model = ModelHasCatalog::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedLink;

    protected static ?string $navigationLabel = 'مدیریت آیتم‌های کاتالوگ';

    protected static ?string $modelLabel = 'آیتم کاتالوگ';

    protected static ?string $pluralModelLabel = 'آیتم‌های کاتالوگ';

    protected static string|null|UnitEnum $navigationGroup = 'کاتالوگ';

    public static function form(Schema $schema): Schema
    {
        return ModelHasCatalogForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ModelHasCatalogsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListModelHasCatalogs::route('/'),
            'create' => CreateModelHasCatalog::route('/create'),
            'edit' => EditModelHasCatalog::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([]);
    }
}

