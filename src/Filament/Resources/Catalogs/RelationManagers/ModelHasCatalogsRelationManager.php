<?php

declare(strict_types=1);

namespace Mortezaa97\Catalogs\Filament\Resources\Catalogs\RelationManagers;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\CreateAction;

class ModelHasCatalogsRelationManager extends RelationManager
{
    protected static string $relationship = 'modelHasCatalogs';

    protected static ?string $recordTitleAttribute = 'model_id';

    protected static ?string $title = 'آیتم‌های کاتالوگ';

    protected static ?string $modelLabel = 'آیتم کاتالوگ';

    protected static ?string $pluralModelLabel = 'آیتم‌های کاتالوگ';

    protected array $selectableOptions = [];

    // Helper to sanitize option arrays to ensure no null label
    protected static function sanitizeOptions(array $options): array
    {
        foreach ($options as $id => $label) {
            if ($label === null) {
                $options[$id] = (string)$id;
            }
        }
        return $options;
    }

    public static function getProductOptions(): array
    {
        $modelType = 'Mortezaa97\Shop\Models\Product';
        if (!class_exists($modelType)) {
            return [];
        }
        
        // Try to get products and map their display name
        $products = $modelType::query()
            ->limit(1000)
            ->whereNull('parent_id')
            ->get();
        
        $options = [];
        foreach ($products as $product) {
            $name = $product->title ?? $product->name ?? $product->id;
            $options[$product->id] = $name;
        }
        
        // Sort by name
        asort($options);
        
        return self::sanitizeOptions($options);
    }

    public static function getPostOptions(): array
    {
        $modelType = 'App\Models\Post';
        if (!class_exists($modelType)) {
            return [];
        }
        $titleField = method_exists($modelType, 'getTitleAttribute') ? 'title' : 'name';
        $options = $modelType::query()
            ->select('id', $titleField)
            ->orderBy($titleField)
            ->limit(1000) // Limit for performance
            ->pluck($titleField, 'id')
            ->toArray();
        return self::sanitizeOptions($options);
    }

    public static function getPageOptions(): array
    {
        $modelType = 'App\Models\Page';
        if (!class_exists($modelType)) {
            return [];
        }
        $titleField = method_exists($modelType, 'getTitleAttribute') ? 'title' : 'name';
        $options = $modelType::query()
            ->select('id', $titleField)
            ->orderBy($titleField)
            ->limit(1000) // Limit for performance
            ->pluck($titleField, 'id')
            ->toArray();
        return self::sanitizeOptions($options);
    }

    public static function formProduct(Schema $schema): Schema
    {
        return $schema->components([
            \Filament\Schemas\Components\Group::make()
                ->schema([
                    \Filament\Schemas\Components\Section::make('افزودن محصول به کاتالوگ')
                        ->description('یک یا چند محصول را به کاتالوگ اضافه کنید')
                        ->schema([
                            Select::make('model_ids')
                                ->label('محصولات')
                                ->options(fn () => self::getProductOptions())
                                ->getSearchResultsUsing(function (string $search) {
                                    $modelType = 'Mortezaa97\Shop\Models\Product';
                                    if (!class_exists($modelType)) {
                                        return [];
                                    }
                                    
                                    $products = $modelType::query()
                                        ->where(function ($query) use ($search) {
                                            $query->Where('name', 'like', "%{$search}%");
                                        })
                                        ->whereNull('parent_id')
                                        ->limit(50)
                                        ->get();
                                    
                                    $options = [];
                                    foreach ($products as $product) {
                                        $name = $product->title ?? $product->name ?? $product->id;
                                        $options[$product->id] = $name;
                                    }
                                    
                                    return $options;
                                })
                                ->getOptionLabelsUsing(function (array $values): array {
                                    $modelType = 'Mortezaa97\Shop\Models\Product';
                                    if (!class_exists($modelType)) {
                                        return [];
                                    }
                                    
                                    $products = $modelType::query()
                                        ->whereIn('id', $values)
                                        ->whereNull('parent_id')
                                        ->get();
                                    
                                    $options = [];
                                    foreach ($products as $product) {
                                        $name = $product->title ?? $product->name ?? $product->id;
                                        $options[$product->id] = $name;
                                    }
                                    
                                    return $options;
                                })
                                ->searchable()
                                ->required()
                                ->multiple()
                                ->preload()
                                ->columnSpan(12)
                                ->placeholder('محصولات موردنظر را انتخاب کنید')
                                ->helperText('می‌توانید چند محصول را همزمان انتخاب کنید'),
                        ])
                        ->columns(12)
                        ->columnSpan(12),
                ])
                ->columns(12)
                ->columnSpan(12)
        ])
        ->columns(12);
    }

