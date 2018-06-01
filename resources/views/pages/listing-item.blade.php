@extends('layout.listing-item')
@section('title', 'Listings')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-lg-8 left-column">
			<img src="{{ $listing['photos'][0] }}" class="img-fluid" alt="Responsive image">
			<div class="listing-info-container">
				<div class="row">
					<div class="col-md-7">
						<h2 class="listing-type"> {{ SimplyRetsHelper::determineTitle($listing['property']['type']) }} </h2>
						<h1 class="listing-address"> 
							<span>{{ $listing['address']['full'] }},</span>
							<span>{{ $listing['address']['city'] }}, {{ $listing['address']['state'] }}, {{ $listing['address']['postalCode'] }}</span>
						</h1>				
					</div>
					<div class="col-md-5 text-right">
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
											<p>{{ $listing['property']['subType'] }}</p>
										</div>
									</div>
									<div class="col-md-4">
										<div class="listing-feature">
											<h5 class="listing-feature-title">Year Built</h5>
											<p>{{ $listing['property']['yearBuilt'] }}</p>
										</div>							
									</div>
									<div class="col-md-4">
										<div class="listing-feature">
											<h5 class="listing-feature-title">Heating</h5>
											<p>{{ $listing['property']['heating'] }}</p>
										</div>								
									</div>
									<div class="w-100"> </div>
									<div class="col-md-4">
										<div class="listing-feature">
											<h5 class="listing-feature-title">Price/sqft</h5>
											<p>${{ number_format(SimplyRetsHelper::determineSqFtPrice($listing['listPrice'], $listing['property']['area'])) }}</p>
										</div>
									</div>
									<div class="col-md-4">
										<div class="listing-feature">
											<h5 class="listing-feature-title">Parking</h5>
											<p>{{ $listing['property']['parking']['description']}}</p>
										</div>
									</div>
									<div class="col-md-4">
										<div class="listing-feature">
											<h5 class="listing-feature-title">Lot Size</h5>
											<p>{{ $listing['property']['lotSizeAreaUnits'] }} Acres</p>
										</div>
									</div>
									<div class="w-100"> </div>
									<div class="col-md-4">
										<div class="listing-feature">
											<h5 class="listing-feature-title">Cooling</h5>
											<p>{{ $listing['property']['cooling'] }}</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-5">
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
								<button type="submit" class="btn btn-primary">Submit</button>
							</form>
						</div>		
					</div>
				</div>
			</div>	
		</div>
		<div class="col-lg-4 right-column">
			<div class="row">
				<div class="col-md">
					<img src="{{ $listing['photos'][0] }}"" class="img-fluid" alt="Responsive image">
					<img src="{{ $listing['photos'][1] }}"" class="img-fluid" alt="Responsive image">
					<img src="{{ $listing['photos'][0] }}"" class="img-fluid" alt="Responsive image">
					<img src="{{ $listing['photos'][1] }}"" class="img-fluid" alt="Responsive image">
					<img src="{{ $listing['photos'][0] }}"" class="img-fluid" alt="Responsive image">
				</div>
				<div class="col-md">
					<img src="{{ $listing['photos'][1] }}"" class="img-fluid" alt="Responsive image">
					<img src="{{ $listing['photos'][0] }}"" class="img-fluid" alt="Responsive image">
					<img src="{{ $listing['photos'][1] }}"" class="img-fluid" alt="Responsive image">
					<img src="{{ $listing['photos'][1] }}"" class="img-fluid" alt="Responsive image">
					<img src="{{ $listing['photos'][0] }}"" class="img-fluid" alt="Responsive image">
					<img src="{{ $listing['photos'][1] }}"" class="img-fluid" alt="Responsive image">
				</div>
			</div>
		</div>
	</div>
</div>

@endsection