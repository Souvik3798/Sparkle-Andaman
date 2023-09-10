<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href={{asset('images/favicon.png')}} rel="icon" />
<title>Sparkle Andaman | Itinerary </title>

<!-- Web Fonts
======================= -->
{{-- <link rel='stylesheet' href='{{url('https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900')}}' type='text/css'> --}}

<!-- Stylesheet
======================= -->
<link href={{asset('vendor/bootstrap/css/bootstrap.min.css')}} rel="stylesheet">
<link href={{asset('vendor/font-awesome/css/all.min.css')}} rel="stylesheet">
<link rel="stylesheet" type="text/css" href={{asset('css/stylesheet.css')}} />
</head>
<body>
<!-- Container -->
<div class="container-fluid ">
  <div class="itinerary-container">
  <!-- Header -->
  <header>
    <div class="row align-items-center">
      <div class="col-sm-7 text-center text-sm-left mb-3 mb-sm-0"> <img id="logo" src={{asset('images/logo.png')}} title="Sparkle Andaman" alt="Sparkle Andaman" /> </div>
      <div class="col-sm-5 text-center text-sm-right">
        <h4 class="text-6 mb-0">Andaman Island Tour Package
        </h4>
      </div>
    </div>
    <hr class="my-4">
  </header>
  <!-- Header End -->

  <!-- Main Content -->
  <main>
    <div class="row">
      <div class="col-sm-4"> <strong class="font-weight-600">Full Name:  </strong>
        <p>  {{$record->customers->customer}}   </p>

      </div>
      <div class="col-sm-4"> <strong class="font-weight-600">Contact:</strong>
        <p>  {{$record->customers->number}}   </p>
      </div>
      <div class="col-sm-4"> <strong class="font-weight-600">Customer ID:</strong>
       <p>CID-{{$record->customers->cid}}</p>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-sm-4"> <strong class="font-weight-600">Arrival:</strong>
        <p>  {{date('F d, Y',strtotime($record->customers->dateofarrival))}}   </p>
        <strong class="font-weight-600">Departure:</strong>
        <p>  {{date('F d, Y',strtotime($record->customers->dateofdeparture))}}   </p>
      </div>
      <div class="col-sm-4"> <strong class="font-weight-600">Adults:</strong>
        <p>  {{$record->customers->adults.' Nos'}}   </p>
        <strong class="font-weight-600">Children(2-5):</strong>
        <p>  {{$record->customers->childlessthan5.' Nos'}}   </p>
      </div>
      <div class="col-sm-4"> <strong class="font-weight-600">Children(5-12):</strong>
        <p>  {{$record->customers->childgreaterthan5.' Nos'}}   </p>
        {{-- <strong class="font-weight-600">Total Rooms:</strong>
        <p>     </p> --}}
      </div>
    </div>
    <br><br><hr><br>
    <div class="card">
      <div class="card-header"><div class="row align-items-center trip-title justify-content-center">
        <div class="col-5 col-md-auto text-center text-md-center">
          <h6 class="m-0">PACKAGE NAME<br></h6>
        </div>
        <div class="col-2 col-md-auto text-8 text-black-50 text-center trip-arrow">➝</div>
        <div class="col-5 col-md-auto text-center text-md-center">
          <h5 class="m-0">{{$record->name}}</h5>
        </div>
        <br>
        <div class="row justify-content-center">
          <div class="col-12 col-md-auto text-3 text-dark text-center mt-2 mt-md-0 ml-md-auto">
            Duration: {{$record->days}} Days {{$record->nights}} Nights
          </div>
      </div>
      </div>
      <hr>
      <div class="card-body"><div class="row"><hr>

        @foreach ($record->iternity as $iternity)

            <div class="col-4 col-sm-3 text-center company-info"> <span class="text-4 font-weight-500 text-dark mt-1 mt-lg-0">Day</span> {{$iternity['days']}} <span class="text-muted d-block">{{date('F d, Y',strtotime($iternity['date']))}}</span></div>
            <div class="col-4 col-sm-6 text-center time-info mt-3 mt-sm-0"> <span class="text-5 font-weight-500 text-dark"> Arrival at {{$iternity['destination']}}, famous for
                @foreach ($iternity['specialities'] as $speciality)
                    {{$speciality.', '}}
                @endforeach

            </span> <span class="text-muted d-block"></span> </div>
            <div class="col-4 col-sm-3 text-center time-info mt-3 mt-sm-0"> <span class="text-5 font-weight-500 text-dark">

                @foreach ($iternity['locations'] as $location)
                    {{strtoupper($location).', '}}
                @endforeach

            </span> </div>

            <div class="mb-3" style="width:100%"> </div>
            <div class="mb-3" style="width:100%"> </div>

        @endforeach

      </div>
    </div>
  </div>

    <br><hr>


    @foreach ($hotelrates as $hotel => $rate)

    <div class="card">

      <div class="card">
        <div class="card-header">
            @php
                $cat = \App\Models\HotelCategory::find($hotel)
            @endphp
          <h5 class="m-0">{{$cat->category}} Cost Rs.{{$hotelrates[$hotel] + (($record->margin/100)*$hotelrates[$hotel])}}/- (Excluding 5% GST)
          </h5>
        </div>
      </div>
      <br>
      @foreach ($record->rooms as $room)
        @if ($room['hotel_type'] == intval($hotel))

            <div class="card">
            <div class="card-header">
                <h5 class="m-0">Hotel Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                <div class="col-sm-3 border-right"><span>Hotel Details:</span><br><hr>
                <strong class="font-weight-600">
                    Day: {{$room['days']}}
                </strong><br>
                <strong class="font-weight-600">
                    @php $hotels = \App\Models\Hotel::find($room['hotel_name']) @endphp
                    {{$hotels->hotelName}}
                </strong>
                    <br><span>Place: {{$room['location']}}</span>
                    <br><span>Date: {{date('F d, Y',strtotime($room['date']))}}</span>
                    <br><br><strong class="font-weight-600">Includes:</strong>
                    <p>{{$hotels->Ammenities}}</p>
                    <strong class="font-weight-600">Room Type:</strong>
                    <p class="mb-0">
                        @php $temp = \App\Models\RoomCategory::find($room['room_type']) @endphp
                                        {{$temp->category}}
                    </p>
                </div>
                <div class="col-sm-9">
                    <div class="row mt-n3">
                        <div class="col-sm-6 mt-3">
                            <strong class="font-weight-600">
                                <img src="https://www.sparkleandaman.com/uploads/hotel/{{$hotels->hotelimages->img}}" height="200px" alt="" srcset="">
                            </strong>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        @endif
       @endforeach
    </div>
    @endforeach
  </div>

      <br><hr>


      <div class="card">
        <div class="card">
      <div class="card-header">
        <div class="row align-items-center trip-title">
          <div class="col-12 col-md-auto text-3 text-dark text-center mt-2 mt-md-0 ml-md-auto"><strong>Package Includes</strong></div>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-12 col-sm-12 text-left mt-3 mt-sm-0"> <span class="text-2 font-weight-500 text-dark">
            @foreach ($record->inclusions as $inclusion )
                <span>✔ {{ucwords($inclusion)}}</span>
                <br><br>
            @endforeach
          </div>
        </div>
      </div>
    </div>


    <div class="card mt-4">
      <div class="card-header">
        <div class="row align-items-center trip-title">
          <div class="col-12 col-md-auto text-3 text-dark text-center mt-2 mt-md-0 ml-md-auto"><strong>Package Excludes</strong></div>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-12 col-sm-12 text-left mt-3 mt-sm-0"> <span class="text-2 font-weight-500 text-dark">
            @foreach ($record->exclusions as $exclusion )
                <span>❌ {{ucwords($exclusion)}}</span>
                <br><br>
            @endforeach

          </div>
        </div>
      </div>
    </div>
  </div>


    <br><hr>

    <div class="card">

      <div class="card">
        <div class="card-header">
          <h5 class="m-0">Detailed Itinerary</h5>
        </div>
      </div>
      <br>
      <br>
      @foreach ($record->iternity as $iternity)
                <div class="card">
                <div class="card-header">
                    <strong class="font-weight-600"><strong>Day {{$iternity['days']}}:</strong> Arrival at {{$iternity['destination']}}, locations:
                    @foreach ($iternity['locations'] as $location)
                        {{$location.', '}}
                    @endforeach famous for
                    @foreach ($iternity['specialities'] as $speciality)
                        {{$speciality.', '}}
                    @endforeach</strong>
                </div>
                <div class="card-body">
                    <div class="row">
                    <div class="col-12 col-sm-12 text-left mt-3 mt-sm-0">
                        <span>{{$iternity['description']}}
                        </span>
                    </div>
                    </div>
                </div>
    @endforeach
    </div>
      <br>
      <br>

    </div>
</main>
  <!-- Main Content End -->

  <!-- Footer -->
  <footer style="background-color: black; width:100%; margin:0;" class="text-center mt-3">

  <br>
  <br>
  <br><p style="color: #fff;"><img id="footer" src={{asset('images/logo-wo-bg.png')}} title="Sparkle Andaman" alt="Sparkle Andaman" /><br>
      Nayabasti, Bambooflat, A & N Islands </p><br>
    <hr>
    <p style="color: #fff;">Contact Us:</p><p style="color: #fff;"> 📞 +91-7695062011  &nbsp;&nbsp;&nbsp;&nbsp;  💌 info@sparkleandaman.com</p>
    <div class="btn-group btn-group-sm d-print-none"> <a href="javascript:window.print()" class="btn btn-light border text-black-50 shadow-none"><i class="fa fa-print"></i> Print</a> <a href="" class="btn btn-light border text-black-50 shadow-none"><i class="fa fa-download"></i> Download</a> </div>
  </footer>
  <!-- Footer End -->

<!-- Container End -->
  </div>
</div>

<!-- Back to My Account Link -->
<p class="text-center d-print-none"><a href="#">&laquo; Back to My Account</a></p>
</body>
</html>
