
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation Voucher</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border: 2px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        h2 {
            background-color: #f0f0f0;
            padding: 10px;
            margin-top: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        td {
            font-size: 14px;
            word-break: break-word; /* Allow long words to break into a new line */
        }

        th, td:nth-child(odd) {
            background-color: #f0f0f0;
        }

        /* Media query for mobile view */
        @media (max-width: 600px) {
            body{
                zoom:0.56;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Confirmation Voucher</h1>

        <!-- Agent/Client Information -->
        <h2>Agent/Client Information</h2>
        <table>
            <tr>
                <th>Customer Code</th>
                <td>CT-{{$record->customers->cid}}</td>
                <th>Agent/Client Name</th>
                <td>{{$record->customers->customer}}</td>
            </tr>
            <tr>
                <th>Phone</th>
                <td>+91-{{$record->customers->number}}</td>
                <th>No. of persons</th>
                <td>{{$record->customers->adults+$record->customers->childgreaterthan5+$record->customers->childlessthan5}}</td>
            </tr>
        </table>

        <!-- Arrival and Departure Information -->
        <h2>Arrival and Departure Information</h2>
        <table>
            <tr>
                <th>Arrival Date</th>
                @php
                    $package = \App\Models\CustomPackage::find($record->custom_package);

                @endphp
                <td>{{date('F d Y',strtotime($record->customers->dateofarrival))}}</td>
                <th>Departure Date</th>
                <td>{{date('F d Y',strtotime($record->customers->dateofdeparture))}}</td>
            </tr>
            <tr>
                <th>Booking Date</th>
                <td>{{date('F d Y',strtotime($package->created_at))}}</td>
                <th>Booked by</th>
                <td>{{$record->customers->customer}}</td>
            </tr>
        </table>

        <!-- Total Amount and Payment Details -->
        <h2>Total Amount</h2>
        <table>
            <tr>
                <th>Total Amount</th>
                <td>Rs.{{$record->total_amount}}</td>
                <th>Amount Paid</th>
                <td>Rs. {{$record->amount_paid}}</td>
            </tr>
        </table>
        <h2>Payment Details</h2>
        <table>
            <tr>
                <th>Payment Date</th>
                <td>{{date('F d Y',strtotime($record->payment_date))}}</td>
                <th>Bank</th>
                <td>{{$record->bank}}</td>
            </tr>
            <tr>
                <th>Reference</th>
                <td>{{$record->reference}}</td>
                <th>Payment Status</th>
                <td>Paid: Rs. {{$record->amount_paid}}<br>Balance: Rs. {{$record->total_amount-$record->amount_paid}}</td>
            </tr>
        </table>

        <!-- Traveller Details -->
        <h2>Traveller Details</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Contact</th>
                <th>Adults</th>
                <th>Children (<5)</th>
                <th>Children (5-12)</th>
            </tr>
            <tr>
                <td>{{$record->customers->customer}}</td>
                <td>+91-{{$record->customers->number}}</td>
                <td>{{$record->customers->adults.' Nos'}}</td>
                <td>{{$record->customers->childlessthan5.' Nos'}}</td>
                <td>{{$record->customers->childgreaterthan5.' Nos'}}</td>
            </tr>
        </table>

        <!-- Vehicle and Ferry Details -->
        <!-- Vehicle Details -->
<h2>Vehicle Details</h2>
<table>
    <tr>
        <th>Days</th>
        <th>Vehicle</th>
        <th>Route</th>
    </tr>
    @foreach ($package->vehicle as $vehicle)
    <tr>
        <td>{{$vehicle['days']}}</td>
        @php
            $vehicles = \App\Models\Cabs::find($vehicle['vehicle'])->first();
        @endphp
        <td>{{$vehicles->Title}}</td>
        <td>{{$vehicle['source']}} to {{$vehicle['destination']}}</td>
    </tr>
    @endforeach
</table>

<!-- Ferry Details -->
<h2>Ferry Details</h2>
<table>
    <tr>
        <th>Days</th>
        <th>Ferry</th>
        <th>Route</th>
    </tr>
    @foreach ($package->cruz as $cruz)
    <tr>
        <td>{{$cruz['days']}}</td>
        @php
            $cruzs = \App\Models\Ferry::find($cruz['cruz'])->first();
        @endphp
        <td>{{$cruzs->Title}}</td>
        <td>{{$cruz['source']}} to {{$cruz['destination']}}</td>
    </tr>
    @endforeach
</table>


        <!-- Hotel Details -->
        <h2>Hotel Details</h2>
        <table>
            <tr>
                <th>Hotel Name</th>
                <th>Checkin</th>
                <th>Checkout</th>
                <th>Room Type</th>
                <th>No. of Rooms</th>
            </tr>
            @foreach ($hotelrates as $hotels => $rate)
                @php
                    $cat = \App\Models\HotelCategory::find($hotels);
                @endphp
                @foreach ($custompackage->rooms as $room)
                    @if ($room['hotel_type'] == intval($hotels))
                        @if($room['hotel_type'] == $record['hotel_type'])
                        @php
                            $hotel = \App\Models\Hotel::find($record['hotel_type']);
                        @endphp
                            <tr>
                                <td>{{$hotel['hotelName']}}</td>
                                <td style="font-size: 12px;">{{$hotel['checkIn']}}</td>
                                <td style="font-size: 12px;">{{$hotel['checkOut']}}</td>
                                @php
                                    $roomtype = \App\Models\RoomCategory::find($room['room_type']);
                                @endphp
                                <td>{{$roomtype->category}}</td>
                                <td>{{$room['no_of_room']}}</td>
                            </tr>
                        @endif
                    @endif
                @endforeach
            @endforeach
        </table>
        <footer  class="text-center mt-3">

        <br>
        <br>
        <br><img style="width:100%; margin:0;" id="footer" src={{asset('images/footer.PNG')}} title="Sparkle Andaman" alt="Sparkle Andaman" />
        </footer>
    </div>
</body>
</html>
