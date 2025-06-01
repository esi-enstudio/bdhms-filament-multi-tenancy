<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BtsResource\Pages;
use App\Filament\Resources\BtsResource\RelationManagers;
use App\Models\Bts;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BtsResource extends Resource
{
    protected static ?string $model = Bts::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('site_id')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('bts_code')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('site_type')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('thana')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('district')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('division')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('region')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('cluster')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('bts_address')
                    ->required(),
                Forms\Components\TextInput::make('urban_rural')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('longitude')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('latitude')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('network_mode')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('archetype')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('2g_onair_date'),
                Forms\Components\DatePicker::make('3g_onair_date'),
                Forms\Components\DatePicker::make('4g_onair_date'),
                Forms\Components\TextInput::make('priority')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('house.code')
                    ->sortable(),
                Tables\Columns\TextColumn::make('site_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bts_code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('site_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('thana')
                    ->searchable(),
                Tables\Columns\TextColumn::make('district')
                    ->searchable(),
                Tables\Columns\TextColumn::make('division')
                    ->searchable(),
                Tables\Columns\TextColumn::make('region')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cluster')
                    ->searchable(),
                Tables\Columns\TextColumn::make('urban_rural')
                    ->searchable(),
                Tables\Columns\TextColumn::make('longitude')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('latitude')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('network_mode')
                    ->searchable(),
                Tables\Columns\TextColumn::make('archetype')
                    ->searchable(),
                Tables\Columns\TextColumn::make('2g_onair_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('3g_onair_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('4g_onair_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('priority')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultPaginationPageOption(5)
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListBts::route('/'),
//            'create' => Pages\CreateBts::route('/create'),
//            'edit' => Pages\EditBts::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest('created_at');
    }
}
