<div id="filterBar" class="btn-group filter-bar" role="group" aria-label="Button group with nested dropdown">
    <a id="filtersBtn" href="#filterBarFilters" class="btn btn-outline-light dropdown-toggle d-block d-md-none" data-toggle="collapse" aria-expanded="false">
        Filters
    </a>
    <div id="filterBarFilters" class="collapse">
        <p class="filter-header d-block d-md-none mt-3">Price</p>
        <div class="btn-group" role="group">
            <button id="filterPriceBtn" type="button" class="btn btn-outline-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false" data-default="Price">
                {{ FormHelper::formatPriceFromQuery('minprice', 'maxprice', 'Price') }}
            </button>
            <div class="dropdown-menu stay-open" aria-labelledby="btnGroupDrop1">
                <div class="form-row align-items-center">
                    <div class="col">
                        <select id="filterMinPrice" class="custom-select">
                            @foreach(FormHelper::getPrices($pageType, 'No Min') as $price => $formattedPrice)
                                <option {{ FormHelper::selected('minprice', $price) }} value="{{ $price }}">{{ $formattedPrice }}</option>
                            @endforeach
                        </select>
                    </div>
                    –
                    <div class="col">
                        <select id="filterMaxPrice" class="custom-select">
                            @foreach(FormHelper::getPrices($pageType, 'No Max') as $price => $formattedPrice)
                                <option {{ FormHelper::selected('maxprice', $price) }} value="{{ $price }}">{{ $formattedPrice }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <p class="filter-header d-block d-md-none">Area (sqft)</p>
        <div class="btn-group" role="group">
            <button id="filterAreaBtn" type="button" class="btn btn-outline-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false" data-default="Area">
                {{ FormHelper::formatAreaFromQuery('minarea', 'maxarea', 'Area') }}
            </button>
            <div class="dropdown-menu stay-open" aria-labelledby="btnGroupDrop1">
                <div class="form-row align-items-center">
                    <div id="filterMinArea" class="col">
                        <input type="number" class="form-control" inputmode="numeric" pattern="[0-9]*" data-max="5" name="minarea" value="{{ FormHelper::value('minarea') }}" placeholder="Min Area">
                    </div>
                    –
                    <div id="filterMaxArea" class="col">
                        <input type="number" class="form-control" inputmode="numeric" pattern="[0-9]*" data-max="5" name="maxarea" value="{{ FormHelper::value('maxarea') }}" placeholder="Max Area">
                    </div>
                </div>
            </div>
        </div>
        <p class="filter-header d-block d-md-none">Beds</p>
        <div class="btn-group" role="group">
            <button id="filterBdrmsBtn" type="button" class="btn btn-outline-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="additional-info">{{ FormHelper::numberPlus('minbeds') }}</span> Beds
            </button>
            <div id="filterBdrms" class="dropdown-menu" aria-labelledby="filterBdrmsBtn">
                @for ($i=0; $i<6; $i++)
                    <a class="dropdown-item {{ FormHelper::activeClass('minbeds', $i) }}" href="javascript:void(0)" data-value="{{ $i }}">{{ $i }}+</a>
                @endfor
            </div>
        </div>
        <p class="filter-header d-block d-md-none">Baths</p>
        <div class="btn-group" role="group">
            <button id="filterBathsBtn" type="button" class="btn btn-outline-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="additional-info">{{ FormHelper::numberPlus('minbaths') }}</span> Baths
            </button>
            <div id="filterBaths" class="dropdown-menu" aria-labelledby="filterBathsBtn">
                @for ($i=0; $i<6; $i++)
                    <a class="dropdown-item {{ FormHelper::activeClass('minbaths', $i) }}" href="javascript:void(0)" data-value="{{ $i }}">{{ $i }}+</a>
                @endfor
            </div>
        </div>
        <p class="filter-header d-block d-md-none">Property Type</p>
        <div class="btn-group" role="group">
            <button id="filterPropertyTypeBtn" type="button" class="btn btn-outline-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Property Type <span class="additional-info">{{ FormHelper::numberOfCheckboxesSelected('type') }}</span>
            </button>
            <div id="filterPropertyType" class="dropdown-menu stay-open" aria-labelledby="filterPropertyTypeBtn">
                @foreach (($pageType === 'buy' ? ListingHelper::getBuyTypes() : ListingHelper::getRentTypes()) as $type => $typeLabel)
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" id="propertyType{{ $loop->index }}" name="type[]" value="{{ $type }}" {{ FormHelper::checked('type', $type) }}>
                        <label class="custom-control-label" for="propertyType{{ $loop->index }}">{{ $typeLabel }}</label>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>