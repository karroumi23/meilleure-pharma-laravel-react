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
use Illuminate\Support\Facades\Storage;

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
                    ->disabled()
                    ->dehydrated()
                    ->required(),

                Forms\Components\FileUpload::make('file')
                    ->label('Ordonnance')
                    ->disk('public')
                    ->directory('prescriptions')
                    ->downloadable()
                    ->openable()
                    ->previewable()
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
                    ->disabled()
                    ->dehydrated(),

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

                Tables\Columns\ImageColumn::make('file')
                    ->label('Fichier')
                    ->disk('public')
                    ->square(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Client')
                    ->searchable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'pending' => 'En attente',
                        'approved' => 'Approuvée',
                        'rejected' => 'Refusée',
                    })
                    ->color(fn (string $state) => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                    }),

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

                Tables\Filters\Filter::make('validated')
                    ->label('Validées')
                    ->query(fn ($query) => $query->whereNotNull('validated_at')),

            ])
            ->actions([

                Tables\Actions\ViewAction::make(),

                Tables\Actions\Action::make('download')
                    ->label('Télécharger')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('info')
                    ->url(fn ($record) => Storage::disk('public')->url($record->file))
                    ->openUrlInNewTab(),

                Tables\Actions\Action::make('approve')
                    ->label('Approuver')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn ($record) => $record->status === 'pending')
                    ->requiresConfirmation()
                    ->action(function ($record) {

                        $record->update([

                            'status' => 'approved',

                            'validated_by' => auth()->id(),

                            'validated_at' => now(),

                        ]);

                    }),

                Tables\Actions\Action::make('reject')
                    ->label('Refuser')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn ($record) => $record->status === 'pending')
                    ->form([

                        Forms\Components\Textarea::make('comment')
                            ->label('Commentaire')
                            ->required(),

                    ])
                    ->action(function ($record, array $data) {

                        $record->update([

                            'status' => 'rejected',

                            'pharmacist_comment' => $data['comment'],

                            'validated_by' => auth()->id(),

                            'validated_at' => now(),

                        ]);

                    }),

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
