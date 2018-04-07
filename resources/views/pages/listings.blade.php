@extends('layout.sub-page')

@section('title', 'Listings')

@section('content')
    <div id="cardListings" class="card-listings">
        {{--@foreach ($listings as $listing)--}}
            {{--@include('includes.listing-card')--}}
        {{--@endforeach--}}
    </div>
    <div id="pagination"></div>
@endsection