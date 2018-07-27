@extends('layout.listings')

@section('title', $title)

@section('content')

    <div class="d-flex justify-content-center">
        <div id="listingViewTabs" class="btn-group btn-tabs thin" role="group">
            <button id="cardViewBtn" type="button" class="btn btn-outline-light {{ FormHelper::activeClassIf('view', '!=', 'map') }}" data-toggle="btn-tab" data-target="#cardView">Tile View</button>
            <button id="mapViewBtn" type="button" class="btn btn-outline-light {{ FormHelper::activeClassIf('view', '==', 'map') }}" data-toggle="btn-tab" data-target="#mapView">Map View</button>
        </div>
    </div>

    <div class="btn-tab-content {{ FormHelper::activeClassIf('view', '!=', 'map') }}" id="cardView">
        <div id="cardListings" class="card-listings"></div>
        <div id="pagination"></div>
    </div>
    <div class="btn-tab-content {{ FormHelper::activeClassIf('view', '==', 'map') }}" id="mapView"></div>
@endsection