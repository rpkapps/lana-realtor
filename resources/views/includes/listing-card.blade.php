<div class="card">
    <div class="card-background" style="background-image: url({{ $listing['photos'][0] }})" ></div>
    <div class="card-body">
        <div class="row">
            <div class="col-8">
                <h4 class="card-title">{{ SimplyRetsHelper::determineTitle($listing['property']['type']) }}</h4>
            </div>
            <div class="col-4">
                <h4 class="card-title"> ${{ $listing['listPrice'] }}</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-8">
                <p class="card-text"> {{ $listing['address']['full'] }} , {{ $listing['address']['city'] }} , {{ $listing['address']['state']}} </p>
            </div>
            <div class="col-4">
                <p class="card-text"> {{ $listing['property']['bedrooms'] }}bds {{ $listing['property']['bathrooms'] }}ba {{ $listing['property']['area'] }}sqft  </p>
            </div>
        </div>

    </div>
</div>