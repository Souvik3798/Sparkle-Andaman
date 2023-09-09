<?php

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



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$record->customers->customer.'::Details'}}</title>

</head>
<body>
    <div style="height:40px;display: block; text-align: right"><img src="{{asset('logo/ioxtypo.png')}}" alt="ioxlogo" style="height: 100%;margin-top: 20px"></div>
    <div style="height:70px;display: block; text-align: center"><img src="{{asset('logo/Ologo.png')}}" alt="ioxlogo" style="height: 100%;margin-top: 20px"></div>
    <div style="justify-content: center;text-align: center;"><h1><u>Custom Package Details</u></h1></div>
    <h3>Personal Details</h3>
    <table style="padding: 10px; border:1px solid black; border-collapse: collapse">
        <tr style="text-align: left;border:1px solid black; border-collapse: collapse">
            <th style="padding:20px;text-align: left;border:1px solid black; border-collapse: collapse">Customer</th>


            <th style="padding:20px;text-align: left;border:1px solid black; border-collapse: collapse">Contact</th>


            <th style="padding:20px;text-align: left;border:1px solid black; border-collapse: collapse">Adults</th>


            <th style="padding:20px;text-align: left;border:1px solid black; border-collapse: collapse">Childern Younger than 5 yrs</th>


            <th style="padding:20px;text-align: left;border:1px solid black; border-collapse: collapse">Childern Between 5-12 yrs</th>


            <th style="padding:20px;text-align: left;border:1px solid black; border-collapse: collapse">Date of Arrival</th>


            <th style="padding:20px;text-align: left;border:1px solid black; border-collapse: collapse">Date of Departure</th>

        </tr>
        <tr>
            <td style="padding:20px;text-align: left;border:1px solid black; border-collapse: collapse">{{$record->customers->customer}}</td>
            <td style="padding:20px;text-align: left;border:1px solid black; border-collapse: collapse">{{$record->customers->number}}</td>
            <td style="padding:20px;text-align: left;border:1px solid black; border-collapse: collapse">{{$record->customers->adults.' Nos'}}</td>
            <td style="padding:20px;text-align: left;border:1px solid black; border-collapse: collapse">{{$record->customers->childlessthan5.' Nos'}}</td>
            <td style="padding:20px;text-align: left;border:1px solid black; border-collapse: collapse">{{$record->customers->childgreaterthan5.' Nos'}}</td>
            <td style="padding:20px;text-align: left;border:1px solid black; border-collapse: collapse">{{date('F d, Y',strtotime($record->customers->dateofarrival))}}</td>
            <td style="padding:20px;text-align: left;border:1px solid black; border-collapse: collapse">{{date('F d, Y',strtotime($record->customers->dateofdeparture))}}</td>
        </tr>
    </table>

    <h3><u>Package Details</u></h3>
    <div style="width: 100%;justify-content: center;align-items: center;justify-items: center">
    <table style="justify-content: center;align-items: center">
        <tr>
            <th style="text-align: left">Title</th>
            <td>{{$record->name}}</td>
        </tr>
        <tr>
            <th style="text-align: left">Category</th>
            <td>{{$record->category->name}}</td>
        </tr>
        <tr>
            <th style="text-align: left">Number of Days</th>
            <td>{{$record->days}}</td>
        </tr>
        <tr>
            <th style="text-align: left">Number of Nights</th>
            <td>{{$record->nights}}</td>
        </tr>
        <tr>
            <th style="text-align: left">Description</th>
            <td>{{$record->description}}</td>
        </tr>
        <tr>
            <th style="text-align: left">Package Price</th>
            <td>{{$record->cost}}</td>
        </tr>



    </table>
    </div>

    <h2>Package Inclusions</h2>
    <ol type="a">

            @foreach ($record->inclusions as $inclusion )
                <li>{{$inclusion}}</li>
            @endforeach

    </ol>
    <h2>Package Exclusions</h2>
    <ol type="a">

            @foreach ($record->exclusions as $exclusion )
                <li>{{$exclusion}}</li>

            @endforeach


    </ol>

    <h3><u>Iternity</u></h3>

    <table style="border: 1px solid;border-collapse: collapse">
        <tr >
            <th style="border: 1px solid;border-collapse: collapse">Days</th>
            <th style="border: 1px solid;border-collapse: collapse">Description</th>
            {{-- <th>Preset Title</th>
            <th>Title</th>
            <th>Description</th>
            <th>Specialities</th>
            <th>Locations</th> --}}
        </tr>
        @foreach ($record->iternity as $iternity)
        <tr>
            <td style="border: 1px solid;border-collapse: collapse"> Day {{$iternity['days']}}</td>
            <td style="border: 1px solid;border-collapse: collapse">Arrival at {{$iternity['destination']}},famous for
                @foreach ($iternity['specialities'] as $speciality)
                    {{$speciality.', '}}
                @endforeach locations:
                @foreach ($iternity['locations'] as $location)
                    {{$location.', '}}
                @endforeach
            </td>
            {{-- <td>{{$iternity['preset']}}</td>
            <td>{{$iternity['name']}}</td>
            <td>{{$iternity['description']}}</td>
            <td>
                @foreach ($iternity['specialities'] as $speciality)
                    {{$speciality.', '}}
                @endforeach
            </td>
            <td>
                @foreach ($iternity['locations'] as $location)
                    {{$location.', '}}
                @endforeach
            </td> --}}

        </tr>
        @endforeach
    </table>

    <h3><u>Iternity in details</u></h3>

    @foreach ($record->iternity as $iternity)
        <h1>Day {{$iternity['days']}}</h1>
        <h2>{{$iternity['preset']}}</h2>
        <p> {{$iternity['description']}} </p>
        Specialities:
        <ul>
            @foreach ($iternity['specialities'] as $speciality)
                    <li>{{$speciality}}</li>
                @endforeach
        </ul>
        Location to Cover:
        <ul>
            @foreach ($iternity['locations'] as $location)
                    <li>{{$location}}</li>
                @endforeach
        </ul>
    @endforeach


    <h3><u>Room Details</u></h3>
    <table style="width: 100%">
        <tr>
            <th>Location</th>
            <th>No of Days</th>
            <th>No of Rooms</th>
            <th>Hotel Type</th>
            <th>Hotel Name</th>
            <th>Room Type</th>
            <th>Price</th>
            <th>Adult Mattress</th>
            <th>Child without Mattress</th>
            <th>Child With Mattress</th>
            <th>Extra meal Price</th>
            <th>MAP Price</th>
            <th>AP Price</th>
        </tr>

            @foreach ($record->rooms as $room)
                <tr>
                    <td>{{$room['location']}}</td>
                    <td>{{$room['days']}}</td>
                    <td>{{$room['no_of_room']}}</td>
                    <td>
                        @php $temp = \App\Models\HotelCategory::find($room['hotel_type']) @endphp
                        {{$temp->category}}
                    </td>
                    <td>
                        @php $temp = \App\Models\Hotel::find($room['hotel_name']) @endphp
                        {{$temp->hotelName}}
                    </td>
                    <td>
                        @php $temp = \App\Models\RoomCategory::find($room['room_type']) @endphp
                        {{$temp->category}}
                    </td>
                    <td>{{'₹ '.$room['price']}}</td>
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
            @endforeach
    </table>

    <h3><u>CRUZ</u></h3>

    <table>
        <tr>
            <th>Days</th>
            <th>Cruz</th>
            <th>Source</th>
            <th>Destination</th>
            <th>Price adult</th>
            <th>Price Infant</th>
        </tr>
        @foreach ($record->cruz as $cruz)
        <tr>
            <td>{{$cruz['days']}}</td>
            <td>{{$cruz['cruz']}}</td>
            <td>{{$cruz['source']}}</td>
            <td>{{$cruz['destination']}}</td>
            <td>{{'₹'.$cruz['price_adult'].'/-'}}</td>
            <td>{{'₹'.$cruz['price_infant'].'/-'}}</td>
            @php
                $totalcruz = $totalcruz + $cruz['price']
            @endphp
        </tr>
        @endforeach
    </table>

    <h3><u>Vehicle</u></h3>

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

    <h3><u>Addons</u></h3>
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
                <td>{{$addon['addon']}}</td>
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
    <br><br>

    <table>
        <tr>
            <th></th>
            <th>Per Person Rate Net</th>
            <th>Nos</th>
            <th>Total</th>
        </tr>
        <tr>
            <td>Per Person on DBL(Double Bed Room)</td>
            <td>
                @php
                if($totalcustomers>1){
                    $totalroom = ($totalroom/2);
                }
                    $grandtotaladult = $totalroom  +  $totalextrameal + $totalmap + $totalap + $totalcruz + $totalvehicle + $totaladdon;
                @endphp
                {{$grandtotaladult}}
            </td>
            <td>
                {{$totalcustomers}}
            </td>
            <td>{{$grandtotaladult*$totalcustomers.'.00'}}</td>
        </tr>
        <tr>
            <td>Extra Adult</td>
            <td>
                @php
                    $grandtotalextraadult = $totaladultmatress +  $totalextrameal + $totalmap + $totalap + $totalcruz + $totalvehicle + $totaladdon;
                @endphp
                {{$grandtotalextraadult}}
            </td>
            <td>
                {{$extracustomer}}
            </td>
            <td>{{$grandtotalextraadult*$extracustomer.'.00'}}</td>
        </tr>
        <tr>
            <td>Child With Bed Cost</td>
            <td>
                @php
                    $grandtotalchildwithbed = $childwithbed;
                @endphp
                {{$grandtotalchildwithbed*$record->customers->childgreaterthan5}}
            </td>
            <td>
                {{$record->customers->childgreaterthan5}}
            </td>
            <td>{{$grandtotalchildwithbed*$record->customers->childgreaterthan5.'.00'}}</td>
        </tr>
        <tr>
            <td>Child Without Bed Cost</td>
            <td>
                @php
                    $grandtotalchildwithoutbed = $childwithoutbed;
                @endphp
                {{$grandtotalchildwithoutbed*$record->customers->childlessthan5}}
            </td>
            <td>
                {{$record->customers->childlessthan5}}
            </td>
            <td>{{$grandtotalchildwithoutbed*$record->customers->childlessthan5.'.00'}}</td>
        </tr>
        <tr>
            <th colspan="3">Total</th>
            <td>{{'₹ '.($grandtotalchildwithoutbed*$record->customers->childlessthan5) + ($grandtotalchildwithbed*$record->customers->childgreaterthan5) + ($grandtotalextraadult*$extracustomer) + ($grandtotaladult*$totalcustomers).'.00'}}</td>
        </tr>
    </table>

</body>
</html>
