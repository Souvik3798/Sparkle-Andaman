<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IternityTemplateResource\Pages;
use App\Filament\Resources\IternityTemplateResource\RelationManagers;
use App\Models\IternityTemplate;
use App\Models\preset;
use Filament\Forms;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class IternityTemplateResource extends Resource
{
    protected static ?string $model = IternityTemplate::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Templates';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('Title')
                ->label('Title')
                ->required(),
                Textarea::make('Description')
                ->required(),
                Textarea::make('Specialties')
                ->required(),
                Textarea::make('locationCovered')
                ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('Title')
                ->label('Title'),
                TextColumn::make('Description')
                ->limit(50),
                TextColumn::make('Specialties'),
                TextColumn::make('locationCovered')
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
            'index' => Pages\ListIternityTemplates::route('/'),
            'create' => Pages\CreateIternityTemplate::route('/create'),
            'edit' => Pages\EditIternityTemplate::route('/{record}/edit'),
        ];
    }
}
