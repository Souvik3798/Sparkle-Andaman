<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
        @foreach ($hotelrates as $hotel => $rate)
            @php
                $cat = \App\Models\HotelCategory::find($hotel)
            @endphp
            <h1>{{$cat->category}}</h1>
                Total Cost: <h3> ₹ {{$hotelrates[$hotel]}}/- </h3><br>
                @foreach ($record->rooms as $room)
                    @if ($room['hotel_type'] == intval($hotel))
                        Day: {{$room['days']}},Date:{{date('F d , Y',strtotime($room['date']))}},Hotel: @php $hotels = \App\Models\Hotel::find($room['hotel_name']) @endphp
                        {{$hotels->hotelName}}<br>
                        {{-- <img src="https://www.sparkleandaman.com/uploads/hotel/{{$hotels->hotelimages->img}}" height="200px" alt="" srcset=""><br> --}}
                    @endif
                @endforeach
        @endforeach
</body>
</html>
