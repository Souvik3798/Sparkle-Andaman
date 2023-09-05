<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customers;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class CustomerResource extends Resource
{
    protected static ?string $model = Customers::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('cid')
                ->label('Cutomer ID')
                ->disabled()
                ->dehydrated()
                ->default(Str::random(10)),
                TextInput::make('customer')
                ->label('Full Name')
                ->required(),
                TextInput::make('number')
                ->label('Mobile Number')
                ->prefix('+91')
                ->required(),
                TextInput::make('adults')
                ->label('Enter the Number of Adults')
                ->required()
                ->numeric(),
                TextInput::make('childgreaterthan5')
                ->label('Enter Number of childrens (5-12 yrs)')
                ->required()
                ->placeholder('if not then please type 0')
                ->default(0)
                ->numeric(),
                TextInput::make('childlessthan5')
                ->label('Enter Number of childrens (Upto 5 yrs)')
                ->required()
                ->placeholder('if not then please type 0')
                ->default(0)
                ->numeric(),
                DatePicker::make('dateofarrival')
                ->label('Date of Arrival')
                ->required(),
                DatePicker::make('dateofdeparture')
                ->label('Date of Departure')
                ->required(),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('cid')
                ->searchable()
                ->sortable()
                ->label('Cutomer ID'),
                TextColumn::make('customer')
                ->searchable()
                ->sortable()
                ->label('Customer Name'),
                TextColumn::make('number')
                ->searchable()
                ->sortable()
                ->prefix('+91')
                ->label('Mobile Number'),
                TextColumn::make('dateofarrival')
                ->searchable()
                ->sortable()
                ->date()
                ->label('Date of Arrival'),
                TextColumn::make('dateofdeparture')
                ->searchable()
                ->date()
                ->sortable()
                ->label('Date of Departure')


            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                ViewAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
