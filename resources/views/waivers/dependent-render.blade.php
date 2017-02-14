<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style type="text/css">
    label {
        font-weight: bold;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Signed Dependent Waiver</div>
                <div class="panel-body">
                    <div id="waiver_content" class="waiver_content">
                        <p>Between {{ $between_name }} (your first and last name)
                            and Midsouth Makers, NFP, 2804 Bartlett Rd. Suite 3, Memphis, TN 38134.</p>
                        <p>By signing this agreement I acknowledge that Midsouth Makers is a dangerous place and
                            I agree to HOLD HARMLESS Midsouth Makers, NFP, its members, its officers, and its
                            directors.</p>
                        <p><label>Initials:</label> {{ $initial_1 }}</p>
                        <p>I also understand that I am personally responsible for the safety and actions of my
                            dependents and that I will ensure those individuals follow all safety instructions
                            and signage while at Midsouth Makers.</p>
                        <p><label>Initials:</label> {{ $initial_2 }}</p>
                        <p>I affirm that I am 18 years of age or older, the parent or legal guardian of the
                            dependents listed below, and mentally competent to sign this liability release.</p>
                        <p><label>Initials:</label> {{ $initial_3 }}</p>
                        <div class="form-group">
                            <label for="name">Name</label>
                            {{ $name }}
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            {{ $address }}
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone number</label>
                            {{ $phone }}
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            {{ $email }}
                        </div>
                        <div class="form-group">
                            <label for="contact_name">Emergency Contact Name</label>
                            {{ $contact_name }}
                        </div>
                        <div class="form-group">
                            <label for="contact_phone">Contact Phone Number</label>
                            {{ $contact_phone }}
                        </div>
                        <div class="form-group">
                            <label for="contact_phone">Dependents</label>
                            {{ $dependents }}
                        </div>
                        <div id="signature-pad" class="m-signature-pad">
                            <img src="{{ $signature }}" width="400px">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
