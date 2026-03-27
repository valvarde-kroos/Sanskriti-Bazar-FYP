@extends('layout.main')

@section('content')
<h2>Your Cart</h2>

@foreach($cartItems as $item)
    <p>
        {{ $item->product->name }} |
        Qty: {{ $item->quantity }} |
        Rs. {{ $item->product->price * $item->quantity }}
    </p>
@endforeach

<form action="{{ route('order.place') }}" method="POST">
    @csrf
    <button>Place Order</button>
</form>
@endsection
