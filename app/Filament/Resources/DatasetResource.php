<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DatasetResource\Pages;
use App\Filament\Resources\DatasetResource\RelationManagers;
use App\Models\Dataset;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DatasetResource extends Resource
{
    protected static ?string $model = Dataset::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\Textarea::make('description')->required(),
                Forms\Components\Select::make('skill_id')->relationship('skill', 'name'),
                Forms\Components\Select::make('industry_id')->relationship('industry', 'name'),
                Forms\Components\Select::make('year_id')->relationship('year', 'year'),
                Forms\Components\Toggle::make('is_approved')->label('Approved'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('description')->limit(50),
                Tables\Columns\TextColumn::make('skill.name'),
                Tables\Columns\TextColumn::make('industry.name'),
                Tables\Columns\TextColumn::make('year.year'),
                Tables\Columns\IconColumn::make('is_approved')
                    ->boolean()
                    ->label('Approved')
                    ->sortable(),
                Tables\Columns\TextColumn::make('approved_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('approver.name')
                    ->label('Approved By'),
            ])
            ->filters([
                Tables\Filters\Filter::make('pending')
                    ->label('Pending Approval')
                    ->query(fn (Builder $query): Builder => $query->where('is_approved', false)),
                Tables\Filters\Filter::make('approved')
                    ->label('Approved')
                    ->query(fn (Builder $query): Builder => $query->where('is_approved', true)),
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    // Only show if the dataset is NOT approved:
                    ->visible(fn (Dataset $record): bool => !(bool)$record->is_approved)
                    ->action(function (Dataset $record): void {
                        $record->update([
                            'is_approved' => true,
                            'approved_at' => now(),
                            'approved_by' => auth()->id(),
                        ]);
                    }),
                Tables\Actions\Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    // Only show if the dataset is approved:
                    ->visible(fn (Dataset $record): bool => (bool)$record->is_approved)
                    ->action(function (Dataset $record): void {
                        $record->update([
                            'is_approved' => false,
                            'approved_at' => null,
                            'approved_by' => null,
                        ]);
                    }),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('approve_selected')
                        ->label('Approve Selected')
                        ->icon('heroicon-o-check')
                        ->color('success')
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records): void {
                            $records->each(function (Dataset $record): void {
                                $record->update([
                                    'is_approved' => true,
                                    'approved_at' => now(),
                                    'approved_by' => auth()->id(),
                                ]);
                            });
                        }),
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
            'index' => Pages\ListDatasets::route('/'),
            'create' => Pages\CreateDataset::route('/create'),
            'edit' => Pages\EditDataset::route('/{record}/edit'),
        ];
    }
}
