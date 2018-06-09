@extends('layout.listing-item')
@section('title', 'Listings')
@section('content')
<div class="container">
	<div class="row listing-wrapper">
		<div class="col-lg-8 left-column">
			<div class="listing-main-img">
				<img src="{{ $listing['photos'][0] }}" class="img-fluid" alt="Responsive image">
				<a href="javascript:void(0);" class="gallery-icon d-flex d-lg-none" title="View image gallery.">
					<svg class="listing-gallery-icon" version="1.1" xmlns="http://www.w3.org/2000/svg" width="36" height="32" viewBox="0 0 36 32">
						<title>View image gallery.</title>
					<path fill="currentColor" d="M34 4h-2v-2c0-1.1-0.9-2-2-2h-28c-1.1 0-2 0.9-2 2v24c0 1.1 0.9 2 2 2h2v2c0 1.1 0.9 2 2 2h28c1.1 0 2-0.9 2-2v-24c0-1.1-0.9-2-2-2zM4 6v20h-1.996c-0.001-0.001-0.003-0.002-0.004-0.004v-23.993c0.001-0.001 0.002-0.003 0.004-0.004h27.993c0.001 0.001 0.003 0.002 0.004 0.004v1.996h-24c-1.1 0-2 0.9-2 2v0zM34 29.996c-0.001 0.001-0.002 0.003-0.004 0.004h-27.993c-0.001-0.001-0.003-0.002-0.004-0.004v-23.993c0.001-0.001 0.002-0.003 0.004-0.004h27.993c0.001 0.001 0.003 0.002 0.004 0.004v23.993z"></path>
				<path fill="currentColor" d="M30 11c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3z"></path>
			<path fill="currentColor" d="M32 28h-24v-4l7-12 8 10h2l7-6z"></path>
		</svg>
		<span>View gallery</span>
	</a>
