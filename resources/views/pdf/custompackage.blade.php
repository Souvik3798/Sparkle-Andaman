@php

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



@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom Package Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            overflow-x: auto;
        }

        .header {
            background-color: {{env('APP_COLOR')}};
            color: white;
            text-align: center;
            font-size: 24px;
            padding: 20px;
        }

        .section {
            padding: 20px;
            border-bottom: 1px solid #ccc;
        }

        .section:last-child {
            border-bottom: none;
        }

        .section-title {
            font-size: 20px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
        }

        th {
            background-color: {{env('APP_COLOR')}};
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }


        /* Media Query for Mobile View */
        @media screen and (max-width: 600px) {
            body{
            zoom:0.6;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Custom Package Details</div>

        <!-- Personal Details Section -->
        <div class="section">
            <div class="section-title">Personal Details</div>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Adults</th>
                    <th>Children (<5)</th>
                    <th>Children (5-12)</th>
                    <th>Arrival Date</th>
                    <th>Departure Date</th>
                </tr>
                <tr>
                    <td>{{$record->customers->customer}}</td>
                    <td>{{$record->customers->number}}</td>
                    <td>{{$record->customers->adults.' Nos'}}</td>
                    <td>{{$record->customers->childlessthan5.' Nos'}}</td>
                    <td>{{$record->customers->childgreaterthan5.' Nos'}}</td>
                    <td>{{date('F d, Y',strtotime($record->customers->dateofarrival))}}</td>
                    <td>{{date('F d, Y',strtotime($record->customers->dateofdeparture))}}</td>
                </tr>
            </table>
        </div>

        <!-- Package Details Section -->
        <div class="section">
            <div class="section-title">Package Details</div>
            <table>
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Number of Days</th>
                    <th>Number of Nights</th>
                    <th>Package Price</th>
                </tr>
                <tr>
                    <td>{{$record->name}}</td>
                    <td>{{$record->category->name}}</td>
                    <td>{{$record->days}}</td>
                    <td>{{$record->nights}}</td>
                    <td>₹{{$record->cost}}</td>
                </tr>
            </table>
        </div>

        <!-- Itinerary Section -->
        <div class="section">
            <div class="section-title">Itinerary</div>
            <table>
                <tr>
                    <th>Days</th>
                    <th>Description</th>
                </tr>
                @foreach ($record->iternity as $iternity)
                    <tr>
                        <td>Day {{$iternity['days']}}</td>
                        <td>
                            Arrival at {{$iternity['destination']}}, famous for  @foreach ($iternity['specialities'] as $speciality)
                            {{$speciality.', '}}
                        @endforeach
                        <br>Locations:
                        @foreach ($iternity['locations'] as $location)
                            {{$location.', '}}
                        @endforeach
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>

        <!-- Room Details Section -->
        <div class="section">
            <div class="section-title">Room Details</div>

            @foreach ($record->rooms as $room)
                            <table>

                                <tr>
                                    <th>Location</th>
                                    <th>No of Days</th>
                                    <th>No of Rooms</th>
                                    <th>Hotel Type</th>
                                    <th>Hotel Name</th>
                                    <th>Room Type</th>
                                    <th>Price</th>
                                </tr>
                                <tr>
                                    <td>{{$room['location']}}</td>
                                    <td>{{$room['days']}}</td>
                                    <td>{{$room['no_of_room']}}</td>
                                    <td>  @php $temp = \App\Models\HotelCategory::find($room['hotel_type']) @endphp
                                        {{$temp->category}}</td>
                                    <td> @php $temp = \App\Models\Hotel::find($room['hotel_name']) @endphp
                                        {{$temp->hotelName}}</td>
                                    <td>@php $temp = \App\Models\RoomCategory::find($room['room_type']) @endphp
                                        {{$temp->category}}</td>
                                    <td>{{'₹ '.$room['price']}}</td>
                                </tr>
                                </table>
                                <table>
                                <tr>
                                    <th>Adult Mattress</th>
                                    <th>Child w/o Mattress</th>
                                    <th>Child with Mattress</th>
                                    <th>Extra meal Price</th>
                                    <th>MAP Price</th>
                                    <th>AP Price</th>
                                </tr>
                                <tr>
                                    @php $totalroom = $totalroom + ($room['price'] * $room['days']); @endphp
                                <td> {{'₹ '.$room['adult_mattress_price']}} </td>
                                @php  $totaladultmatress =  $totaladultmatress + ($room['adult_mattress_price'] * $room['days']); @endphp
                                <td> {{'₹ '.$room['child_without_mattress_price']}} </td>
                                @php $childwithoutbed = $childwithoutbed + ($room['child_without_mattress_price'] * $room['days']); @endphp
                                <td> {{'₹ '.$room['child_with_mattress_price']}} </td>
                                @php
                                    $childwithbed = $childwithbed + ($room['child_with_mattress_price']*$room['days'])
                                @endphp
                                <td> {{'₹ '.$room['extra_meal_price']}} </td>
                                @php
                                     $totalextrameal =  $totalextrameal+($room['extra_meal_price']*$room['days'])
                                @endphp
                                <td> {{'₹ '.$room['map']}} </td>
                                @php
                                    $totalmap = $totalmap + ($room['map']*$room['days'])
                                @endphp
                                <td> {{'₹ '.$room['ap']}} </td>
                                @php
                                    $totalap = $totalap + ($room['ap']*$room['days'])
                                @endphp
                                </tr>

                            </table>
                            @endforeach

        </div>

         <!-- Cruz Details Section -->
         <div class="section">
            <div class="section-title">Cruz Details</div>
            <table>

                    <tr>
                        <th>Days</th>
                        <th>Cruz</th>
                        <th>Source</th>
                        <th>Destination</th>
                        <th>Adult Price</th>
                        <th>Infant Price</th>
                    </tr>
                @foreach ($record->cruz as $cruz)
                    <tr>
                        <td>{{$cruz['days']}}</td>
                        <td>{{$cruz['cruz']}}</td>
                        <td>{{$cruz['source']}}</td>
                        <td>{{$cruz['destination']}}</td>
                        <td>{{'₹'.$cruz['price_adult'].'/-'}}</td>
                        <td>{{'₹'.$cruz['price_infant'].'/-'}}</td>
                    </tr>
                @endforeach
            </table>
        </div>


        <!-- Vehicle Details Section -->
        <div class="section">
            <div class="section-title">Vehicle Details</div>
            <table>

                <tr>
                    <th>Days</th>
                    <th>Vehicle</th>
                    <th>Source</th>
                    <th>Destination</th>
                    <th>Price</th>
                </tr>
                @foreach ($record->vehicle as $vehicle)
                <tr>
                    <td>{{$vehicle['days']}}</td>
                    <td>{{$vehicle['vehicle']}}</td>
                    <td>{{$vehicle['source']}}</td>
                    <td>{{$vehicle['destination']}}</td>
                    <td>{{'₹'.$vehicle['price'].'/-'}}</td>
                    @php
                        $totalvehicle = $totalvehicle + $vehicle['price']
                    @endphp
                </tr>
                @endforeach
            </table>
        </div>

        <!-- Addons Section -->
        <div class="section">
            <div class="section-title">Addons</div>
            <table>
                <tr>
                    <th>Days</th>
                    <th>Addon</th>
                    <th>Source</th>
                    <th>Destination</th>
                    <th>Price</th>
                    <th>Notes</th>
                </tr>
                @foreach ($record->addons as $addon)
                <tr>
                    <td>{{$addon['days']}}</td>
                    @php
                        $addonname = \App\Models\Addon::all();
                    @endphp
                    <td>
                        @foreach ($addonname as $addons)
                            @if($addons->id == $addon['addon'])
                                {{$addons->name}}
                            @endif
                        @endforeach
                    </td>
                    <td>{{$addon['source']}}</td>
                    <td>{{$addon['destination']}}</td>
                    <td>{{'₹ '.$addon['price'].'/-'}}</td>
                    <td>{{$addon['notes']}}</td>
                    @php
                        $totaladdon = $totaladdon + $addon['price']
                    @endphp
                </tr>
            @endforeach
            </table>
        </div>

        <!-- Total Price Section -->
        {{-- <div class="section">
            <div class="section-title">Total Price</div>
            <table>
                <tr>
                    <th>Per Person Rate</th>
                    <th>Net Nos</th>
                    <th>Total</th>
                </tr>
                <tr>
                    <td>Per Person on DBL(Double Bed Room)</td>
                    <td>{{$totalcustomers}}</td>
                    <td>
                        @php
                        if($totalcustomers>1){
                            $totalroom = ($totalroom/2);
                        }
                            $grandtotaladult = $totalroom  +  $totalextrameal + $totalmap + $totalap + $totalcruz + $totalvehicle + $totaladdon;
                        @endphp
                        ₹{{$grandtotaladult*$totalcustomers}}
                    </td>
                </tr>
                <tr>
                    <td>Extra Adult</td>
                    <td>{{$extracustomer}}</td>
                    <td>
                        @php
                            $grandtotalextraadult = $totaladultmatress +  $totalextrameal + $totalmap + $totalap + $totalcruz + $totalvehicle + $totaladdon;
                        @endphp
                        ₹{{$grandtotalextraadult*$extracustomer}}
                    </td>
                </tr>
                <tr>
                    <td>Child With Bed Cost</td>
                    <td> {{$record->customers->childgreaterthan5}}</td>
                    <td>
                        @php
                            $grandtotalchildwithbed = $childwithbed;
                        @endphp
                        ₹{{$grandtotalchildwithbed*$record->customers->childgreaterthan5}}
                    </td>
                </tr>
                <tr>
                    <td>Child Without Bed Cost</td>
                    <td> {{$record->customers->childlessthan5}}</td>
                    <td>₹ @php
                        $grandtotalchildwithoutbed = $childwithoutbed;
                    @endphp
                    {{$grandtotalchildwithoutbed*$record->customers->childlessthan5}}</td>
                </tr>
                <tr>
                    <td><strong>Total</strong></td>
                    <td></td>
                    <td><strong>{{'₹ '.($grandtotalchildwithoutbed*$record->customers->childlessthan5) + ($grandtotalchildwithbed*$record->customers->childgreaterthan5) + ($grandtotalextraadult*$extracustomer) + ($grandtotaladult*$totalcustomers).'.00'}}</strong></td>
                </tr>
            </table>
        </div> --}}
    <footer style="font-family: Georgia, 'Times New Roman', Times, serif">
        Copyright 2023 <span style="color: blue">{{ str_replace('_',' ',env('APP_NAME'),)}} & IOXTIM Solutions</span>, All Right Reserved | Powered By <img src="{{asset('logo/ioxlogo.png')}}" style="margin-top: 10px;align-items: center" height="40px" alt="" srcset="">&nbsp;<img height="30px"src="{{asset('logo/ioxtypo.png')}}" alt="" srcset="">
    </footer>
    </div>
</body>
</html>

