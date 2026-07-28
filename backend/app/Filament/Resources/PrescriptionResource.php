<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PrescriptionResource\Pages;
use App\Filament\Resources\PrescriptionResource\RelationManagers;
use App\Models\Prescription;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PrescriptionResource extends Resource
{
    protected static ?string $model = Prescription::class;

protected static ?string $navigationIcon = 'heroicon-o-document-text';

protected static ?string $navigationGroup = '📋 Ordonnances';

protected static ?string $navigationLabel = 'Ordonnances';

protected static ?string $pluralModelLabel = 'Ordonnances';

protected static ?string $modelLabel = 'Ordonnance';

protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Select::make('user_id')
                    ->label('Client')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Forms\Components\TextInput::make('reference')
                    ->label('Référence')
                    ->required()
                    ->maxLength(255),

                Forms\Components\FileUpload::make('file')
                    ->label('Ordonnance')
                    ->disk('public')
                    ->directory('prescriptions')
                    ->acceptedFileTypes([
                        'application/pdf',
                        'image/jpeg',
                        'image/png',
                        'image/webp',
                    ])
                    ->required(),

                Forms\Components\Select::make('status')
                    ->label('Statut')
                    ->options([
                        'pending' => 'En attente',
                        'approved' => 'Approuvée',
                        'rejected' => 'Refusée',
                    ])
                    ->default('pending')
                    ->required(),

                Forms\Components\Textarea::make('pharmacist_comment')
                    ->label('Commentaire du pharmacien')
                    ->rows(4),

                Forms\Components\Select::make('validated_by')
                    ->label('Validée par')
                    ->relationship('validator', 'name')
                    ->searchable(),

                Forms\Components\DateTimePicker::make('validated_at')
                    ->label('Date de validation'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('reference')
                    ->label('Référence')
                    ->searchable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Client')
                    ->searchable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ]),

                Tables\Columns\TextColumn::make('validator.name')
                    ->label('Pharmacien'),

                Tables\Columns\TextColumn::make('validated_at')
                    ->label('Validation')
                    ->dateTime('d/m/Y H:i'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Créée le')
                    ->date('d/m/Y'),

            ])
            ->filters([

                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'En attente',
                        'approved' => 'Approuvée',
                        'rejected' => 'Refusée',
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
            'index' => Pages\ListPrescriptions::route('/'),
            'create' => Pages\CreatePrescription::route('/create'),
            'edit' => Pages\EditPrescription::route('/{record}/edit'),
        ];
    }
}
