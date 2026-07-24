<?php

namespace App\Filament\Resources;
// --------------
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Set;
use Filament\Forms\Get;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;

use Illuminate\Support\Str;
// -------------
use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationLabel = 'Catégories';

    protected static ?string $pluralModelLabel = 'Catégories';

    protected static ?string $modelLabel = 'Catégorie';

    protected static ?string $navigationGroup = 'Catalogue';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
    public static function form(Form $form): Form
    {
        return $form
      ->schema([

        TextInput::make('name')
            ->label('Nom')
            ->required()
            ->live(onBlur: true)
            ->afterStateUpdated(fn(Set $set, ?string $state) =>
                $set('slug', Str::slug($state))
            ),

        TextInput::make('slug')
            ->label('Slug')
            ->required()
            ->unique(ignoreRecord: true),

        Textarea::make('description')
            ->label('Description')
            ->rows(4)
            ->columnSpanFull(),

        FileUpload::make('image')
            ->label('Image')
            ->directory('categories')
            ->image()
            ->imageEditor(),

        Toggle::make('is_active')
            ->label('Catégorie active')
            ->default(true),

    ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([

            ImageColumn::make('image')
                ->label('Image')
                ->circular(),

            TextColumn::make('name')
                ->label('Nom')
                ->searchable()
                ->sortable(),

            TextColumn::make('slug')
                ->searchable()
                ->copyable(),

            IconColumn::make('is_active')
                ->label('Statut')
                ->boolean(),

            TextColumn::make('created_at')
                ->label('Créée le')
                ->date('d/m/Y')
                ->sortable(),

        ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
