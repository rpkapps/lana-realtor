@extends('layout.listings')

@section('title', $title)

@section('content')

    <div class="d-flex justify-content-center">
        <div id="listingViewTabs" class="btn-group btn-tabs thin" role="group">
            <button id="cardViewBtn" type="button" class="btn btn-outline-light {{ FormHelper::activeClassIf('view', '!=', 'map') }}" data-toggle="btn-tab" data-target="#cardView">Tile View</button>
            <button id="mapViewBtn" type="button" class="btn btn-outline-light {{ FormHelper::activeClassIf('view', '==', 'map') }}" data-toggle="btn-tab" data-target="#mapView">Map View</button>
        </div>
    </div>

    <div class="sort-wrapper" style="{{ FormHelper::activeClassIf('view', '==', 'map') ? 'display: none;' : ''}}">
        <label for="sort">Sort By:</label>
        <select id="sort">
            @foreach (FormHelper::getSortOptions() as $option => $optionLabel)
                <option {{ FormHelper::selected('sort', $option) }} value="{{ $option }}">{{ $optionLabel }}</option>
            @endforeach
        </select>
        <span class="sort-dropdown">{{ FormHelper::getSelectedSortOptionLabel() }}</span>
    </div>

    <div class="btn-tab-content {{ FormHelper::activeClassIf('view', '!=', 'map') }}" id="cardView">
        <div id="cardListings" class="card-listings"></div>
        <div id="pagination"></div>
    </div>
    <div class="btn-tab-content {{ FormHelper::activeClassIf('view', '==', 'map') }}" id="mapView"></div>
@endsection