</div>
<div class="listing-info-container">
	<div class="row">
		<div class="col-md-7">
			<h2 class="listing-type"> {{ SimplyRetsHelper::determineTitle($listing['property']['type']) }} </h2>
			<h1 class="listing-address">
			<span>{{ $listing['address']['full'] }},</span>
			<span>{{ $listing['address']['city'] }}, {{ $listing['address']['state'] }}, {{ $listing['address']['postalCode'] }}</span>
			</h1>
		</div>
		<div class="col-md-5 text-md-right">
			<h2 class="listing-price">${{ number_format($listing['listPrice']) }}</h2>
			<p class="listing-details">
				<strong>{{ $listing['property']['bedrooms'] }}</strong> beds
				<strong>{{ $listing['property']['bathrooms'] }}</strong> baths
				<strong>{{ number_format($listing['property']['area']) }}</strong> sqft
			</p>
		</div>
	</div>
	<div class="row">
		<div class="col-md-7">
			<div class="row">
				<div class="col-md">
					<div class="listing-description">
						{{ $listing['remarks'] }}
					</div>
				</div>
				<div class="w-100"></div>
				<div class="col-md">
					<div class="row">
						<div class="col-md-4">
							<div class="listing-feature">
								<h5 class="listing-feature-title">Type</h5>
								<p>{{ FormHelper::fallback($listing['property']['subType']) }}</p>
							</div>
						</div>
						<div class="col-md-4">
							<div class="listing-feature">
								<h5 class="listing-feature-title">Year Built</h5>
								<p>{{ FormHelper::fallback($listing['property']['yearBuilt']) }}</p>
							</div>
						</div>
						<div class="col-md-4">
							<div class="listing-feature">
								<h5 class="listing-feature-title">Heating</h5>
								<p>{{ FormHelper::fallback(str_replace(",", ", ", $listing['property']['heating'])) }}</p>
							</div>
						</div>
						<div class="w-100"> </div>
						<div class="col-md-4">
							<div class="listing-feature">
								<h5 class="listing-feature-title">Price/sqft</h5>
								<p>${{ FormHelper::fallback(number_format(SimplyRetsHelper::determineSqFtPrice($listing['listPrice'], $listing['property']['area']))) }}</p>
							</div>
						</div>
						<div class="col-md-4">
							<div class="listing-feature">
								<h5 class="listing-feature-title">Parking</h5>
								<p>{{ FormHelper::fallback(str_replace(",", ", ", $listing['property']['parking']['description'])) }}</p>
							</div>
						</div>
						<div class="col-md-4">
							<div class="listing-feature">
								<h5 class="listing-feature-title">Lot Size</h5>
								<p>{{ FormHelper::fallback($listing['property']['lotSizeAreaUnits'], ' Acres') }}</p>
							</div>
						</div>
						<div class="w-100"> </div>
						<div class="col-md-4">
							<div class="listing-feature">
								<h5 class="listing-feature-title">Cooling</h5>
								<p>{{ FormHelper::fallback($listing['property']['cooling']) }}</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-5 d-flex">
			<div class="listing-contact-container">
				<p class="text-center"> Contact Realtor </p>
				<form>
					<div class="form-group">
						<label for="inputFirstName">First Name</label>
						<input class="form-control" id="inputFirstName" type="text" placeholder="First Name" required>
					</div>
					<div class="form-group">
						<label for="inputLastName">Last Name</label>
						<input class="form-control" id="inputLastName" type="text" placeholder="Last Name" required>
					</div>
					<div class="form-group">
						<label for="inputPhoneNumber">Phone Number</label>
						<input class="form-control input-medium masked" id="inputPhoneNumber" name="phone_number" type="tel" title="xxx-xxx-xxxx" placeholder="xxx-xxx-xxxx" data-mask="000-000-0000" pattern="\d{3}[\-]\d{3}[\-]\d{4}" maxlength="14" required>
					</div>
					<div class="form-group">
						<label for="inputEmail">Email address</label>
						<input type="email" class="form-control" id="inputEmail" aria-describedby="emailHelp" placeholder="Email" required>
					</div>
					<div class="form-group">
						<label for="inputHelpQuestion">How can I help you?</label>
						<textarea class="form-control" id="inputHelpQuestion" rows="3" required>I am interested in {{ $listing['address']['full'] }}, {{ $listing['address']['city'] }}, {{ $listing['address']['state'] }}, {{ $listing['address']['postalCode'] }} </textarea>
					</div>
					<div class="text-right">
						<button type="submit" class="btn btn-secondary">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
</div>
<div class="col-lg-4 right-column d-none d-lg-block">
<h2 class="gallery-title">Image Gallery</h2>
<div class="gallery">
	<figure>
		<a href="{{ $listing['photos'][1] }}" class="gallery-thumbnail" style="background-image: url({{ $listing['photos'][1] }});"></a>
	</figure>
	<figure>
		<a href="{{ $listing['photos'][0] }}" class="gallery-thumbnail" style="background-image: url({{ $listing['photos'][0] }});"></a>
	</figure>
	<figure>
		<a href="{{ $listing['photos'][1] }}" class="gallery-thumbnail" style="background-image: url({{ $listing['photos'][1] }});"></a>
	</figure>
	<figure>
		<a href="{{ $listing['photos'][0] }}" class="gallery-thumbnail" style="background-image: url({{ $listing['photos'][0] }});"></a>
	</figure>
	<figure>
		<a href="{{ $listing['photos'][1] }}" class="gallery-thumbnail" style="background-image: url({{ $listing['photos'][1] }});"></a>
	</figure>
	<figure>
		<a href="{{ $listing['photos'][1] }}" class="gallery-thumbnail" style="background-image: url({{ $listing['photos'][1] }});"></a>
	</figure>
	<figure>
		<a href="{{ $listing['photos'][0] }}" class="gallery-thumbnail" style="background-image: url({{ $listing['photos'][0] }});"></a>
	</figure>
</div>
</div>
</div>
</div>
@endsection