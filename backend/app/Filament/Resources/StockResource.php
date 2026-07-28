<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StockResource\Pages;
use App\Models\Medicine;
use App\Models\Stock;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class StockResource extends Resource
{
    protected static ?string $model = Stock::class;

    protected static ?string $navigationIcon='heroicon-o-cube';

    protected static ?string $navigationLabel = 'Stock';

    protected static ?string $pluralModelLabel = 'Stock';

    protected static ?string $modelLabel = 'Mouvement';

    protected static ?string $navigationGroup='Gestion du Stock';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Select::make('medicine_id')
                    ->label('Médicament')
                    ->relationship('medicine', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\Select::make('type')
                    ->label('Type de mouvement')
                    ->options([
                        'entry' => '📥 Entrée',
                        'exit' => '📤 Sortie',
                        'adjustment' => '⚖️ Ajustement',
                    ])
                    ->required(),

                Forms\Components\TextInput::make('quantity')
                    ->label('Quantité')
                    ->numeric()
                    ->required()
                    ->minValue(1),

                Forms\Components\TextInput::make('reference')
                    ->label('Référence'),

                Forms\Components\Textarea::make('note')
                    ->label('Note')
                    ->rows(4),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table

            ->columns([

                Tables\Columns\TextColumn::make('medicine.name')
                    ->label('Médicament')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('type')
                    ->label('Type')
                    ->colors([
                        'success' => 'entry',
                        'danger' => 'exit',
                        'warning' => 'adjustment',
                    ])
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'entry' => '📥 Entrée',
                        'exit' => '📤 Sortie',
                        'adjustment' => '⚖️ Ajustement',
                    }),

                Tables\Columns\TextColumn::make('quantity')
                    ->label('Quantité')
                    ->sortable(),

                Tables\Columns\TextColumn::make('reference')
                    ->label('Référence'),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Utilisateur')
                    ->default('-'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

            ])

            ->filters([

                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'entry' => 'Entrée',
                        'exit' => 'Sortie',
                        'adjustment' => 'Ajustement',
                    ]),

            ])

            ->actions([

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

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStocks::route('/'),
            'create' => Pages\CreateStock::route('/create'),
            'edit' => Pages\EditStock::route('/{record}/edit'),
        ];
    }
}