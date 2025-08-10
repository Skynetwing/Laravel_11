@extends('layouts.app')
@section('title', 'Razorpay')
@section('style')
    <link href="{{ asset('') }}" rel="stylesheet" />
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb d-flex justify-content-between">
            <div class="pull-left">
                <h2>Payment Page</h2>
                <button class="btn btn-info" id="rzp-button1">Pay</button>
            </div>
        </div>
    </div>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        var options = {
            "key": "{{ $key }}", // Enter the Key ID generated from the Dashboard
            "amount": {{ $amount }}, // Amount is in currency subunits.
            "currency": "{{ $currency }}", // Currency code
            "name": "Skynetwing", //your business name
            "description": "Test Transaction",
            "image": "https://example.com/your_logo",
            "order_id": "{{ $order_id }}", // This is a sample Order ID. Pass the `id` obtained in the response of Step 1
            "handler": function(response) {
                window.location.href = "{{ route('razorpay.callback') }}?razorpay_payment_id=" + response
                    .razorpay_payment_id + "&razorpay_order_id=" + response.razorpay_order_id +
                    "&razorpay_signature=" + response.razorpay_signature;
            },
            // "callback_url": "https://eneqd3r9zrjok.x.pipedream.net/",
            "prefill": { //We recommend using the prefill parameter to auto-fill customer's contact information especially their phone number
                "name": "{{ auth()->user()->name ?? '' }}", //your customer's name
                "email": "{{ auth()->user()->email ?? '' }}",
                "contact": "{{ auth()->user()->phone ?? '9876543210' }}" //Provide the customer's phone number for better conversion rates
            },
            "notes": {
                "address": "Razorpay Corporate Office"
            },
            "theme": {
                "color": "#F37254"
            }
        };
        var rzp1 = new Razorpay(options);
        rzp1.on('payment.failed', function(response) {
            // alert(response.error.code);
            // alert(response.error.description);
            // alert(response.error.source);
            // alert(response.error.step);
            // alert(response.error.reason);
            // alert(response.error.metadata.order_id);
            // alert(response.error.metadata.payment_id);

            console.log(response);

        });

        document.getElementById('rzp-button1').onclick = function(e) {
            rzp1.open();
            e.preventDefault();
        }
    </script>
@endsection
