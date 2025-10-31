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

class CatalogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            \Filament\Schemas\Components\Group::make()
                ->schema([
                    \Filament\Schemas\Components\Section::make()
                        ->schema([
                            \App\Filament\Components\Form\TitleTextInput::create()
                                ->required(),
                            \App\Filament\Components\Form\SlugTextInput::create()
                                ->required(),
                            \App\Filament\Components\Form\DescTextarea::create(),
                            \App\Filament\Components\Form\PageTitleTextInput::create(),
                            \App\Filament\Components\Form\MetaTitleTextInput::create(),
                            \App\Filament\Components\Form\MetaDescTextarea::create(),
                            \App\Filament\Components\Form\MetaKeywordsTagsInput::create(),
                            \App\Filament\Components\Form\OrderTextInput::create()
                                ->required(),
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
                ->columnSpan(8),
            \Filament\Schemas\Components\Group::make()
                ->schema([
                    \Filament\Schemas\Components\Section::make()
                        ->schema([])
                        ->columns(12)
                        ->columnSpan(12),
                ])
                ->columns(12)
                ->columnSpan(4),
        ])
            ->columns(12);
    }
}

