<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IternityTemplateResource\Pages;
use App\Filament\Resources\IternityTemplateResource\RelationManagers;
use App\Models\IternityTemplate;
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
                TextInput::make('name')
                ->label('Title')
                ->required(),
                Textarea::make('description')
                ->required(),
                TagsInput::make('specialities')
                ->required(),
                TagsInput::make('locations')
                ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                ->label('Title'),
                TextColumn::make('description'),
                TagsColumn::make('specialities'),
                TagsColumn::make('locations')
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
