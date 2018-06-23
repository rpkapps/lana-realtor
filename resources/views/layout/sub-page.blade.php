<html>

@include('includes.head')

<body class="bg-bluishlight">

    <div class="wrapper">
        @include('includes.main-nav')
        <div class="container">
            <h1 class="page-title">@yield('title')</h1>
        </div>
        @include('includes.secondary-nav')

        <div class="container">
            @include('includes.filter-bar')
            @yield('content')
        </div>
    </div>

    @include('includes.footer')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="{{ mix('/js/listings.js') }}"></script>

</body>

</html>