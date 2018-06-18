<!-- TODO remove later - replaced by jquery -->

<div class="card">
    <div class="card-background b-lazy" data-src="{{ $listing['photos'][0] }}">
        <span class="loader"></span>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-7 pr-1">
                <h4 class="card-title text-primary">{{ ListingHelper::determineTitle($listing['property']['type']) }}</h4>
            </div>
            <div class="col-5 pl-1 text-right">
                <h4 class="card-title"> ${{ number_format($listing['listPrice']) }}</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-7 pr-1">
                <p class="card-text"> {{ $listing['address']['full'] }}, {{ $listing['address']['city'] }}, {{ $listing['address']['state']}} </p>
            </div>
            <div class="col-5 pl-1 text-right">
                <p class="card-text">
                    <strong>{{ $listing['property']['bedrooms'] }}</strong> bds
                    <strong>{{ $listing['property']['bathrooms'] }}</strong> ba
                    <strong>{{ number_format($listing['property']['area']) }}</strong> sqft
                </p>
            </div>
        </div>

    </div>
</div>