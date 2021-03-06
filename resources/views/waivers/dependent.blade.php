@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Sign Dependent Waiver</div>

                    <div class="card-body">
                        <form method="POST" id="waiver" action="/sign-waiver">
                            {{ csrf_field() }}
                            <div id="waiver_content" class="waiver_content">
                                <p>Between <input typ="text" name="between_name" size="35"> (your first and last name)
                                    and Midsouth Makers, NFP, 2804 Bartlett Rd. Suite 3, Memphis, TN 38134.</p>
                                <p>By signing this agreement I acknowledge that Midsouth Makers is a dangerous place and
                                    I agree to HOLD HARMLESS Midsouth Makers, NFP, its members, its officers, and its
                                    directors.</p>
                                <p>Initials: <input typ="text" name="initial_1" size="4"></p>
                                <p>I also understand that I am personally responsible for the safety and actions of my
                                    dependents and that I will ensure those individuals follow all safety instructions
                                    and signage while at Midsouth Makers.</p>
                                <p>Initials: <input typ="text" name="initial_2" size="4"></p>
                                <p>I affirm that I am 18 years of age or older, the parent or legal guardian of the
                                    dependents listed below, and mentally competent to sign this liability release.</p>
                                <p>Initials: <input typ="text" name="initial_3" size="4"></p>
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Your name"
                                           value="{{ old('name') }}">
                                </div>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" name="address" placeholder="Address"
                                           value="{{ old('address') }}">
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone number</label>
                                    <input type="text" class="form-control" name="phone" placeholder="Phone"
                                           value="{{ old('phone') }}">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" name="email" placeholder="Email"
                                           value="{{ old('email') }}">
                                </div>
                                <div class="form-group">
                                    <label for="contact_name">Emergency Contact Name</label>
                                    <input type="text" class="form-control" name="contact_name"
                                           placeholder="Emergency Contact Name" value="{{ old('contact_name') }}">
                                </div>
                                <div class="form-group">
                                    <label for="contact_phone">Contact Phone Number</label>
                                    <input type="text" class="form-control" name="contact_phone"
                                           placeholder="Contact Phone Number" value="{{ old('contact_phone') }}">
                                </div>
                                <div class="form-group">
                                    <label for="dependents">Dependents</label>
                                    <textarea type="text" class="form-control" name="dependents"
                                              placeholder="Dependent Names" value="{{ old('dependents') }}"></textarea>
                                </div>
                                <div id="signature-pad" class="m-signature-pad">
                                    <div class="m-signature-pad--body">
                                        <canvas></canvas>
                                        <input type="hidden" id="signature" name="signature">
                                    </div>
                                    <div class="m-signature-pad--footer">
                                        <div class="description">Sign and date above</div>
                                        <div class="right">
                                            <button type="button" id="save_btn" class="button save" data-action="save-png">Save
                                            </button>
                                            <button type="button" class="button clear" data-action="clear">Clear
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="/js/signature_pad.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            var wrapper = document.getElementById("signature-pad"),
                clearButton = wrapper.querySelector("[data-action=clear]"),
                savePNGButton = wrapper.querySelector("[data-action=save-png]"),
                canvas = wrapper.querySelector("canvas"),
                signaturePad;

            // Adjust canvas coordinate space taking into account pixel ratio,
            // to make it look crisp on mobile devices.
            // This also causes canvas to be cleared.
            function resizeCanvas() {
                // When zoomed out to less than 100%, for some very strange reason,
                // some browsers report devicePixelRatio as less than 1
                // and only part of the canvas is cleared then.
                var ratio = Math.max(window.devicePixelRatio || 1, 1);
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                canvas.getContext("2d").scale(ratio, ratio);
            }

            window.onresize = resizeCanvas;
            resizeCanvas();

            signaturePad = new SignaturePad(canvas);

            clearButton.addEventListener("click", function (event) {
                signaturePad.clear();
            });

            savePNGButton.addEventListener("click", function (event) {
                if (signaturePad.isEmpty()) {
                    alert("Please provide signature first.");
                } else {
//                    $('#signature-pad > div.m-signature-pad--footer > div.right > button.button.save').prop('disabled', true);
                    $('#signature').val(signaturePad.toDataURL());
                    var data = $("#waiver").serialize();
                    console.log(data);
                    $("#waiver").submit();
                }
            });
        });
    </script>
@endsection