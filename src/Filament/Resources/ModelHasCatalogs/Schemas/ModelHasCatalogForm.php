<?php

declare(strict_types=1);

namespace Mortezaa97\Catalogs\Filament\Resources\ModelHasCatalogs\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MorphToSelect;
use Filament\Schemas\Schema;
use Mortezaa97\Catalogs\Models\Catalog;

class ModelHasCatalogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            \Filament\Schemas\Components\Group::make()
                ->schema([
                    \Filament\Schemas\Components\Section::make('افزودن آیتم به کاتالوگ')
                        ->description('یک کاتالوگ انتخاب کنید و سپس مدل مورد نظر را به آن اضافه کنید')
                        ->schema([
                            Select::make('catalog_id')
                                ->label('کاتالوگ')
                                ->relationship('catalog', 'title')
                                ->searchable()
                                ->preload()
                                ->required()
                                ->columnSpan(6)
                                ->placeholder('کاتالوگ مورد نظر را انتخاب کنید'),
                            
                            Select::make('model_type')
                                ->label('نوع مدل')
                                ->options([
                                    'Mortezaa97\\Shop\\Models\\Product' => 'محصول',
                                    'App\\Models\\Post' => 'مقاله',
                                    'App\\Models\\Page' => 'صفحه',
                                    // Add more model types as needed
                                ])
                                ->searchable()
                                ->required()
                                ->live()
                                ->columnSpan(6)
                                ->placeholder('نوع مدل را انتخاب کنید'),
                            
                            Select::make('model_id')
                                ->label('آیتم')
                                ->options(function (callable $get) {
                                    $modelType = $get('model_type');
                                    if (!$modelType || !class_exists($modelType)) {
                                        return [];
                                    }
                                    
                                    // Get the title field based on model type
                                    $titleField = 'title';
                                    if (method_exists($modelType, 'getTitleAttribute')) {
                                        $titleField = 'title';
                                    }
                                    
                                    return $modelType::query()
                                        ->pluck($titleField, 'id')
                                        ->toArray();
                                })
                                ->searchable()
                                ->required()
                                ->columnSpan(6)
                                ->placeholder('ابتدا نوع مدل را انتخاب کنید')
                                ->disabled(fn (callable $get) => !$get('model_type')),
                            
                            TextInput::make('sort')
                                ->label('ترتیب نمایش')
                                ->numeric()
                                ->default(0)
                                ->required()
                                ->columnSpan(6)
                                ->helperText('عدد کوچکتر در اولویت نمایش قرار می‌گیرد'),
                        ])
                        ->columns(12)
                        ->columnSpan(12),
                ])
                ->columns(12)
                ->columnSpan(8),
            \Filament\Schemas\Components\Group::make()
                ->schema([
                    \Filament\Schemas\Components\Section::make('راهنما')
                        ->schema([
                        ])
                        ->columns(12)
                        ->columnSpan(12),
                ])
                ->columns(12)
                ->columnSpan(4),
        ])
            ->columns(12);
    }
}

