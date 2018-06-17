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
		<li class="nav-item">
			<a class="nav-link" id="homeNavSell" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">SELL</a>
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
					<div class="input-group-append">
						<button class="btn btn-secondary" type="submit" form="homeSearchForm" value="Submit">Search</button>
					</div>
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