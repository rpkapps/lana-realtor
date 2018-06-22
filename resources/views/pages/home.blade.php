@extends('layout.main-page')
@section('title', 'Homepage')
@section('content')
<div class="home-background"> </div>
<nav class="home-tabs">
	<ul class="nav nav-tabs" id="homeNavTabs" role="tablist">
		<li class="nav-item">
			<a class="nav-link active" id="homeNavBuy" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">BUY</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" id="homeNavRent" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">RENT</a>
		</li>
	</ul>
</nav>
<div class="home-nav-background">
	<nav id="homeNav" class="navbar home-nav">
		<div class="container">
			<div class="navbar-inner">
				<form id="homeSearchForm" class="input-group home-search" action="">
					<input id="homeSearch" type="text" class="form-control" placeholder="Enter an address, city, or ZIP code" aria-label="Enter an address, city, or ZIP code"
					aria-describedby="basic-addon" name="q" value="{{ FormHelper::value('q') }}">
					<button class="btn btn-secondary" type="submit" form="homeSearchForm" value="Submit">
						<svg class="d-inline-block d-sm-none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
							<path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"/>
						</svg>
						<span class="d-none d-sm-inline">Search</span>
					</button>
				</form>

				<div id="homeCheckboxes" class="home-checkboxes">
					<div class="custom-control custom-checkbox">
						<input class="custom-control-input" type="checkbox" id="homeListingType1" name="type[]" value="residential" {{ FormHelper::checked('type', 'residential') }}>
						<label class="custom-control-label" for="homeListingType1">Residential</label>
					</div>
					<div class="custom-control custom-checkbox">
						<input class="custom-control-input" type="checkbox" id="homeListingType2" name="type[]" value="multifamily" {{ FormHelper::checked('type', 'multifamily') }}>
						<label class="custom-control-label" for="homeListingType2">Multi-Family</label>
					</div>
					<div class="custom-control custom-checkbox">
						<input class="custom-control-input" type="checkbox" id="homeListingType3" name="type[]" value="land" {{ FormHelper::checked('type', 'land') }}>
						<label class="custom-control-label" for="homeListingType3">Vacant Land</label>
					</div>
					<div class="custom-control custom-checkbox">
						<input class="custom-control-input" type="checkbox" id="homeListingType4" name="type[]" value="commercial" {{ FormHelper::checked('type', 'commercial') }}>
						<label class="custom-control-label" for="homeListingType4">Commercial</label>
					</div>
				</div>
			</div>
		</div>
	</nav>
</div>

<div id="homeListings" class="card-listings home-listings"></div>

@endsection