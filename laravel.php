@extends('website.layouts.master')
@section('title', '| Payment Success')
@section('page-css-link')@endsection
@section('page-css') @endsection
@section('main-content')
<!-- Page Container -->
<style type="text/css">
    .col-md-6 {
        width: 50%;
    }
    .col-md-12 {
           width: 100%;
    }
</style>
<div class="container-fluid form-setup">
    <div class="containe form-box">
        <div class="form-setup-area">
            <div class="row">
                <div class="col-md-12">
                    <!-- get this div id -->
                    <div  id="payment-div1">
                    <h2 class="text-center" style="color: #4caf50;">{{$status}}</h2>

                    <!-- if H3 contains THANK YOU FOR YOUR PAYMENT. we capture it as conversion on Gtag -->
                    <h3 class="text-center" style="color: #4caf50;">{{$message}}</h3>
                    <hr>
                    <div class="row">
                        <div class="col-md-12 text-center" style="color:#f40;text-transform:uppercase">
                            <h1 >CLAIM NUMBER</h1> 
                            <h2> {{$client->claim_number}}</h2>

                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Full Name:</strong> 
                            <p>{{$client->full_name}}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Email Address:</strong> 
                            <p>{{$client->email}}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Address:</strong> 
                            <p> {{@$client->autocomplete_address}}{{ @$client->postal_code }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>City:</strong> 
                            <p>{{$client->city}}</p>
                        </div>
                        <!--  <div class="col-md-6">
                            <strong>State:</strong> 
                            <p>{{$client->state}}</p>
                        </div>                        
                        <div class="col-md-6">
                            <strong>Country:</strong> 
                            <p>{{$client->country}}</p>
                        </div> -->
                        <div class="col-md-6">
                            <strong>Phone Number:</strong> 
                            <p>{{$client->telephone}}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Lost Item Type:</strong> 
                            <p>{{$client->lost_item_type}}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Where did you lose your item:</strong> 
                            <p>{{@$client->lostPlace->place}}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>{{@$client->lostPlace->label}}:</strong> 
                            <p>{{ $client->getAirport->airport ?? @$client->complete_address}}</p>
                        </div>
                        @if(isset($client->lostPlace->label2))

                        <div class="col-md-6">
                            <strong>{{'Airport Locations'}}:</strong> 
                            <p>{{@$client->getAirportLocation->name}}</p>
                        </div>

                        @if(isset($client->terminal_gate_seat_no) && $client->terminal_gate_seat_no != null)
                        <div class="col-md-6">
                            <strong>{{'TERMINAL / GATE / SEAT NUMBER'}}:</strong> 
                            <p>{{@$client->terminal_gate_seat_no}}</p>
                        </div>
                        @endif

                        <div class="col-md-6">
                            <strong>{{@$client->lostPlace->label2}}:</strong> 
                            <p>{{ $client->getAirline->airline ?? @$client->complete_address_2}}</p>
                        </div>

                        <div class="col-md-6">
                            <strong>{{'FLIGHT NUMBER / DEPARTURE AIRPORT / SEAT NUMBER'}}:</strong> 
                            <p>{{@$client->flight_dep_air_seat_no}}</p>
                        </div>                       

                        @endif
                        
                        <div class="col-md-6">
                            <strong>Lost Item Date:</strong> 
                            <p>{{$client->lost_item_date}}</p>
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>IP:</strong> {{$client->ip}}
                        </div>
                        <div class="col-md-6">
                            <strong>Date:</strong> {{$client->created_at}}
                        </div>
                        <div class="col-md-6">
                            <strong>Device Details:</strong> {{$client->user_agent}}
                        </div>
                        <div class="col-md-6">
                            <strong>Location:</strong> {{$client->ip_location}}
                        </div>
                    </div>
                    <hr>
                   </div>
                     <div class="row">
                        <div class="col-md-12 text-center">
                            <input type="button" class="btn btn-primary" value="Print" onclick="printDiv()"> 
                        </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid form-setup d-none" id="payment-div">
    <div class="containe form-box">
        <div class="form-setup-area">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center" style="color: #4caf50; text-align: center;">{{'RECEIPT'}}</h2>
                    <h3 class="text-center" style="color: #4caf50; text-align: center;">{{$message}}</h3>
                    <hr>
                    <div class="row">
                        <div class="col-md-12 text-center" style="color:#f40;text-transform:uppercase; text-align: center;">
                            <h1 >CLAIM NUMBER</h1> 
                            <h2> {{$client->claim_number}}</h2>

                        </div>
                    </div>
                    <hr>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page Container -->
@endsection
@section('page-js-link') @endsection
@section('page-js')

<!-- Script to track Payment success message and payment ID-->
<script>
window.addEventListener('load',function(){

  var y = 0;
  var myVar1 = setInterval(function(){
    if(y == 0){
      if(document.querySelector("#payment-div1 > h3").innerText.indexOf('THANK YOU FOR YOUR PAYMENT.')!=-1)
      {
       gtag('event', 'conversion', {
      'send_to': 'AW-758624954/lbfwCN7Ez4MYELrl3ukC',
      'transaction_id': document.querySelector("#payment-div1 > div:nth-child(4) > div > h2").innerText
  });
        clearInterval(myVar1);
        y = 1;
      }
    }
  }, 1000);
 
});
</script>

<!-- BEGIN Script to print the content of a div -->
<script>
    function printDiv() {
        var divContents = document.getElementById("payment-div").innerHTML;
        var a = window.open('', '', 'height=1000, width=1000');
        a.document.write(divContents);
        a.document.close();
        a.print();
    }
</script>
<!-- END Script to print the content of a div -->

@endsection
