<?php

declare(strict_types=1);

namespace Mortezaa97\Catalogs\Filament\Resources\Catalogs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class CatalogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \App\Filament\Components\Table\ImageImageColumn::create(),
                \App\Filament\Components\Table\TitleTextColumn::create(),
                \App\Filament\Components\Table\SlugTextColumn::create(),
                \App\Filament\Components\Table\OrderTextColumn::create(),
                \App\Filament\Components\Table\StatusTextColumn::create(\Mortezaa97\Catalogs\Models\Catalog::class),
                \App\Filament\Components\Table\PageTitleTextColumn::create(),
                \App\Filament\Components\Table\MetaTitleTextColumn::create(),
                \App\Filament\Components\Table\MetaKeywordsTextColumn::create(),
                \App\Filament\Components\Table\CreatedByTextColumn::create(),
                \App\Filament\Components\Table\UpdatedByTextColumn::create(),
                \App\Filament\Components\Table\DeletedAtTextColumn::create(),
                \App\Filament\Components\Table\CreatedAtTextColumn::create(),
                \App\Filament\Components\Table\UpdatedAtTextColumn::create(),
            ])
            ->reorderable('order_id')
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}

