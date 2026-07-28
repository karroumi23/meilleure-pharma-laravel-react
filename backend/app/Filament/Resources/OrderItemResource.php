<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderItemResource\Pages;
use App\Models\OrderItem;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrderItemResource extends Resource
{
    protected static ?string $model = OrderItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';

    protected static ?string $navigationLabel = 'Lignes Commandes';

    protected static ?string $pluralModelLabel = 'Lignes Commandes';

    protected static ?string $modelLabel = 'Ligne Commande';

    protected static ?string $navigationGroup = '🛒 Commandes';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Select::make('order_id')
                    ->relationship('order', 'order_number')
                    ->searchable()
                    ->required(),

                Forms\Components\Select::make('medicine_id')
                    ->relationship('medicine', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\TextInput::make('quantity')
                    ->numeric()
                    ->default(1)
                    ->required(),

                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->required(),

                Forms\Components\TextInput::make('subtotal')
                    ->numeric()
                    ->disabled()
                    ->dehydrated(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('order.order_number')
                    ->label('Commande')
                    ->searchable(),

                Tables\Columns\TextColumn::make('medicine.name')
                    ->label('Médicament')
                    ->searchable(),

                Tables\Columns\TextColumn::make('quantity')
                    ->label('Qté'),

                Tables\Columns\TextColumn::make('price')
                    ->label('Prix')
                    ->money('MAD'),

                Tables\Columns\TextColumn::make('subtotal')
                    ->label('Sous Total')
                    ->money('MAD'),

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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrderItems::route('/'),
            'create' => Pages\CreateOrderItem::route('/create'),
            'edit' => Pages\EditOrderItem::route('/{record}/edit'),
        ];
    }
}