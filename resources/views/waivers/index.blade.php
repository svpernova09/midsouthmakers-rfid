@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Sign Waiver</div>

                    <div class="card-body">
                        <p>
                            All visitors to the MidsouthMakers location are required to sign a short waiver.
                        </p>
                        <p class="pull-left">
                            <a href="/sign-waiver/individual">
                                <button class="btn btn-primary">Individual Waiver</button>
                            </a>
                        </p>
                        <p class="pull-right">
                            <a href="/sign-waiver/dependent">
                                <button class="btn btn-primary">Dependent Waiver</button>
                            </a>
                        </p>
                    </div>
                    <div class="panel-body">
                        <p>
                            <h4>Privacy Policy</h4>
                            MidsouthMakers.org will never share your information with any 3rd parties.
                        </p>
                    </div>
                </div>
            </div>
        </div>
@endsection
