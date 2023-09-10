<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Filament\Resources\PaymentResource\RelationManagers;
use App\Models\CustomPackage;
use App\Models\HotelCategory;
use App\Models\payment;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaymentResource extends Resource
{
    protected static ?string $model = payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Packages';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('customers_id')
                ->relationship('customers','customer')
                ->live()
                ->required(),
                Select::make('custom_package')
                ->options(function(callable $get){
                    $package = CustomPackage::where('customers_id',$get('customers_id'))->get();
                    if(!$package){
                        return CustomPackage::all();
                    }
                    return $package->pluck('name','id');
                })
                ->live()
                ->required(),
                Select::make('hotel_type')
                ->options(function(callable $get){
                    $package = CustomPackage::find($get('custom_package'));
                    if(!$package){
                        return HotelCategory::all()->pluck('category','id');
                    }

                    $type = [];

                    foreach ($package['rooms'] as $room) {
                        $roomtype = HotelCategory::all();
                        for ($i=1; $i < count($roomtype); $i++) {
                            if($room['hotel_type'] == $i){
                                if(!in_array($room['hotel_type'],$type)){
                                    array_push($type,$room['hotel_type']);
                                }
                            }
                        }
                    }

                    $category = HotelCategory::find($type);

                    return $category->pluck('category','id');

                })
                ->required()
                ->afterStateUpdated(function(string $operation, $state, Forms\Set $set, callable $get){
                    if($operation !== 'create' && $operation !== 'edit'){
                        return;
                    }

                    $record = CustomPackage::find($get('custom_package'));

                    $extracustomer = 0;
                    $totalcustomers = 0;
                    $childwithbed = 0;
                    $childwithoutbed = 0;
                    $totalroom = 0;
                    $totaladultmatress = 0;
                    $totalextrameal = 0;
                    $totalmap = 0;
                    $totalap = 0;
                    $totalcruz = 0;
                    $totalvehicle = 0;
                    $totaladdon = 0;
                    $grandtotal = 0;

                    if($record->customers->adults>1 ){
                        if(($record->customers->adults % 2) != 0){
                            $totalcustomers = $record->customers->adults - 1;
                            $extracustomer = 1;
                        }
                        else{
                            $totalcustomers = $record->customers->adults;
                        }
                    }else{
                        $totalcustomers = 1;
                    }


                    $childwithbed = $record->customers->childgreaterthan5;
                    $childwithoutbed = $record->customers->childlessthan5;
                    // dd($record->rooms);



                    $adultcruz = 0;
                    $childcruz = 0;

                    $totalcruzpassenger = $totalcustomers+$extracustomer;

                    foreach ($record->cruz as $cruz) {
                        $adultcruz = $adultcruz + $cruz['price_adult']*$totalcruzpassenger;
                        $childcruz = $childcruz + $cruz['price_infant']*$childwithoutbed;
                    }

                    $totalvehiclepassengers = $totalcustomers + $extracustomer + $childwithbed + $childwithoutbed;

                    foreach ($record->vehicle as $vehicle){
                        $totalvehicle = $totalvehicle + $vehicle['price'] * $totalvehiclepassengers;
                    }

                    foreach ($record->addons as $addon){
                        $totaladdon = $totaladdon + $addon['price'];
                    }


                    $person=0;
                    $hotelrates = [];
                    foreach ($record->rooms as $room) {
                        // dd($room['hotel_type']);

                        $roomtype = HotelCategory::all();
                        for ($i=1; $i <= count($roomtype); $i++) {
                            if($state == $i){
                                if($room['hotel_type'] == $state){
                                    if(!array_key_exists($i,$hotelrates)){
                                        $hotelrates[$i] =  ($room['price']/2) + $room['adult_mattress_price'] + $room['child_without_mattress_price'] + $room['child_with_mattress_price'] + $room['extra_meal_price'] + $room['map'] + $room['ap'] * $room['no_of_room']*$totalcustomers;

                                        if($extracustomer != 0){
                                            $hotelrates[$i] = $hotelrates[$i] + ($room['price']/2) + $room['adult_mattress_price'] + $room['child_without_mattress_price'] + $room['child_with_mattress_price'] + $room['extra_meal_price'] + $room['map'] + $room['ap'] * $room['no_of_room'];
                                        }
                                    }
                                    else{
                                        $hotelrates[$i] = $hotelrates[$i] + ($room['price']/2) + $room['adult_mattress_price'] + $room['child_without_mattress_price'] + $room['child_with_mattress_price'] + $room['extra_meal_price'] + $room['map'] + $room['ap'] * $room['no_of_room']*$totalcustomers;

                                        if($extracustomer != 0){
                                            $hotelrates[$i] = $hotelrates[$i] + ($room['price']/2) + $room['adult_mattress_price'] + $room['child_without_mattress_price'] + $room['child_with_mattress_price'] + $room['extra_meal_price'] + $room['map'] + $room['ap'] * $room['no_of_room'];
                                        }

                                    }

                                }

                            }

                        }

                    }

                    foreach ($hotelrates as $rate => $room) {

                        // dd($hotelrates[$rate]);
                         $hotelrates[$rate] = $hotelrates[$rate] + $adultcruz + $childcruz + $totalvehicle + $totaladdon;
                         $set('total_amount', $hotelrates[$rate] + (($record->margin/100)*$hotelrates[$rate]));
                    }
                })
                ->live(),
                TextInput::make('total_amount')
                ->label('Total Amount')
                ->prefix('₹')
                ->numeric()
                ->required(),
                TextInput::make('amount_paid')
                ->prefix('₹')
                ->numeric()
                ->required(),
                TextInput::make('bank')
                ->label('Bank details')
                ->required(),
                DatePicker::make('payment_date')
                ->required(),
                Textarea::make('reference')
                ->label('Refence (If Any)')

            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('customers.customer')
                ->sortable()
                ->searchable(),
                TextColumn::make('total_amount')
                ->sortable()
                ->searchable(),
                TextColumn::make('amount_paid')
                ->sortable()
                ->searchable(),
                TextColumn::make('payment_date')
                ->since()
                ->sortable()
                ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Action::make('View Doc')
                    ->icon('heroicon-o-eye')
                    ->url(fn(payment $record) => route('voucher.pdf.voucher',$record))
                    ->openUrlInNewTab()
                    ->color('info'),
                    Tables\Actions\EditAction::make(),
                    DeleteAction::make(),
                    Action::make('Download Pdf')
                    ->icon('heroicon-o-arrow-down-on-square-stack')
                    ->url(fn(payment $record) => route('voucher.pdf.download',$record))
                    ->openUrlInNewTab(),
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
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}
