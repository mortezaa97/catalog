<?php

declare(strict_types=1);

namespace Mortezaa97\Catalogs\Filament\Resources\Catalogs\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Str;
use Filament\Support\Icons\Icon; // You may need to adjust the import if you use a different icon system.

class CatalogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            \Filament\Schemas\Components\Group::make()
                ->schema([
                    // Collapsable Base Info Section
                    \Filament\Schemas\Components\Section::make('اطلاعات اصلی')
                        ->icon('heroicon-o-information-circle')
                        ->description('مشخصات کلی کاتالوگ را وارد کنید.')
                        ->collapsible()
                        ->schema([
                            \App\Filament\Components\Form\TitleTextInput::create()
                                ->required(),
                            \App\Filament\Components\Form\SlugTextInput::create()
                                ->required(),
                            \App\Filament\Components\Form\DescTinyEditor::create(),
                        ])
                        ->columns(12)
                        ->columnSpan(12),

                    // Collapsable SEO/Page Section
                    \Filament\Schemas\Components\Section::make('سئو و اطلاعات صفحه')
                        ->icon('heroicon-o-chart-bar')
                        ->description('اطلاعات مربوط به نمایش صفحه و سئو را وارد کنید.')
                        ->collapsible()
                        ->schema([
                            \App\Filament\Components\Form\PageTitleTextInput::create(),
                            \App\Filament\Components\Form\MetaTitleTextInput::create(),
                            \App\Filament\Components\Form\MetaDescTextarea::create(),
                            \App\Filament\Components\Form\MetaKeywordsTagsInput::create(),
                        ])
                        ->columns(12)
                        ->columnSpan(12),
                ])
                ->columns(12)
                ->columnSpan(8),

            \Filament\Schemas\Components\Group::make()
                ->schema([
                    \Filament\Schemas\Components\Section::make()
                        ->schema([
                            \App\Filament\Components\Form\ImageFileUpload::create(),
                            \App\Filament\Components\Form\StatusSelect::create(\Mortezaa97\Catalogs\Models\Catalog::class)
                                ->required(),
                            \App\Filament\Components\Form\CreatedBySelect::create()
                                ->required(),
                            \App\Filament\Components\Form\UpdatedBySelect::create(),
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

