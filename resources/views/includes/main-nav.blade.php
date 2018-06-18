<nav id="mainNav" class="navbar navbar-expand-md px-0 navbar-main">
    <button class="hamburger hamburger-emphatic collapsed d-md-none" type="button" data-toggle="collapse" data-target="#mainNavToggle"
            aria-label="Toggle navigation" aria-expanded="false" aria-controls="mainNavToggle">
              <span class="hamburger-box">
                <span class="hamburger-inner"></span>
              </span>
    </button>
    <div class="container">
        <a class="navbar-brand" href="/"><img src="https://s3.amazonaws.com/lana-realtor/images/logo.svg" alt="Lana Sells Delta" title="Lana Sells Delta"></a>
        <div class="collapse navbar-collapse justify-content-end" id="mainNavToggle">
            <ul class="navbar-nav mt-2 mt-md-0">
                <li class="nav-item">
                    <a class="nav-link px-md-6 px-md-0" href="{{ route('buy') }}" title="Buy">Buy</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-md-6 px-md-0" href="{{ route('rent') }}" title="Rent">Rent</a>
                </li>
                <li class="nav-item">
                    {{-- TODO: Update href--}}
                    <a class="nav-link px-md-6 px-md-0" href="#" title="Sell">Sell</a>
                </li>
                <li class="nav-item">
                    {{-- TODO: Update href--}}
                    <a class="nav-link px-md-6 px-md-0" href="#" title="Contact">Contact</a>
                </li>
            </ul>
        </div>
    </div>
</nav>