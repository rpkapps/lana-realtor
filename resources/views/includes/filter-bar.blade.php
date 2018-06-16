<div class="btn-group filter-bar" role="group" aria-label="Button group with nested dropdown">
    <div class="btn-group" role="group">
        <button id="filterPriceBtn" type="button" class="btn btn-outline-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Price
        </button>
        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
            <form>
                <div class="form-row">
                    <div id="filterMinPrice" class="col">
                        <input type="text" class="form-control dropdown-item" name="minprice" value="{{ FormHelper::value('minprice') }}" placeholder="Min Price">
                    </div>
                    <div id="filterMaxPrice" class="col">
                        <input type="text" class="form-control dropdown-item" name="maxprice" value="{{ FormHelper::value('maxprice') }}" placeholder="Max Price">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="btn-group" role="group">
        <button id="filterAreaBtn" type="button" class="btn btn-outline-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Area
        </button>
        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
            <form>
                <div class="form-row">
                    <div id="filterMinArea" class="col">
                        <input type="text" class="form-control dropdown-item" name="minarea" value="{{ FormHelper::value('minarea') }}" placeholder="Min Area">
                    </div>
                    <div id="filterMaxArea" class="col">
                        <input type="text" class="form-control dropdown-item" name="maxarea" value="{{ FormHelper::value('maxarea') }}" placeholder="Max Area">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="btn-group" role="group">
        <button id="filterBdrmsBtn" type="button" class="btn btn-outline-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Beds
        </button>
        <div id="filterBdrms" class="dropdown-menu" aria-labelledby="filterBdrmsBtn">
            @for ($i=0; $i<6; $i++)
                <a class="dropdown-item {{ FormHelper::activeClass('minbeds', $i) }}" href="javascript:void(0)" data-value="{{ $i }}">{{ $i }}
                    +</a>
            @endfor
        </div>
    </div>
    <div class="btn-group" role="group">
        <button id="filterBathsBtn" type="button" class="btn btn-outline-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Baths
        </button>
        <div id="filterBaths" class="dropdown-menu" aria-labelledby="filterBathsBtn">
            @for ($i=0; $i<6; $i++)
                <a class="dropdown-item {{ FormHelper::activeClass('minbaths', $i) }}" href="javascript:void(0)" data-value="{{ $i }}">{{ $i }}
                    +</a>
            @endfor
        </div>
    </div>
    <div class="btn-group" role="group">
        <button id="filterHomeTypeBtn" type="button" class="btn btn-outline-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Home Type
        </button>
        <div id="filterHomeType" class="dropdown-menu" aria-labelledby="filterHomeTypeBtn">
            @foreach (SimplyRetsHelper::getSubType() as $subType => $cleanSubType)
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" type="checkbox" id="listingSubType{{ $loop->index }}" name="subtype[]" value="{{ $subType }}" {{ FormHelper::checked('type', $subType) }}>
                    <label class="custom-control-label" for="listingSubType{{ $loop->index }}">{{ $cleanSubType }}</label>
                </div>
            @endforeach
        </div>
    </div>
</div>
