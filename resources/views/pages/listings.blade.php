@extends('layout.sub-page')

@section('title', 'Listings')

@section('content')
    <div class="card-listings">
        @foreach ($listings as $listing)
            @include('includes.listing-card')
        @endforeach
    </div>
@endsection