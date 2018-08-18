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
                    <a class="nav-link px-md-6 px-md-0" href="javascript:void(0);" data-toggle="modal" data-target="#contactModal" title="Contact">Contact</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="modal fade contact-modal" id="contactModal" tabindex="-1" role="dialog" aria-labelledby="contactModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form class="contact-form modal-content" id="mainContactForm">
            <div class="modal-header">
                <h2 class="modal-title" id="contactModalLongTitle">Contact</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="contact-profiles">
                            <div class="contact-profile">
                                <img class="contact-photo" src="https://s3-us-west-2.amazonaws.com/lana-realtor/images/lana-kulikovskiy.jpg" alt="Lana Kulikovskiy">
                                <h3 class="contact-name">Lana Kulikovskiy</h3>
                                <a class="contact-phone" href="tel:1-907-322-9997" title="Call Lana Kulikovskiy">907-322-9997</a>
                            </div>
                            <div class="contact-profile">
                                <img class="contact-photo" src="https://s3-us-west-2.amazonaws.com/lana-realtor/images/leah.jpg" alt="Leah">
                                <h3 class="contact-name">Leah</h3>
                                <span class="contact-phone"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label for="inputContactFirstName">First Name</label>
                            <input class="form-control" id="inputContactFirstName" type="text" placeholder="First Name" name="firstName" required>
                        </div>
                        <div class="form-group">
                            <label for="inputContactLastName">Last Name</label>
                            <input class="form-control" id="inputContactLastName" type="text" placeholder="Last Name" name="lastName" required>
                        </div>
                        <div class="form-group">
                            <label for="inputContactPhoneNumber">Phone Number</label>
                            <input class="form-control input-medium masked" id="inputContactPhoneNumber" name="phoneNumber" type="tel" title="xxx-xxx-xxxx" placeholder="xxx-xxx-xxxx" data-mask="000-000-0000" pattern="\d{3}[\-]\d{3}[\-]\d{4}" maxlength="14" required>
                        </div>
                        <div class="form-group">
                            <label for="inputContactEmail">Email Address</label>
                            <input type="email" class="form-control" id="inputContactEmail" aria-describedby="emailHelp" placeholder="Email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="inputContactHelpQuestion">How can I help you?</label>
                            <textarea class="form-control" id="inputContactHelpQuestion" rows="3" name="body" required> </textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-secondary">Submit</button>
            </div>
        </form>
    </div>
</div>