    public static function formPost(Schema $schema): Schema
    {
        return $schema->components([
            \Filament\Schemas\Components\Group::make()
                ->schema([
                    \Filament\Schemas\Components\Section::make('افزودن مقاله به کاتالوگ')
                        ->description('یک یا چند مقاله را به کاتالوگ اضافه کنید')
                        ->schema([
                            Select::make('model_ids')
                                ->label('مقالات')
                                ->options(fn () => self::getPostOptions())
                                ->getSearchResultsUsing(function (string $search) {
                                    $modelType = 'App\Models\Post';
                                    if (!class_exists($modelType)) {
                                        return [];
                                    }
                                    $titleField = 'title';
                                    return $modelType::query()
                                        ->where($titleField, 'like', "%{$search}%")
                                        ->limit(50)
                                        ->pluck($titleField, 'id')
                                        ->toArray();
                                })
                                ->getOptionLabelsUsing(function (array $values): array {
                                    $modelType = 'App\Models\Post';
                                    if (!class_exists($modelType)) {
                                        return [];
                                    }
                                    $titleField = 'title';
                                    return $modelType::query()
                                        ->whereIn('id', $values)
                                        ->pluck($titleField, 'id')
                                        ->toArray();
                                })
                                ->searchable()
                                ->required()
                                ->multiple()
                                ->preload()
                                ->columnSpan(12)
                                ->placeholder('مقالات موردنظر را انتخاب کنید')
                                ->helperText('می‌توانید چند مقاله را همزمان انتخاب کنید'),
                        ])
                        ->columns(12)
                        ->columnSpan(12),
                ])
                ->columns(12)
                ->columnSpan(12)
        ])
        ->columns(12);
    }

    public static function formPage(Schema $schema): Schema
    {
        return $schema->components([
            \Filament\Schemas\Components\Group::make()
                ->schema([
                    \Filament\Schemas\Components\Section::make('افزودن صفحه به کاتالوگ')
                        ->description('یک یا چند صفحه را به کاتالوگ اضافه کنید')
                        ->schema([
                            Select::make('model_ids')
                                ->label('صفحات')
                                ->options(fn () => self::getPageOptions())
                                ->getSearchResultsUsing(function (string $search) {
                                    $modelType = 'App\Models\Page';
                                    if (!class_exists($modelType)) {
                                        return [];
                                    }
                                    $titleField = 'title';
                                    return $modelType::query()
                                        ->where($titleField, 'like', "%{$search}%")
                                        ->limit(50)
                                        ->pluck($titleField, 'id')
                                        ->toArray();
                                })
                                ->getOptionLabelsUsing(function (array $values): array {
                                    $modelType = 'App\Models\Page';
                                    if (!class_exists($modelType)) {
                                        return [];
                                    }
                                    $titleField = 'title';
                                    return $modelType::query()
                                        ->whereIn('id', $values)
                                        ->pluck($titleField, 'id')
                                        ->toArray();
                                })
                                ->searchable()
                                ->required()
                                ->multiple()
                                ->preload()
                                ->columnSpan(12)
                                ->placeholder('صفحات موردنظر را انتخاب کنید')
                                ->helperText('می‌توانید چند صفحه را همزمان انتخاب کنید'),
                        ])
                        ->columns(12)
                        ->columnSpan(12),
                ])
                ->columns(12)
                ->columnSpan(12)
        ])
        ->columns(12);
    }

