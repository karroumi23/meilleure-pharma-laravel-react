<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use App\Models\User;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Resources\BaseResource;

class OrderResource extends BaseResource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationLabel = 'Commandes';

    protected static ?string $pluralModelLabel = 'Commandes';

    protected static ?string $modelLabel = 'Commande';

    protected static ?string $navigationGroup = '🛒 Commandes';

    protected static ?int $navigationSort = 1;

    protected static array $allowedRoles = [
        'Administrator',
        'Pharmacist',
    ];

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Section::make('Informations de la commande')
                    ->columns(2)
                    ->schema([

                        Forms\Components\Select::make('user_id')
                            ->label('Client')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->required(),

                        Forms\Components\TextInput::make('order_number')
                            ->label('N° Commande')
                            ->required(),

                        Forms\Components\TextInput::make('phone')
                            ->label('Téléphone')
                            ->tel()
                            ->required(),

                        Forms\Components\TextInput::make('city')
                            ->label('Ville')
                            ->required(),

                        Forms\Components\Textarea::make('address')
                            ->label('Adresse')
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('note')
                            ->label('Note')
                            ->columnSpanFull(),

                    ]),

                Forms\Components\Section::make('Paiement')
                    ->columns(3)
                    ->schema([

                        Forms\Components\TextInput::make('subtotal')
                            ->numeric()
                            ->prefix('DH'),

                        Forms\Components\TextInput::make('shipping_cost')
                            ->numeric()
                            ->prefix('DH'),

                        Forms\Components\TextInput::make('discount')
                            ->numeric()
                            ->prefix('DH'),

                        Forms\Components\TextInput::make('total')
                            ->numeric()
                            ->prefix('DH')
                            ->required(),

                        Forms\Components\Select::make('payment_status')
                            ->label('Paiement')
                            ->options([
                                'unpaid'=>'Non payé',
                                'paid'=>'Payé',
                                'refunded'=>'Remboursé',
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('payment_method')
                            ->label('Méthode'),

                    ]),

                Forms\Components\Section::make('Statut')
                    ->columns(3)
                    ->schema([

                        Forms\Components\Select::make('status')
                            ->options([
                                'pending'=>'En attente',
                                'confirmed'=>'Confirmée',
                                'preparing'=>'Préparation',
                                'shipped'=>'Expédiée',
                                'delivered'=>'Livrée',
                                'cancelled'=>'Annulée',
                            ])
                            ->required(),

                        Forms\Components\DateTimePicker::make('ordered_at')
                            ->label('Commandée le'),

                        Forms\Components\DateTimePicker::make('delivered_at')
                            ->label('Livrée le'),

                    ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('order_number')
                    ->label('Commande')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Client')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('total')
                    ->label('Montant')
                    ->money('MAD')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'En attente',
                        'confirmed' => 'Confirmée',
                        'preparing' => 'Préparation',
                        'shipped' => 'Expédiée',
                        'delivered' => 'Livrée',
                        'cancelled' => 'Annulée',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'confirmed' => 'info',
                        'preparing' => 'gray',
                        'shipped' => 'primary',
                        'delivered' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('payment_status')
                    ->label('Paiement')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'unpaid' => 'Non payé',
                        'paid' => 'Payé',
                        'refunded' => 'Remboursé',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'paid' => 'success',
                        'unpaid' => 'danger',
                        'refunded' => 'warning',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('ordered_at')
                    ->label('Date')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

            ])

            ->filters([

                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'En attente',
                        'confirmed' => 'Confirmée',
                        'preparing' => 'Préparation',
                        'shipped' => 'Expédiée',
                        'delivered' => 'Livrée',
                        'cancelled' => 'Annulée',
                    ]),

                Tables\Filters\SelectFilter::make('payment_status')
                    ->options([
                        'paid' => 'Payé',
                        'unpaid' => 'Non payé',
                        'refunded' => 'Remboursé',
                    ]),

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

            ])

            ->defaultSort('id', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}