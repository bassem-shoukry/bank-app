<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CityResource\Pages;
use App\Filament\Resources\CityResource\RelationManagers;
use App\Models\City;
use App\Models\Country;
use Exception;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

Class CityResource extends Resource
{
    protected static ?string $model = City::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\Select::make('country_id')
                ->label('Country')
                ->options(Country::query()->pluck('name', 'id'))
                ->required()
                ->searchable(),
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),
        ]);
}

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('country.name')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('name')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('country_id')
                ->label('Country')
                ->options(Country::query()->pluck('name', 'id'))
                ->searchable(),

        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
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
        'index' => Pages\ListCities::route('/'),
        'create' => Pages\CreateCity::route('/create'),
        'edit' => Pages\EditCity::route('/{record}/edit'),
    ];
}
}
