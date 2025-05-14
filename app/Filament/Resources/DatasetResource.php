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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['skills']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Dataset Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            ->required(),
                        Forms\Components\Select::make('skills')
                            ->relationship('skills', 'name')
                            ->multiple()
                            ->label('Skills')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Select::make('industry_id')
                            ->relationship('industry', 'name')
                            ->required(),
                        Forms\Components\Select::make('year_id')
                            ->relationship('year', 'year')
                            ->required(),
                        Forms\Components\TextInput::make('source')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('size')
                            ->label('Size (MB)')
                            ->numeric()
                            ->default(0),
                    ]),

                Forms\Components\Toggle::make('is_approved')
                    ->label('Approved')
                    ->default(false)
                    ->visible(fn () => auth()->user()->can('approve datasets')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('description')->limit(50),
                Tables\Columns\TextColumn::make('skills')
                    ->label('Skills')
                    ->getStateUsing(function (Dataset $record): string {
                        // Get all skills
                        $allSkills = $record->getAllSkills()->pluck('name')->toArray();
                        return implode(', ', $allSkills);
                    }),
                Tables\Columns\TextColumn::make('industry.name'),
                Tables\Columns\TextColumn::make('year.year'),
                Tables\Columns\TextColumn::make('files_count')
                    ->counts('files')
                    ->label('Files')
                    ->sortable(),
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
                Tables\Actions\ViewAction::make()
                    ->mutateRecordDataUsing(function (array $data): array {
                        // You can make additional adjustments to the data here if needed
                        return $data;
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
            RelationManagers\DatasetFilesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDatasets::route('/'),
            'create' => Pages\CreateDataset::route('/create'),
            'view' => Pages\ViewDataset::route('/{record}'),
            'edit' => Pages\EditDataset::route('/{record}/edit'),
        ];
    }
}
