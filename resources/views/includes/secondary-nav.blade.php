<nav id="secondaryNav" class="navbar px-0 navbar-secondary">
    <div class="container">
        <div class="navbar-inner">
            <form id="secondarySearchForm" class="input-group secondary-search" action="">
                <input id="secondarySearch" type="text" class="form-control" placeholder="Enter an address, city, or ZIP code" aria-label="Enter an address, city, or ZIP code"
                       aria-describedby="basic-addon" name="q" value="{{ FormHelper::value('q') }}">
                <div class="input-group-append">
                    <button class="btn btn-secondary" type="submit" form="secondarySearchForm" value="Submit">
                        <svg class="d-inline-block d-sm-none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"/>
                        </svg>
                        <span class="d-none d-sm-inline">Search</span>
                    </button>
                </div>
            </form>
            @if ($pageType === 'buy')
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" type="checkbox" id="listingType1" name="type[]" value="House" {{ FormHelper::checked('type', 'House') }}>
                    <label class="custom-control-label" for="listingType1">House</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" type="checkbox" id="listingType2" name="type[]" value="Multi-Family House" {{ FormHelper::checked('type', 'Multi-Family House') }}>
                    <label class="custom-control-label" for="listingType2">Multi-Family</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" type="checkbox" id="listingType3" name="type[]" value="Land" {{ FormHelper::checked('type', 'Land') }}>
                    <label class="custom-control-label" for="listingType3">Land</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" type="checkbox" id="listingType4" name="type[]" value="Commercial" {{ FormHelper::checked('type', 'Commercial') }}>
                    <label class="custom-control-label" for="listingType4">Commercial</label>
                </div>
             @endif
        </div>
    </div>
</nav>