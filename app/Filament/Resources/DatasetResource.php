<?php

namespace App\Filament\Resources;

use App\Enums\PaymentStatus;
use App\Filament\Resources\DatasetResource\Pages;
use App\Models\Dataset;
use App\Rules\EgyptianNationalId;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DatasetResource extends Resource
{
    protected static ?string $model = Dataset::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['caseType']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('بيانات القضية')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('الاسم')
                            ->required()
                            ->maxLength(255)
                            ->regex(Dataset::NAME_REGEX),
                        Forms\Components\TextInput::make('national_id')
                            ->label('الرقم القومي')
                            ->required()
                            ->mask('99999999999999')
                            ->rules([new EgyptianNationalId]),
                        Forms\Components\Textarea::make('address')
                            ->label('العنوان')
                            ->required()
                            ->maxLength(1000),
                        Forms\Components\TextInput::make('case_number')
                            ->label('رقم القضيه')
                            ->required()
                            ->maxLength(100)
                            ->regex(Dataset::CASE_NUMBER_REGEX),
                        Forms\Components\Select::make('case_type_id')
                            ->label('نوع القضيه')
                            ->relationship('caseType', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->label('نوع القضيه')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique('case_types', 'name')
                                    ->regex(Dataset::NAME_REGEX),
                            ]),
                        Forms\Components\Textarea::make('verdict')
                            ->label('الحكم')
                            ->required()
                            ->maxLength(5000),
                        Forms\Components\Select::make('payment_status')
                            ->label('السداد')
                            ->options(PaymentStatus::class)
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable(),
                Tables\Columns\TextColumn::make('national_id')
                    ->label('الرقم القومي')
                    ->searchable(),
                Tables\Columns\TextColumn::make('case_number')
                    ->label('رقم القضيه')
                    ->searchable(),
                Tables\Columns\TextColumn::make('caseType.name')
                    ->label('نوع القضيه'),
                Tables\Columns\TextColumn::make('payment_status')
                    ->label('السداد')
                    ->badge(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإضافة')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('payment_status')
                    ->label('السداد')
                    ->options(PaymentStatus::class),
                Tables\Filters\SelectFilter::make('case_type_id')
                    ->label('نوع القضيه')
                    ->relationship('caseType', 'name'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
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
            'index' => Pages\ListDatasets::route('/'),
            'create' => Pages\CreateDataset::route('/create'),
            'view' => Pages\ViewDataset::route('/{record}'),
            'edit' => Pages\EditDataset::route('/{record}/edit'),
        ];
    }
}
