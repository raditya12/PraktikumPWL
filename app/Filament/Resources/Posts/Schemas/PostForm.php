<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;
use Filament\Schemas\Components\Group;
use App\Models\Category;


class PostForm
{
public static function configure(Schema $schema): Schema
{
    return $schema
        ->components([
            // Main fields (Left, 2/3)
            Section::make("Post Details")
                ->description("Fill in the details of the post")
                ->icon('heroicon-o-pencil-square')
                ->schema([
                    TextInput::make("title")
                        ->rules('required | min:3 | max:10'),
                    TextInput::make("slug")
                        ->rules('required')
                        ->unique()
                        ->validationMessages([
                            "unique" => "Slug must be unique"
                        ]),
                    Select::make("category_id")
                        ->relationship("category", "name")
                        ->required()
                        ->preload()
                        ->searchable(),
                    ColorPicker::make('color'),
                    MarkdownEditor::make('content')
                        ->columnSpanFull(),
                ])
                ->columns(2)
                ->columnSpan(2),

            // Meta fields (Right, 1/3)
            Group::make([
                Section::make("Image Upload")
                    ->icon('heroicon-o-photo')
                    ->schema([
                        FileUpload::make("image")
                            ->required()
                            ->disk("public")
                            ->directory("posts"),
                    ]),

                Section::make("Meta Information")
                    ->icon('heroicon-o-cloud-arrow-up')
                    ->schema([
                        TagsInput::make("tags"),
                        Checkbox::make("published"),
                        DatePicker::make("published_at"),
                    ]),
            ])->columnSpan(1),

        ])->columns(3);
}
}