    /**
     * Default form (still for EditAction)
     */
    public function form(Schema $schema): Schema
    {
        return $schema->components([
            \Filament\Schemas\Components\Group::make()
                ->schema([
                    \Filament\Schemas\Components\Section::make('افزودن آیتم به کاتالوگ')
                        ->description('مدل مورد نظر را به این کاتالوگ اضافه کنید')
                        ->schema([
                            Select::make('model_type')
                                ->label('نوع مدل')
                                ->options([
                                    'Mortezaa97\\Shop\\Models\\Product' => 'محصول',
                                    'App\\Models\\Post' => 'مقاله',
                                    'App\\Models\\Page' => 'صفحه',
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
                                    $titleField = method_exists($modelType, 'getTitleAttribute') ? 'title' : 'name';
                                    $options = $modelType::query()->pluck($titleField, 'id')->toArray();
                                    // Sanitize to ensure no label is null
                                    foreach ($options as $id => $label) {
                                        if ($label === null) {
                                            $options[$id] = (string)$id;
                                        }
                                    }
                                    return $options;
                                })
                                ->searchable()
                                ->required()
                                ->columnSpan(6)
                                ->placeholder('ابتدا نوع مدل را انتخاب کنید')
                                ->disabled(fn (callable $get) => !$get('model_type')),
                        ])
                        ->columns(12)
                        ->columnSpan(12),
                ])
                ->columns(12)
                ->columnSpan(12),
        ])
        ->columns(12);
    }

    public function table(Table $table): Table
    {
        return $table
            ->reorderable('sort')
            ->columns([
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
                            // Cast to string if both title/name are not present (null), fallback to id
                            return $model ? ((isset($model->title) && $model->title !== null) ? $model->title : ((isset($model->name) && $model->name !== null) ? $model->name : (string) $model->id)) : (string) $record->model_id;
                        } catch (\Exception $e) {
                            return (string) $record->model_id;
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
                \Filament\Tables\Filters\SelectFilter::make('model_type')
                    ->label('نوع مدل')
                    ->options([
                        'Mortezaa97\\Shop\\Models\\Product' => 'محصول',
                        'App\\Models\\Post' => 'مقاله',
                        'App\\Models\\Page' => 'صفحه',
                    ]),
            ])
            ->headerActions([
                CreateAction::make('add_product')
                    ->label('افزودن محصول')
                    ->icon('heroicon-o-plus')
                    ->using(function (array $data, RelationManager $livewire) {
                        $modelIds = $data['model_ids'] ?? [];
                        $maxSort = $livewire->getRelationship()->max('sort') ?? -1;
                        
                        $created = [];
                        foreach ($modelIds as $modelId) {
                            $maxSort++;
                            $created[] = $livewire->getRelationship()->create([
                                'model_type' => 'Mortezaa97\Shop\Models\Product',
                                'model_id' => $modelId,
                                'sort' => $maxSort,
                            ]);
                        }
                        
                        return $created[0] ?? null;
                    })
                    ->successNotificationTitle('محصولات با موفقیت اضافه شدند')
                    ->schema(fn (Schema $schema) => self::formProduct($schema)),

                CreateAction::make('add_post')
                    ->label('افزودن مقاله')
                    ->icon('heroicon-o-plus')
                    ->using(function (array $data, RelationManager $livewire) {
                        $modelIds = $data['model_ids'] ?? [];
                        $maxSort = $livewire->getRelationship()->max('sort') ?? -1;
                        
                        $created = [];
                        foreach ($modelIds as $modelId) {
                            $maxSort++;
                            $created[] = $livewire->getRelationship()->create([
                                'model_type' => 'App\Models\Post',
                                'model_id' => $modelId,
                                'sort' => $maxSort,
                            ]);
                        }
                        
                        return $created[0] ?? null;
                    })
                    ->successNotificationTitle('مقالات با موفقیت اضافه شدند')
                    ->schema(fn (Schema $schema) => self::formPost($schema)),

                CreateAction::make('add_page')
                    ->label('افزودن صفحه')
                    ->icon('heroicon-o-plus')
                    ->using(function (array $data, RelationManager $livewire) {
                        $modelIds = $data['model_ids'] ?? [];
                        $maxSort = $livewire->getRelationship()->max('sort') ?? -1;
                        
                        $created = [];
                        foreach ($modelIds as $modelId) {
                            $maxSort++;
                            $created[] = $livewire->getRelationship()->create([
                                'model_type' => 'App\Models\Page',
                                'model_id' => $modelId,
                                'sort' => $maxSort,
                            ]);
                        }
                        
                        return $created[0] ?? null;
                    })
                    ->successNotificationTitle('صفحات با موفقیت اضافه شدند')
                    ->schema(fn (Schema $schema) => self::formPage($schema)),
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
