<nav id="mainNav" class="navbar navbar-expand-md px-0 navbar-main">
    <button class="hamburger hamburger-emphatic collapsed d-md-none" type="button" data-toggle="collapse" data-target="#mainNavToggle"
            aria-label="Toggle navigation" aria-expanded="false" aria-controls="mainNavToggle">
              <span class="hamburger-box">
                <span class="hamburger-inner"></span>
              </span>
    </button>
    <div class="container">
        <div class="collapse navbar-collapse justify-content-end" id="mainNavToggle">
            <ul class="navbar-nav mt-2 mt-md-0">
                <li class="nav-item">
                    <a class="nav-link px-md-6 px-md-0" href="#" title="Buy">Buy</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-md-6 px-md-0" href="#" title="Rent">Rent</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-md-6 px-md-0" href="#" title="Sell">Sell</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-md-6 px-md-0" href="#" title="Contact">Contact</a>
                </li>
            </ul>
            <form id="mainSearchForm" class="form-inline my-2 my-md-0" action="{{ route('listings') }}" method="GET">
                <div class="main-search">
                    <input class="form-control" type="search" aria-label="Search" name="q">
                    <button class="icn-search" type="submit" form="mainSearchForm" value="Submit"></button>
                </div>
            </form>
        </div>
    </div>
</nav>