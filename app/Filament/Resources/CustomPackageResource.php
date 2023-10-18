<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomPackageResource\Pages;
use App\Models\Addon;
use App\Models\Cabs;
use App\Models\Category;
use App\Models\Customers;
use App\Models\CustomPackage;
use App\Models\destination;
use App\Models\Ferry;
use App\Models\Hotel;
use App\Models\HotelCategory;
use App\Models\IternityTemplate;
use App\Models\PackageTemplate;
use App\Models\preset;
use App\Models\RoomCategory;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ReplicateAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomPackageResource extends Resource
{
    protected static ?string $model = CustomPackage::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Packages';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

         $tab = Tabs::make('General Package')
                ->tabs([
                    Tab::make('Personal Info')
                        ->schema([
                            TextInput::make('customers_id')
                            ->label('Customer Number')
                            ->disabled()
                            ->live()
                            ->dehydrated(),
                            Select::make('cid')
                            ->options(Customers::all()->pluck('customer','cid'))
                            // ->autocomplete(false)
                            ->searchable()
                            ->live()
                            ->label('Cutomer Name')
                            ->afterStateUpdated(function(string $operation, $state, Forms\Set $set){
                                if($operation !== 'create' && $operation !== 'edit'){
                                    return;
                                }

                                $customers = Customers::where('cid',$state)->get();

                                foreach ($customers as $customer) {
                                    $custid = $customer->id;
                                    $cid = $customer->cid;
                                    $cust_name = $customer->customer;
                                    $number = $customer->number;
                                    $adults = $customer->adults;
                                    $childgreaterthan5 = $customer->childgreaterthan5;
                                    $childlessthan5 = $customer->childlessthan5;
                                    $dateofarrival = $customer->dateofarrival;
                                    $dateofdeparture = $customer->dateofdeparture;
                                }

                                if($customers->count() > 0){
                                    $set('customers_id', $custid);
                                    $set('customer', $cid);
                                    $set('number', $number);
                                    $set('adults', $adults);
                                    $set('childgreaterthan5', $childgreaterthan5);
                                    $set('childlessthan5', $childlessthan5);
                                    $set('dateofarrival', date('F d, Y',strtotime($dateofarrival)));
                                    $set('dateofdeparture', date('F d, Y',strtotime($dateofdeparture)));
                                }

                            }),
                            TextInput::make('customer')
                            ->label('Customer ID')
                            ->dehydrated()
                            ->disabled()
                            ->live(),
                            TextInput::make('number')
                            ->label('Mobile Number')
                            ->prefix('+91')
                            ->disabled()
                            ->visibleOn('create'),
                            TextInput::make('adults')
                            ->label('Number of Adults')
                            ->disabled()
                            ->numeric()
                            ->visibleOn('create'),
                            TextInput::make('childgreaterthan5')
                            ->label('Number of childrens (5-12 yrs)')
                            ->disabled()
                            ->placeholder('if not then please type 0')
                            ->default(0)
                            ->numeric()
                            ->visibleOn('create'),
                            TextInput::make('childlessthan5')
                            ->label('Number of childrens (Upto 5 yrs)')
                            ->disabled()
                            ->placeholder('if not then please type 0')
                            ->default(0)
                            ->numeric()
                            ->visibleOn('create'),
                            TextInput::make('dateofarrival')
                            ->label('Date of Arrival')
                            ->disabled()
                            ->visibleOn('create'),
                            TextInput::make('dateofdeparture')
                            ->label('Date of Departure')
                            ->disabled()
                            ->visibleOn('create'),
                ])->columns(3),
                    Tab::make('Add Package')
                        ->schema([
                            Select::make('category_id')
                            ->label('Category')
                            ->options(Category::all()->pluck('category','id'))
                            ->live()
                            ->required(),
                            TextInput::make('name')
                            ->label('Title')
                            ->datalist(function(callable $get){
                                if(!$get('category_id')){
                                    return PackageTemplate::all()->pluck('name');
                                }
                                else{
                                    return PackageTemplate::where('category_id',$get('category_id'))->pluck('name');
                                }
                            })
                            ->live()
                            ->afterStateUpdated(function(string $operation, $state, Forms\Set $set){
                                if($operation !== 'create' && $operation !== 'edit'){
                                    return;
                                }


                                    $packs = PackageTemplate::where('name',$state)->get();


                                foreach ($packs as $pack) {
                                    $description = $pack->description;
                                    $day = $pack->days;
                                    $night = $pack->nights;
                                    $inclusions = $pack->inclusions;
                                    $exclusions = $pack->exclusions;
                                    $catid = $pack->category_id;
                                }

                                if($packs->count() > 0){
                                    $set('description', $description);
                                    $set('inclusions', $inclusions);
                                    $set('exclusions', $exclusions);
                                    $set('days', $day);
                                    $set('nights', $night);
                                    $set('category_id',$catid);
                                }
                            })
                            ->required()
                            ->autocomplete('off'),
                            TextInput::make('days')
                            ->required()
                            ->label('Number of Days')
                            ->numeric(),
                            TextInput::make('nights')
                            ->required()
                            ->label('Number of Nights')
                            ->numeric(),
                            Textarea::make('description')
                            ->required(),

                            TagsInput::make('inclusions')
                            ->required(),
                            TagsInput::make('exclusions')
                            ->required()
                            ->hintColor('green'),
                            TextInput::make('margin')
                            ->label('Enter Margin Value')
                            ->required()
                            ->numeric()
                            ->default(5)
                            ,
                            // FileUpload::make('image')
                            // ->disk('public')->directory('custom')
                            // ->image()
                        ])->columns(4),
                    Tab::make('Add Iternity')
                    ->schema([
                        Repeater::make('iternity')
                        ->schema([
                            Select::make('days')
                            ->label('Day')
                            ->required()
                            ->options(['1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20']),
                            Select::make('destination')
                            ->label('Select Destinations')
                            ->options(destination::all()->pluck('Title','Title'))
                            ->required(),
                            TextInput::make('name')
                            ->label('Title')
                            ->datalist(preset::all()->pluck('Title'))
                            ->live()
                            ->afterStateUpdated(function(string $operation, $state, Forms\Set $set){
                                if($operation !== 'create' && $operation !== 'edit'){
                                    return;
                                }

                                $packs = preset::where('Title',$state)->get();

                                foreach ($packs as $pack) {
                                    $description = $pack->Description;
                                    $specialities = $pack->Specialties;
                                    $locations = $pack->locationCovered;
                                }

                                $s = ["<p>","</p>","<i>","</i>"];
                                if($packs->count() > 0){
                                    $set('description', str_replace($s,"",$description));
                                    $set('specialities', $specialities);
                                    $set('locations', $locations);
                                }
                            })
                            ->required(),
                            Textarea::make('description')
                            ->required(),
                            Textarea::make('specialities')
                            ->required(),
                            Textarea::make('locations')
                            ->required(),
                            DatePicker::make('date')
                            ->label('Date')
                        ])->columns(3)
                    ]),
                    Tab::make('Add Rooms')
                        ->schema([
                            Repeater::make('rooms')
                            ->schema([
                                Section::make('Basic Details')
                                ->schema([
                                    Fieldset::make('Location details')
                                    ->schema([
                                        Select::make('location')
                                        ->label('Select Location')
                                        ->options(destination::all()->pluck('Title','Title'))
                                        ->required()
                                        ->live(),
                                        Select::make('days')
                                        ->label('Day')
                                        ->required()
                                        ->options(['1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20']),
                                        Select::make('no_of_room')
                                        ->label('Select Number of Rooms')
                                        ->required()
                                        ->options(['1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20']),
                                    ])->columns(3),
                                    Fieldset::make('Hotel details')
                                    ->schema([
                                        Select::make('hotel_type')
                                        ->label('Hotel Type')
                                        ->options(HotelCategory::all()->pluck('category','id'))
                                        ->required()
                                        ->live(),
                                        Select::make('hotel_name')
                                        ->label('Hotel Name')
                                        ->options(function(callable $get){
                                            $hotelcategory = HotelCategory::find($get('hotel_type'));
                                            if(!$hotelcategory){
                                                return Hotel::whereNotNUll('hotelName')->pluck('hotelName','id');
                                            }
                                            $loc = destination::select('ID')->where('Title',$get('location'))->get();
                                            foreach ($loc as $loc) {
                                                $des = $loc->ID;
                                            }
                                            // dd($des);
                                            return $hotelcategory->hotel->where('Location',$des)->pluck('hotelName','id');
                                        })
                                        ->required()
                                        ->live()
                                        ->afterStateUpdated(function(string $operation, $state, Forms\Set $set){
                                            if($operation !== 'create' && $operation !== 'edit'){
                                                return;
                                            }

                                            $hotels = Hotel::where('id',$state)->get();

                                            foreach ($hotels as $hotel) {
                                                $price = $hotel->startingPrice;
                                            }

                                            if($hotels->count() > 0){
                                                $set('price', $price);
                                            }
                                        }),
                                        Select::make('room_type')
                                        ->label('Room Type')
                                        ->options(RoomCategory::all()->pluck('category','id'))
                                        ->required(),
                                        TextInput::make('price')
                                        ->label('Cost')
                                        ->numeric()
                                        ->prefix('₹')
                                        ->suffix('/-')
                                        ->required(),
                                        DatePicker::make('date')
                                        ->label('Date')
                                        ->required(),
                                    ])->columns(3),
                                ]),
                                Section::make('Extras')
                                ->schema([
                                    Fieldset::make('Extra Matress')
                                    ->schema([
                                        TextInput::make('adult_mattress_price')
                                        ->label('Adult with Matress')
                                        ->required()
                                        ->default(0)
                                        ->numeric()
                                        ->prefix('₹')
                                        ->suffix('/-'),

                                        TextInput::make('child_without_mattress_price')
                                        ->label('Child Without Matress')
                                        ->required()
                                        ->default(0)
                                        ->numeric()
                                        ->prefix('₹')
                                        ->suffix('/-'),

                                        TextInput::make('child_with_mattress_price')
                                        ->label('Child With Matress')
                                        ->required()
                                        ->default(0)
                                        ->numeric()
                                        ->prefix('₹')
                                        ->suffix('/-')

                                    ])->columns(3),
                                    Fieldset::make('Meal Plan')
                                    ->schema([
                                        TextInput::make('extra_meal_price')
                                        ->label('CP Plan|Room')
                                        ->numeric()
                                        ->default(0)
                                        ->prefix('₹')
                                        ->suffix('/-'),

                                        TextInput::make('map')
                                        ->label('MAP Plan|Room')
                                        ->numeric()
                                        ->default(0)
                                        ->prefix('₹')
                                        ->suffix('/-'),

                                        TextInput::make('ap')
                                        ->label('AP Plan|Room')
                                        ->numeric()
                                        ->default(0)
                                        ->prefix('₹')
                                        ->suffix('/-')
                                    ])->columns(3)
                                ])
                            ]),
                        ]),
                    Tab::make('Add Logistics')
                        ->schema([
                            Section::make('Enter Cruz Details')
                            ->schema([
                                Repeater::make('cruz')
                                ->schema([
                                    Select::make('days')
                                    ->label('Day')
                                    ->options(['1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20']),
                                    Select::make('cruz')
                                    ->options(Ferry::all()->pluck('Title','ID'))
                                    ->live()
                                    ->afterStateUpdated(function(string $operation, $state, Forms\Set $set){
                                        if($operation !== 'create' && $operation !== 'edit'){
                                            return;
                                        }


                                        $ferries = Ferry::where('ID',$state)->get();


                                        foreach ($ferries as $ferry) {
                                            $price = $ferry->startingPrice;
                                        }

                                        if($ferries->count() > 0){
                                            $set('price_adult', $price);
                                        }
                                    }),
                                    Select::make('source')
                                    ->label('Select Source')
                                    ->options(destination::all()->pluck('Title','Title')),
                                    Select::make('destination')
                                    ->label('Select Destinations')
                                    ->options(destination::all()->pluck('Title','Title')),
                                    TextInput::make('price_adult')
                                    ->label('Price for Adult')
                                    ->numeric()
                                    ->prefix('₹')
                                    ->suffix('/-')
                                    ->required(),
                                    TextInput::make('price_infant')
                                    ->label('Price for Infant')
                                    ->numeric()
                                    ->default(0)
                                    ->prefix('₹')
                                    ->suffix('/-')
                                    ->required()
                                    ]),
                            ])->columnSpan(2),
                            Section::make('Enter Vehicle Details')
                            ->schema([
                                Repeater::make('vehicle')
                                ->schema([
                                    Select::make('days')
                                    ->label('Day')
                                    ->options(['1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20']),
                                    Select::make('vehicle')
                                    ->options(Cabs::all()->pluck('Title','ID'))
                                    ->live()
                                    ->afterStateUpdated(function(string $operation, $state, Forms\Set $set){
                                        if($operation !== 'create' && $operation !== 'edit'){
                                            return;
                                        }


                                        $vehicles = Cabs::where('ID',$state)->get();


                                        foreach ($vehicles as $vehicle) {
                                            $price = $vehicle->price;
                                        }

                                        if($vehicles->count() > 0){
                                            $set('price', $price);
                                        }
                                    }),
                                    Select::make('source')
                                    ->label('location')
                                    ->options(destination::all()->pluck('Title','Title')),
                                    TextInput::make('price')
                                    ->label('Price')
                                    ->numeric()
                                    ->prefix('₹')
                                    ->suffix('/-')
                                ]),
                            ])->columnSpan(2),
                        ])->columns(4),
                    Tab::make('Add Extras')
                        ->schema([
                            Section::make('Enter Extras')
                            ->schema([
                                Repeater::make('addons')
                                ->schema([
                                    Select::make('days')
                                    ->label('Day')
                                    ->required()
                                    ->options(['1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15','16'=>'16','17'=>'17','18'=>'18','19'=>'19','20'=>'20']),
                                    Select::make('addon')
                                    ->options(Addon::all()->pluck('name','id'))
                                    ->live()
                                    ->afterStateUpdated(function(string $operation, $state, Forms\Set $set){
                                        if($operation !== 'create' && $operation !== 'edit'){
                                            return;
                                        }
                                        $p = Addon::where('id',$state)->get();
                                        foreach($p as $p){
                                            $set('price', $p->price);
                                        }
                                    })
                                    ->required(),
                                    TextInput::make('price')
                                    ->label('Price')
                                    ->prefix('₹')
                                    ->suffix('/-')
                                    ->live()
                                    ->numeric()
                                    ->required(),
                                    Select::make('source')
                                    ->label('Location')
                                    ->options(destination::all()->pluck('Title','Title'))
                                    ->required(),

                                    Textarea::make('notes')
                                    ->label('Notes (if any)')
                                ])->columns(3),
                            ])
                        ]),
                        Tab::make('Voucher Conformation')
                        ->schema([
                            Checkbox::make('voucher')
                            ->label('Tick to Conform voucher'),
                        ])

                ])->columnSpanFull(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('customers.customer')
                ->label('Customer')
                ->sortable()
                ->searchable(),
                TextColumn::make('name')
                ->label('Package')
                ->sortable()
                ->searchable(),
                TextColumn::make('customers.number')
                ->label('Contact')
                ->prefix('+91-')
                ->sortable()
                ->searchable(),
                TextColumn::make('days')
                ->label('Days')
                ->sortable()
                ->searchable(),
                TextColumn::make('created_at')
                ->label('Time')
                ->date()->since()
                ->sortable()
                ->searchable(),
                BooleanColumn::make('voucher')
                ->label('Voucher')
                ->sortable()
                ->searchable(),
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Action::make('View Doc')
                    ->icon('heroicon-o-eye')
                    ->url(fn(CustomPackage $record) => route('CustomPackage.pdf.view',$record))
                    ->openUrlInNewTab()
                    ->color('info'),
                    Tables\Actions\EditAction::make(),
                    DeleteAction::make(),
                    // Action::make('Download Pdf')
                    // ->icon('heroicon-o-arrow-down-on-square-stack')
                    // ->url(fn(CustomPackage $record) => route('CustomPackage.pdf.download',$record))
                    // ->openUrlInNewTab(),
                    ReplicateAction::make()
                ])


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
            'index' => Pages\ListCustomPackages::route('/'),
            'create' => Pages\CreateCustomPackage::route('/create'),
            'edit' => Pages\EditCustomPackage::route('/{record}/edit'),
        ];
    }
}
