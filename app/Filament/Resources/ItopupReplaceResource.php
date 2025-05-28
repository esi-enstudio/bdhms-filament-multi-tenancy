<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ItopupReplaceResource\Pages;
use App\Filament\Resources\ItopupReplaceResource\RelationManagers;
use App\Models\ItopupReplace;
use App\Models\Rso;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ItopupReplaceResource extends Resource
{
    protected static ?string $model = ItopupReplace::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('retailer_id')
                    ->label('Itop Number')
                    ->relationship('retailer', 'itop_number', function ($query) {
                        // Base query: only fetch enabled retailers
                        $query->select('id', 'name', 'itop_number');

                        // Get the authenticated user
                        $user = Auth::user();

                        if ($user) {
                            if ($user->hasRole('rso')) {
                                $rsoId = Rso::select('id')->firstWhere(['status' => 'active', 'user_id' => $user->id])?->id;
                                if ($rsoId) {
                                    $query->where('rso_id', $rsoId);
                                } else {
                                    // If no RSO record is found, return no retailers
                                    $query->whereRaw('1 = 0');
                                }
                            }
                            // If the user has the 'supervisor' role, filter retailers by the logged-in supervisor
                            elseif ($user->hasRole('supervisor')) {
                                $query->where('user_id', $user->id);
                            }
                        }

                        return $query;
                    })
                    ->getOptionLabelFromRecordUsing(fn($record) => "{$record->itop_number} - {$record->name}")
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('sim_serial')
                    ->required()
                    ->integer()
                    ->maxLength(18)
                    ->rules(fn ($get) => [
                        Rule::unique('itopup_replaces', 'sim_serial')->ignore($get('id')),
                    ]),

                TextInput::make('balance')
                    ->required()
                    ->integer()
                    ->maxLength(6),

                Select::make('reason')
                    ->required()
                    ->options([
                        'damaged' => 'Damaged',
                        'stolen' => 'Stolen',
                        'retailer_changed' => 'Retailer Changed',
                    ]),

                Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'processing' => 'Processing',
                        'canceled' => 'Canceled',
                        'complete' => 'Complete',
                    ])
                    ->default('pending')
                    ->live()
                    ->afterStateUpdated(function ($state, Set $set){
                        // When status is set to 'complete', update completed_at to the current datetime
                        if ($state === 'complete') {
                            $set('completed_at', now()->toDateTimeString());
                        } else {
                            // Optional: Clear completed_at if status is changed to something other than 'complete'
                            $set('completed_at', null);
                        }
                    })
                    ->visible(fn () => Auth::user()->hasRole('super_admin')), // Visible only for super_admin

                TextInput::make('remarks')
                    ->maxLength(255)
                    ->visible(fn() => Auth::user()->hasRole('super_admin')),

                Hidden::make('completed_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('house.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('retailer.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sim_serial')
                    ->searchable(),
                Tables\Columns\TextColumn::make('balance')
                    ->searchable(),
                Tables\Columns\TextColumn::make('reason')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('remarks')
                    ->searchable(),
                Tables\Columns\TextColumn::make('completed_at')
                    ->dateTime()
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
            'index' => Pages\ListItopupReplaces::route('/'),
//            'create' => Pages\CreateItopupReplace::route('/create'),
//            'edit' => Pages\EditItopupReplace::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if (!Auth::user()->hasRole('super_admin')) {
            $query->where('user_id', Auth::id());
        }

        return $query->latest('created_at');
    }
}
