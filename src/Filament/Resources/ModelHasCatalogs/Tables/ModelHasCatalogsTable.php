<?php

declare(strict_types=1);

namespace Mortezaa97\Catalogs\Filament\Resources\ModelHasCatalogs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Mortezaa97\Catalogs\Models\Catalog;

class ModelHasCatalogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('catalog.title')
                    ->label('کاتالوگ')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('model_type')
                    ->label('نوع مدل')
                    ->formatStateUsing(function ($state) {
                        return match($state) {
                            'Mortezaa97\\Shop\\Models\\Product' => 'محصول',
                            'App\\Models\\Post' => 'مقاله',
                            'App\\Models\\Page' => 'صفحه',
                            default => class_basename($state),
                        };
                    })
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('model_id')
                    ->label('آیتم')
                    ->formatStateUsing(function ($record) {
                        $modelType = $record->model_type;
                        if (!$modelType || !class_exists($modelType)) {
                            return $record->model_id;
                        }
                        
                        try {
                            $model = $modelType::find($record->model_id);
                            return $model ? ($model->title ?? $model->name ?? $model->id) : $record->model_id;
                        } catch (\Exception $e) {
                            return $record->model_id;
                        }
                    })
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('sort')
                    ->label('ترتیب')
                    ->sortable()
                    ->badge()
                    ->color('info'),
                
                \App\Filament\Components\Table\CreatedAtTextColumn::create(),
                \App\Filament\Components\Table\UpdatedAtTextColumn::create(),
            ])
            ->filters([
                SelectFilter::make('catalog_id')
                    ->label('کاتالوگ')
                    ->relationship('catalog', 'title')
                    ->searchable()
                    ->preload(),
                
                SelectFilter::make('model_type')
                    ->label('نوع مدل')
                    ->options([
                        'Mortezaa97\\Shop\\Models\\Product' => 'محصول',
                        'App\\Models\\Post' => 'مقاله',
                        'App\\Models\\Page' => 'صفحه',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort', 'asc');
    }
}

