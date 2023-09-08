<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GeneralPackageResource\Pages;
use App\Filament\Resources\GeneralPackageResource\RelationManagers;
use App\Models\Category;
use App\Models\GeneralPackage;
use App\Models\IternityTemplate;
use App\Models\PackageTemplate;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Forms\Get;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

class GeneralPackageResource extends Resource
{
    protected static ?string $model = GeneralPackage::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Packages';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Tabs::make('General Package')
                ->tabs([
                    Tab::make('Add Package')
                        ->schema([
                            Select::make('category_id')
                            ->label('Category')
                            ->options(Category::all()->pluck('name','id'))
                            ->required(),
                            TextInput::make('days')
                            ->required()
                            ->label('Number of Days')
                            ->numeric(),
                            TextInput::make('nights')
                            ->required()
                            ->label('Number of Nights')
                            ->numeric(),
                            TextInput::make('name')
                            ->label('Title')
                            ->datalist(PackageTemplate::all()->pluck('name'))
                            ->live()
                            ->afterStateUpdated(function(string $operation, $state, Forms\Set $set){
                                if($operation !== 'create' && $operation !== 'edit'){
                                    return;
                                }

                                $packs = PackageTemplate::where('name',$state)->get();

                                foreach ($packs as $pack) {
                                    $description = $pack->description;
                                    $cost = $pack->cost;
                                    $inclusions = $pack->inclusions;
                                    $exclusions = $pack->exclusions;
                                }

                                if($packs->count() > 0){
                                    $set('description', $description);
                                    $set('cost', $cost);
                                    $set('inclusions', $inclusions);
                                    $set('exclusions', $exclusions);
                                }
                            })
                            ->required()
                            ->autocomplete('off'),
                            Textarea::make('description')
                            ->required(),
                            TextInput::make('cost')
                            ->label('Package Cost')
                            ->required()
                            ->Placeholder('Eg: 20000'),
                            TagsInput::make('inclusions')
                            ->required(),
                            TagsInput::make('exclusions')
                            ->required()
                            ->hintColor('green'),
                            FileUpload::make('image')
                            ->required()
                            ->disk('public')->directory('general')
                            ->image()
                        ])->columns(4),
                    Tab::make('Add Iternity')
                    ->schema([
                        Repeater::make('iternity')
                        ->schema([
                            Select::make('days')
                            ->label('Select Number of Days')
                            ->required()
                            ->options(['1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20']),
                            Select::make('destination')
                            ->label('Select Destinations')
                            ->options([
                                'Port Blair'=>'Port Blair',
                                'Neil'=>'Neil',
                                'Havelock'=>'Havelock',
                                'Diglipur'=>'Diglipur',
                                'Rangat'=>'Rangat'])
                            ->required(),
                            Select::make('preset')
                            ->label('Select Preset Title')
                            ->options([
                                'Port Blair Arrival'=>'Port Blair Arrival',
                                'Hop to Neil'=>'Hop to Neil',
                                'Hop to Havelock'=> 'Hop to Havelock',
                                'Hop to Diglipur'=>'Hop to Diglipur',
                                'Hop to Rangat'=>'Hop to Rangat'])
                            ->required(),
                            TextInput::make('name')
                            ->label('Title')
                            ->datalist(IternityTemplate::all()->pluck('name'))
                            ->live()
                            ->afterStateUpdated(function(string $operation, $state, Forms\Set $set){
                                if($operation !== 'create' && $operation !== 'edit'){
                                    return;
                                }

                                $packs = IternityTemplate::where('name',$state)->get();

                                foreach ($packs as $pack) {
                                    $description = $pack->description;
                                    $specialities = $pack->specialities;
                                    $locations = $pack->locations;
                                }

                                if($packs->count() > 0){
                                    $set('description', $description);
                                    $set('specialities', $specialities);
                                    $set('locations', $locations);
                                }
                            })
                            ->required(),
                            Textarea::make('description')
                            ->required(),
                            TagsInput::make('specialities')
                            ->required(),
                            TagsInput::make('locations')
                            ->required()
                        ])->columns(3)
                    ]),
                ])->columnSpanFull(),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('category.name')
                ->label('Category'),
                TextColumn::make('name')
                ->label('Title'),
                ImageColumn::make('image')
                ->label('Picture')
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
            'index' => Pages\ListGeneralPackages::route('/'),
            'create' => Pages\CreateGeneralPackage::route('/create'),
            'edit' => Pages\EditGeneralPackage::route('/{record}/edit'),
        ];
    }
}
