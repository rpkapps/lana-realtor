<nav id="mainNav" class="navbar navbar-expand-md px-0 navbar-main">
    <button class="hamburger hamburger-emphatic collapsed d-md-none" type="button" data-toggle="collapse" data-target="#mainNavToggle"
            aria-label="Toggle navigation" aria-expanded="false" aria-controls="mainNavToggle">
              <span class="hamburger-box">
                <span class="hamburger-inner"></span>
              </span>
    </button>
    <div class="container">
        <a class="navbar-brand" href="/"><img src="https://s3-us-west-2.amazonaws.com/lana-realtor/images/logo.svg" alt="Lana Sells Delta" title="Lana Sells Delta"></a>
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
                    <a class="nav-link px-md-6 px-md-0" data-toggle="modal" data-target="#contactModel" title="Contact">Contact</a>
                </li>
            </ul>
        </div>

        <div class="modal fade" id="contactModel" tabindex="-1" role="dialog" aria-labelledby="contactModalLongTitle" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="contactModalLongTitle">Contact</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">.col-6</div>
                        <div class="col-md-6">
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
                                    <textarea class="form-control" id="inputHelpQuestion" rows="3" required> </textarea>
                                </div>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Submit</button>
                </div>
            </div>
          </div>
        </div>
    </div>
</nav>