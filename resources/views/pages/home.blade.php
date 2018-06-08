@extends('layout.main-page')
@section('title', 'Homepage')
@section('content')
<div class="homepage-background"> </div>
<nav class="homepage-tabs">
	<ul class="nav nav-tabs" id="myTab" role="tablist">
		<li class="nav-item">
			<a class="nav-link active" id="homepage-nav-buy" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">BUY</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" id="homepage-nav-rent" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">RENT</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" id="homepage-nav-sell" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">SELL</a>
		</li>
	</ul>
</nav>
<div class="homepage-nav-background">
	<nav id="homepageNav" class="navbar px-0 homepage-nav">
		<div class="container">
			<div class="navbar-inner">
				<form id="homeSearchForm" class="input-group home-search" action="">
					<input id="homeSearch" type="text" class="form-control" placeholder="Enter a city" aria-label="Enter a city"
					aria-describedby="basic-addon" name="q" value="{{ FormHelper::value('q') }}">
					<div class="input-group-append">
						<button class="btn btn-secondary" type="submit" form="homeSearchForm" value="Submit">Search</button>
					</div>
				</form>

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
	</nav>
</div>

<div id="featureListings" class="card-listings feature-listings"></div>

@endsection