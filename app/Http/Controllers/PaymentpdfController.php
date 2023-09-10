<?php

namespace App\Http\Controllers;

use App\Models\CustomPackage;
use App\Models\HotelCategory;
use App\Models\payment;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentpdfController extends Controller
{
    public function view(payment $record){
        $custompackage = CustomPackage::find($record->custom_package);

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

                    if($custompackage->customers->adults>1 ){
                        if(($custompackage->customers->adults % 2) != 0){
                            $totalcustomers = $custompackage->customers->adults - 1;
                            $extracustomer = 1;
                        }
                        else{
                            $totalcustomers = $custompackage->customers->adults;
                        }
                    }else{
                        $totalcustomers = 1;
                    }


                    $childwithbed = $custompackage->customers->childgreaterthan5;
                    $childwithoutbed = $custompackage->customers->childlessthan5;
                    // dd($custompackage->rooms);



                    $adultcruz = 0;
                    $childcruz = 0;

                    $totalcruzpassenger = $totalcustomers+$extracustomer;

                    foreach ($custompackage->cruz as $cruz) {
                        $adultcruz = $adultcruz + $cruz['price_adult']*$totalcruzpassenger;
                        $childcruz = $childcruz + $cruz['price_infant']*$childwithoutbed;
                    }

                    $totalvehiclepassengers = $totalcustomers + $extracustomer + $childwithbed + $childwithoutbed;

                    foreach ($custompackage->vehicle as $vehicle){
                        $totalvehicle = $totalvehicle + $vehicle['price'] * $totalvehiclepassengers;
                    }

                    foreach ($custompackage->addons as $addon){
                        $totaladdon = $totaladdon + $addon['price'];
                    }


                    $person=0;
                    $hotelrates = [];
                    foreach ($custompackage->rooms as $room) {
                        // dd($room['hotel_type']);

                        $roomtype = HotelCategory::all();
                        for ($i=1; $i <= count($roomtype); $i++) {
                            if($room['hotel_type'] == $i){
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

        return view('pdf.voucher',compact(['record','hotelrates','custompackage']));
    }
    public function pdf(payment $record){
        $custompackage = CustomPackage::find($record->custom_package);

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

                    if($custompackage->customers->adults>1 ){
                        if(($custompackage->customers->adults % 2) != 0){
                            $totalcustomers = $custompackage->customers->adults - 1;
                            $extracustomer = 1;
                        }
                        else{
                            $totalcustomers = $custompackage->customers->adults;
                        }
                    }else{
                        $totalcustomers = 1;
                    }


                    $childwithbed = $custompackage->customers->childgreaterthan5;
                    $childwithoutbed = $custompackage->customers->childlessthan5;
                    // dd($custompackage->rooms);



                    $adultcruz = 0;
                    $childcruz = 0;

                    $totalcruzpassenger = $totalcustomers+$extracustomer;

                    foreach ($custompackage->cruz as $cruz) {
                        $adultcruz = $adultcruz + $cruz['price_adult']*$totalcruzpassenger;
                        $childcruz = $childcruz + $cruz['price_infant']*$childwithoutbed;
                    }

                    $totalvehiclepassengers = $totalcustomers + $extracustomer + $childwithbed + $childwithoutbed;

                    foreach ($custompackage->vehicle as $vehicle){
                        $totalvehicle = $totalvehicle + $vehicle['price'] * $totalvehiclepassengers;
                    }

                    foreach ($custompackage->addons as $addon){
                        $totaladdon = $totaladdon + $addon['price'];
                    }


                    $person=0;
                    $hotelrates = [];
                    foreach ($custompackage->rooms as $room) {
                        // dd($room['hotel_type']);

                        $roomtype = HotelCategory::all();
                        for ($i=1; $i <= count($roomtype); $i++) {
                            if($room['hotel_type'] == $i){
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

        $pdf = Pdf::loadView('pdf.voucher',compact(['record','hotelrates','custompackage']));
        return $pdf->download($record->customers->customer.'.pdf');
    }
}
