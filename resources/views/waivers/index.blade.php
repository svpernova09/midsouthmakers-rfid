@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Sign Waiver</div>
                    <div class="panel-body">
                        <p>
                            <a href="/sign-waiver/individual">
                                <button class="btn btn-primary">Individual Waiver</button>
                            </a>
                        </p>
                        <p>
                            <a href="/sign-waiver/dependent">
                                <button class="btn btn-primary">Dependent Waiver</button>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
@endsection
