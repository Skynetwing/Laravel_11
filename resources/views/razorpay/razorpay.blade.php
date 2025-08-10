@extends('layouts.app')
@section('title', 'Razorpay')
@section('style')
    <link href="{{ asset('') }}" rel="stylesheet" />
@endsection
@section('content')
    <div class="row d-flex justify-content-center">
        <div class="razorpay_form col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3>Razorpay Payment Gateway</h3>
                </div>
                <div class="card-body">
                    <form action="{{route('razorpay.payment')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="text" class="form-control" name="amount" id="amount"
                                placeholder="Enter Amount" required>
                        </div>
                        <div class="submit text-center">
                            <button class="btn btn-success" type="submit">Pay</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script src="{{ asset('') }}"></script>
@endsection
