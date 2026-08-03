<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MedicineResource\Pages;
use App\Models\Medicine;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Resources\BaseResource;


use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;

class MedicineResource extends BaseResource
{
    protected static ?string $model = Medicine::class;

    protected static ?string $navigationIcon='heroicon-o-beaker';

    protected static ?string $navigationLabel = 'Médicaments';

    protected static ?string $pluralModelLabel = 'Médicaments';

    protected static ?string $modelLabel = 'Médicament';

    protected static ?string $navigationGroup = '📦 Catalogue';

    protected static ?int $navigationSort = 3;

    protected static array $allowedRoles = [
        'Administrator',
        'Pharmacist',
    ];

    // ---------form
    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Section::make('Informations')
                    ->columns(2)
                    ->schema([

                        Forms\Components\TextInput::make('name')
                            ->label('Nom')
                            ->required()
                            ->live(onBlur: true),


                        Forms\Components\Select::make('category_id')
                            ->label('Catégorie')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\Select::make('brand_id')
                            ->label('Marque')
                            ->relationship('brand', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),


                        Forms\Components\TextInput::make('barcode')
                            ->label('Code Barre'),

                        Forms\Components\TextInput::make('dosage')
                            ->label('Dosage'),

                        Forms\Components\FileUpload::make('image')
                            ->disk('public')
                            ->directory('medicines')
                            ->image()
                            ->imageEditor(),

                    ]),

                Forms\Components\Section::make('Prix')
                    ->columns(2)
                    ->schema([

                        Forms\Components\TextInput::make('price')
                            ->numeric()
                            ->required(),

                        Forms\Components\TextInput::make('sale_price')
                            ->numeric(),

                    ]),

                        Forms\Components\Section::make('Stock')
                            ->columns(3)
                            ->schema([

                        Forms\Components\TextInput::make('stock')
                            ->numeric()
                            ->default(0),

                        Forms\Components\TextInput::make('minimum_stock')
                            ->numeric()
                            ->default(5),

                        Forms\Components\DatePicker::make('expiry_date')
                            ->label("Date d'expiration"),

                    ]),

                Forms\Components\Section::make('Options')
                    ->columns(3)
                    ->schema([

                        Forms\Components\Toggle::make('requires_prescription')
                            ->label('Ordonnance'),

                        Forms\Components\Toggle::make('featured')
                            ->label('Vedette'),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Actif')
                            ->default(true),

                    ]),

                Forms\Components\Textarea::make('description')
                    ->label('Description')
                    ->rows(5),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\ImageColumn::make('image')
                    ->label('')
                    ->disk('public')
                    ->circular()
                    ->size(50),

                Tables\Columns\TextColumn::make('name')
                    ->label('Médicament')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Catégorie')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('brand.name')
                    ->label('Marque')
                    ->badge(),

                Tables\Columns\TextColumn::make('price')
                    ->label('Prix')
                    ->suffix(' DH')
                    ->sortable(),

                Tables\Columns\TextColumn::make('stock')
                    ->label('Stock')
                    ->badge()
                    ->color(fn ($state) => match (true) {
                        $state <= 5 => 'danger',
                        $state <= 20 => 'warning',
                        default => 'success',
                    }),

                Tables\Columns\IconColumn::make('featured')
                    ->label('Vedette')
                    ->boolean(),

                Tables\Columns\IconColumn::make('requires_prescription')
                    ->label('Ordonnance')
                    ->boolean(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Actif')
                    ->boolean(),

            ])

            ->filters([

                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name')
                    ->label('Catégorie'),

                Tables\Filters\SelectFilter::make('brand')
                    ->relationship('brand', 'name')
                    ->label('Marque'),

                Tables\Filters\TernaryFilter::make('featured')
                    ->label('Vedette'),

                Tables\Filters\TernaryFilter::make('requires_prescription')
                    ->label('Ordonnance'),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Actif'),

            ])

            ->actions([

                Tables\Actions\ViewAction::make(),

                Tables\Actions\EditAction::make(),

                Tables\Actions\DeleteAction::make(),

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
            'index' => Pages\ListMedicines::route('/'),
            'create' => Pages\CreateMedicine::route('/create'),
            'edit' => Pages\EditMedicine::route('/{record}/edit'),
        ];
    }
}
