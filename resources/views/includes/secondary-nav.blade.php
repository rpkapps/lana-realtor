<nav id="secondaryNav" class="navbar px-0 navbar-secondary">
    <div class="container">
        <form id="secondarySearchForm" class="search-form" action="">
            <div class="input-group secondary-search">
                <input type="text" class="form-control" placeholder="Enter a city" aria-label="Enter a city"
                       aria-describedby="basic-addon">
                <div class="input-group-append">
                    <button class="btn btn-secondary" type="submit" form="secondarySearchForm" value="Submit">Search</button>
                </div>
            </div>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="listingType1" name="listing_type" value="residential">
                <label class="custom-control-label" for="listingType1">Residential</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="listingType2" name="listing_type" value="multi-family">
                <label class="custom-control-label" for="listingType2">Multi-Family</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="listingType3" name="listing_type" value="vacant-land">
                <label class="custom-control-label" for="listingType3">Vacant Land</label>
            </div>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="listingType4" name="listing_type" value="commercial">
                <label class="custom-control-label" for="listingType4">Commercial</label>
            </div>
        </form>
    </div>
</nav>