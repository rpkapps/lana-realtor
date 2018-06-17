<nav id="secondaryNav" class="navbar px-0 navbar-secondary">
    <div class="container">
        <div class="navbar-inner">
            <form id="secondarySearchForm" class="input-group secondary-search" action="">
                <input id="secondarySearch" type="text" class="form-control" placeholder="Enter an address, city, or ZIP code" aria-label="Enter an address, city, or ZIP code"
                       aria-describedby="basic-addon" name="q" value="{{ FormHelper::value('q') }}">
                <div class="input-group-append">
                    <button class="btn btn-secondary" type="submit" form="secondarySearchForm" value="Submit">Search</button>
                </div>
            </form>
            @if ($showNavCheckboxes)
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" type="checkbox" id="listingType1" name="type[]" value="residential" {{ FormHelper::checked('type', 'residential') }}>
                    <label class="custom-control-label" for="listingType1">Residential</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" type="checkbox" id="listingType2" name="type[]" value="multifamily" {{ FormHelper::checked('type', 'multifamily') }}>
                    <label class="custom-control-label" for="listingType2">Multi-Family</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" type="checkbox" id="listingType3" name="type[]" value="land" {{ FormHelper::checked('type', 'land') }}>
                    <label class="custom-control-label" for="listingType3">Vacant Land</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" type="checkbox" id="listingType4" name="type[]" value="commercial" {{ FormHelper::checked('type', 'commercial') }}>
                    <label class="custom-control-label" for="listingType4">Commercial</label>
                </div>
             @endif
        </div>
    </div>
</nav>