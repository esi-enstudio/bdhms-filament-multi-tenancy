<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RetailerResource\Pages;
use App\Filament\Resources\RetailerResource\RelationManagers;
use App\Models\Retailer;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RetailerResource extends Resource
{
    protected static ?string $model = Retailer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\TextInput::make('code')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('address')
                                    ->required()
                                    ->maxLength(255),
                            ]),
                    ]),

                Forms\Components\Group::make()
                    ->schema([

                    ]),
//                Forms\Components\Select::make('house_id')
//                    ->relationship('house', 'name')
//                    ->required(),
//                Forms\Components\TextInput::make('rso_id')
//                    ->numeric(),
//                Forms\Components\TextInput::make('user_id')
//                    ->numeric(),
//                Forms\Components\TextInput::make('is_rso_code')
//                    ->numeric(),
//                Forms\Components\TextInput::make('is_bp_code')
//                    ->numeric(),

//                Forms\Components\TextInput::make('type')
//                    ->required()
//                    ->maxLength(255)
//                    ->default('telecom'),
//                Forms\Components\TextInput::make('enabled')
//                    ->required()
//                    ->maxLength(255)
//                    ->default('Y'),
//                Forms\Components\TextInput::make('sso')
//                    ->maxLength(255),
//                Forms\Components\TextInput::make('itop_number')
//                    ->maxLength(255),
//                Forms\Components\TextInput::make('service_point')
//                    ->maxLength(255),
//                Forms\Components\TextInput::make('category')
//                    ->maxLength(255),
//                Forms\Components\TextInput::make('owner_name')
//                    ->maxLength(255),
//                Forms\Components\TextInput::make('owner_number')
//                    ->maxLength(255),
//                Forms\Components\TextInput::make('division')
//                    ->maxLength(255),
//                Forms\Components\TextInput::make('district')
//                    ->maxLength(255),
//                Forms\Components\TextInput::make('thana')
//                    ->maxLength(255),

//                Forms\Components\TextInput::make('nid')
//                    ->maxLength(255),
//                Forms\Components\DatePicker::make('dob'),
//                Forms\Components\TextInput::make('lat')
//                    ->maxLength(255),
//                Forms\Components\TextInput::make('long')
//                    ->maxLength(255),
//                Forms\Components\TextInput::make('bts_code')
//                    ->maxLength(255),
//                Forms\Components\Textarea::make('description')
//                    ->columnSpanFull(),
//                Forms\Components\TextInput::make('remarks')
//                    ->maxLength(255),
//                Forms\Components\TextInput::make('others_operator'),
//                Forms\Components\TextInput::make('document')
//                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('house.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rso_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('is_rso_code')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('is_bp_code')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('enabled')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sso')
                    ->searchable(),
                Tables\Columns\TextColumn::make('itop_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('service_point')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category')
                    ->searchable(),
                Tables\Columns\TextColumn::make('owner_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('owner_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('division')
                    ->searchable(),
                Tables\Columns\TextColumn::make('district')
                    ->searchable(),
                Tables\Columns\TextColumn::make('thana')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nid')
                    ->searchable(),
                Tables\Columns\TextColumn::make('dob')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('long')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bts_code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('remarks')
                    ->searchable(),
                Tables\Columns\TextColumn::make('document')
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
            'index' => Pages\ListRetailers::route('/'),
//            'create' => Pages\CreateRetailer::route('/create'),
//            'edit' => Pages\EditRetailer::route('/{record}/edit'),
        ];
    }
}
